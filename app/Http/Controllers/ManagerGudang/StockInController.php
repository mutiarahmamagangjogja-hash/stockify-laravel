<?php

namespace App\Http\Controllers\ManagerGudang;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    /**
     * Menampilkan daftar barang masuk Manager Gudang.
     */
    public function index()
    {
        $transactions = StockTransaction::with([
            'product',
            'supplier'
        ])
        ->where('type', 'in')
        ->latest()
        ->paginate(10);

        return view(
            'manager-gudang.stock.masuk',
            compact('transactions')
        );
    }


    /**
     * Menampilkan form tambah barang masuk.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();

        $suppliers = Supplier::orderBy('name')->get();

        return view(
            'manager-gudang.stock.masuk',
            compact(
                'products',
                'suppliers'
            )
        );
    }


    /**
     * Menyimpan barang masuk.
     */
    public function store(Request $request)
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

            if (
                class_exists(ActivityLog::class)
            ) {

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
            ->route('manager-gudang.stok.masuk')
            ->with(
                'success',
                'Barang masuk berhasil dicatat.'
            );
    }


    /**
     * Menampilkan detail barang masuk.
     */
    public function show($id)
    {
        $transaction =
            StockTransaction::with([
                'product',
                'supplier'
            ])
            ->where('type', 'in')
            ->findOrFail($id);


        return view(
            'manager-gudang.stock.masuk',
            compact('transaction')
        );
    }
}