<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STOK MASUK
    |--------------------------------------------------------------------------
    */

    /**
     * Menampilkan halaman stok masuk Admin.
     */
    public function in()
    {
        // Ambil data produk untuk dropdown form
        $products = Product::orderBy('name')->get();

        // Gunakan paginate(), BUKAN get()
        // karena Blade menggunakan firstItem(), lastItem(), links(), dll.
        $transactions = StockTransaction::with([
            'product',
            'supplier'
        ])
        ->where('type', 'in')
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('stock.in', compact(
            'products',
            'transactions'
        ));
    }


    /**
     * Menyimpan transaksi stok masuk.
     */
    public function storeIn(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'exists:products,id'
            ],

            'supplier_id' => [
                'nullable',
                'exists:suppliers,id'
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],

            'reference_number' => [
                'nullable',
                'string',
                'max:255'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'received_at' => [
                'nullable',
                'date'
            ],
        ], [
            'product_id.required' =>
                'Produk wajib dipilih.',

            'product_id.exists' =>
                'Produk tidak ditemukan.',

            'supplier_id.exists' =>
                'Supplier tidak ditemukan.',

            'quantity.required' =>
                'Jumlah wajib diisi.',

            'quantity.integer' =>
                'Jumlah harus berupa angka.',

            'quantity.min' =>
                'Jumlah minimal 1.',

            'reference_number.max' =>
                'Nomor referensi maksimal 255 karakter.',

            'received_at.date' =>
                'Tanggal penerimaan tidak valid.',
        ]);


        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | CARI PRODUK
            |--------------------------------------------------------------------------
            */

            $product = Product::lockForUpdate()
                ->findOrFail(
                    $validated['product_id']
                );


            /*
            |--------------------------------------------------------------------------
            | TAMBAH STOK
            |--------------------------------------------------------------------------
            */

            $product->increment(
                'stock',
                $validated['quantity']
            );


            /*
            |--------------------------------------------------------------------------
            | SIMPAN TRANSAKSI
            |--------------------------------------------------------------------------
            */

            StockTransaction::create([
                'product_id' =>
                    $product->id,

                'supplier_id' =>
                    $validated['supplier_id'] ?? null,

                'type' =>
                    'in',

                'quantity' =>
                    $validated['quantity'],

                'reference_number' =>
                    $validated['reference_number'] ?? null,

                'description' =>
                    $validated['description'] ?? null,

                'received_at' =>
                    $validated['received_at'] ?? now(),

                'status' =>
                    'confirmed',
            ]);


            /*
            |--------------------------------------------------------------------------
            | ACTIVITY LOG
            |--------------------------------------------------------------------------
            */

            if (class_exists(ActivityLog::class)) {

                ActivityLog::create([
                    'user_id' =>
                        Auth::id(),

                    'action' =>
                        'Menambahkan stok masuk produk '
                        . $product->name
                        . ' sebanyak '
                        . $validated['quantity'],
                ]);
            }
        });


        return redirect()
            ->route('stok.masuk')
            ->with(
                'success',
                'Stok masuk berhasil dicatat.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | STOK KELUAR
    |--------------------------------------------------------------------------
    */

    /**
     * Menampilkan halaman stok keluar Admin.
     */
    public function out()
    {
        // Produk untuk dropdown
        $products = Product::orderBy('name')->get();

        // Pagination agar Blade dapat menggunakan firstItem()
        $transactions = StockTransaction::with([
            'product'
        ])
        ->where('type', 'out')
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('stock.out', compact(
            'products',
            'transactions'
        ));
    }


    /**
     * Menyimpan transaksi stok keluar.
     */
    public function storeOut(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'exists:products,id'
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],

            'reference_number' => [
                'nullable',
                'string',
                'max:255'
            ],

            'description' => [
                'nullable',
                'string'
            ],
        ], [
            'product_id.required' =>
                'Produk wajib dipilih.',

            'product_id.exists' =>
                'Produk tidak ditemukan.',

            'quantity.required' =>
                'Jumlah wajib diisi.',

            'quantity.integer' =>
                'Jumlah harus berupa angka.',

            'quantity.min' =>
                'Jumlah minimal 1.',

            'reference_number.max' =>
                'Nomor referensi maksimal 255 karakter.',
        ]);


        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | CARI PRODUK
            |--------------------------------------------------------------------------
            */

            $product = Product::lockForUpdate()
                ->findOrFail(
                    $validated['product_id']
                );


            /*
            |--------------------------------------------------------------------------
            | CEK STOK
            |--------------------------------------------------------------------------
            */

            if (
                $product->stock <
                $validated['quantity']
            ) {

                throw ValidationException::withMessages([
                    'quantity' =>
                        'Stok tidak mencukupi. '
                        . 'Stok tersedia: '
                        . $product->stock
                        . ' '
                        . ($product->unit ?? ''),
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | KURANGI STOK
            |--------------------------------------------------------------------------
            */

            $product->decrement(
                'stock',
                $validated['quantity']
            );


            /*
            |--------------------------------------------------------------------------
            | SIMPAN TRANSAKSI
            |--------------------------------------------------------------------------
            */

            StockTransaction::create([
                'product_id' =>
                    $product->id,

                'type' =>
                    'out',

                'quantity' =>
                    $validated['quantity'],

                'reference_number' =>
                    $validated['reference_number'] ?? null,

                'description' =>
                    $validated['description'] ?? null,

                'status' =>
                    'confirmed',
            ]);


            /*
            |--------------------------------------------------------------------------
            | ACTIVITY LOG
            |--------------------------------------------------------------------------
            */

            if (class_exists(ActivityLog::class)) {

                ActivityLog::create([
                    'user_id' =>
                        Auth::id(),

                    'action' =>
                        'Mengeluarkan stok produk '
                        . $product->name
                        . ' sebanyak '
                        . $validated['quantity'],
                ]);
            }
        });


        return redirect()
            ->route('stok.keluar')
            ->with(
                'success',
                'Stok keluar berhasil dicatat.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | RIWAYAT TRANSAKSI
    |--------------------------------------------------------------------------
    */

    /**
     * Menampilkan seluruh riwayat transaksi stok.
     */
    public function history()
    {
        // Pagination agar cocok dengan Blade
        $transactions = StockTransaction::with([
            'product',
            'supplier'
        ])
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view(
            'stock.history',
            compact('transactions')
        );
    }
}