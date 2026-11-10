<?php

namespace App\Http\Controllers\ManagerGudang;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockOutController extends Controller
{
    /**
     * Menampilkan daftar barang keluar Manager Gudang.
     */
    public function index()
    {
        $transactions = StockTransaction::with([
            'product'
        ])
        ->where('type', 'out')
        ->latest()
        ->paginate(10);

        return view(
            'manager-gudang.stock.keluar',
            compact('transactions')
        );
    }


    /**
     * Menampilkan form tambah barang keluar.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view(
            'manager-gudang.stock.keluar',
            compact('products')
        );
    }


    /**
     * Menyimpan barang keluar.
     */
    public function store(Request $request)
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
                'Jumlah barang wajib diisi.',

            'quantity.integer' =>
                'Jumlah barang harus berupa angka.',

            'quantity.min' =>
                'Jumlah barang minimal 1.',
        ]);


        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | AMBIL PRODUK
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

            if (
                class_exists(ActivityLog::class)
            ) {

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
            ->route('manager-gudang.stok.keluar')
            ->with(
                'success',
                'Barang keluar berhasil dicatat.'
            );
    }


    /**
     * Menampilkan detail barang keluar.
     */
    public function show($id)
    {
        $transaction =
            StockTransaction::with([
                'product'
            ])
            ->where('type', 'out')
            ->findOrFail($id);


        return view(
            'manager-gudang.stock.keluar',
            compact('transaction')
        );
    }
}