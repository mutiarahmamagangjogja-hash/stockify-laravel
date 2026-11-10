<?php

namespace App\Http\Controllers\StaffGudang;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StaffGudangStockController extends Controller
{
    /**
     * ============================================================
     * BARANG MASUK
     * ============================================================
     */

    public function masuk()
    {
        $transactions = StockTransaction::with([
            'product',
            'supplier',
        ])
        ->where('type', 'in')
        ->latest()
        ->get();

        return view(
            'staff-gudang.stock.masuk',
            compact('transactions')
        );
    }


    /**
     * ============================================================
     * FORM CATAT BARANG MASUK
     * ============================================================
     */

    public function createMasuk()
    {
        $products = Product::where('status', 'active')
            ->orderBy('name')
            ->get();

        $suppliers = Supplier::where('status', true)
            ->orderBy('name')
            ->get();

        return view(
            'staff-gudang.stock.masuk-create',
            compact(
                'products',
                'suppliers'
            )
        );
    }


    /**
     * ============================================================
     * SIMPAN CATATAN BARANG MASUK
     * ============================================================
     */

    public function storeMasuk(Request $request)
    {
        $validated = $request->validate([
            'product_type' => [
                'required',
                'in:existing,new',
            ],

            'product_id' => [
                'nullable',
                'exists:products,id',
            ],

            'product_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sku' => [
                'nullable',
                'string',
                'max:255',
            ],

            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'unit' => [
                'nullable',
                'string',
                'max:50',
            ],

            'purchase_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'supplier_id' => [
                'nullable',
                'exists:suppliers,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'received_at' => [
                'required',
                'date',
            ],

            'reference_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);


        if (
            $validated['product_type'] === 'existing'
            && empty($validated['product_id'])
        ) {
            throw ValidationException::withMessages([
                'product_id' =>
                    'Silakan pilih produk yang sudah terdaftar.',
            ]);
        }


        if (
            $validated['product_type'] === 'new'
            && empty($validated['product_name'])
        ) {
            throw ValidationException::withMessages([
                'product_name' =>
                    'Nama produk baru wajib diisi.',
            ]);
        }


        $transaction = DB::transaction(
            function () use ($validated) {

                /*
                |--------------------------------------------------------------------------
                | PRODUK SUDAH ADA
                |--------------------------------------------------------------------------
                */

                if (
                    $validated['product_type'] === 'existing'
                ) {

                    $product = Product::lockForUpdate()
                        ->findOrFail(
                            $validated['product_id']
                        );

                }

                /*
                |--------------------------------------------------------------------------
                | PRODUK BARU
                |--------------------------------------------------------------------------
                */

                else {

                    if (
                        empty($validated['sku'])
                    ) {

                        throw ValidationException::withMessages([
                            'sku' =>
                                'SKU produk baru wajib diisi.',
                        ]);

                    }


                    if (
                        Product::where(
                            'sku',
                            $validated['sku']
                        )->exists()
                    ) {

                        throw ValidationException::withMessages([
                            'sku' =>
                                'SKU tersebut sudah digunakan.',
                        ]);

                    }


                    $product = Product::create([
                        'name' =>
                            $validated['product_name'],

                        'sku' =>
                            $validated['sku'],

                        'category_id' =>
                            $validated['category_id'] ?? null,

                        'price' =>
                            $validated['price'] ?? 0,

                        'purchase_price' =>
                            $validated['purchase_price'] ?? 0,

                        /*
                        | Stok belum ditambahkan.
                        | Akan ditambahkan setelah dikonfirmasi.
                        */

                        'stock' => 0,

                        'minimum_stock' => 0,

                        'unit' =>
                            $validated['unit'] ?? 'pcs',

                        'status' => 'active',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | SIMPAN TRANSAKSI
                |--------------------------------------------------------------------------
                */

                return StockTransaction::create([
                    'product_id' =>
                        $product->id,

                    'supplier_id' =>
                        $validated['supplier_id'] ?? null,

                    'type' =>
                        'in',

                    'quantity' =>
                        $validated['quantity'],

                    'description' =>
                        $validated['description'] ?? null,

                    'reference_number' =>
                        $validated['reference_number'] ?? null,

                    'status' =>
                        'pending',

                    'notes' =>
                        null,

                    'received_at' =>
                        $validated['received_at'],
                ]);
            }
        );


        return redirect()
            ->route(
                'staff-gudang.stok.masuk'
            )
            ->with(
                'success',
                'Pencatatan barang masuk berhasil dibuat. Silakan lakukan pemeriksaan barang.'
            );
    }


    /**
     * ============================================================
     * KONFIRMASI BARANG MASUK
     * ============================================================
     */

    public function konfirmasiMasuk(
        Request $request,
        StockTransaction $transaction
    ) {

        $validated = $request->validate([
            'status' => [
                'required',
                'in:confirmed,rejected',
            ],

            'name_match' => [
                'required',
                'boolean',
            ],

            'attribute_match' => [
                'required',
                'boolean',
            ],

            'quantity_match' => [
                'required',
                'boolean',
            ],

            'condition' => [
                'required',
                'string',
                'max:255',
            ],

            'inspection_notes' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        if ($transaction->type !== 'in') {

            return back()
                ->with(
                    'error',
                    'Transaksi bukan barang masuk.'
                );
        }


        if (
            !in_array(
                $transaction->status,
                ['pending', 'menunggu']
            )
        ) {

            return back()
                ->with(
                    'error',
                    'Transaksi sudah diproses.'
                );
        }


        DB::transaction(
            function () use (
                $validated,
                $transaction
            ) {

                $transaction->update([

                    'status' =>
                        $validated['status'],

                    'name_match' =>
                        $validated['name_match'],

                    'attribute_match' =>
                        $validated['attribute_match'],

                    'quantity_match' =>
                        $validated['quantity_match'],

                    'condition' =>
                        $validated['condition'],

                    'inspection_notes' =>
                        $validated['inspection_notes'] ?? null,

                    'notes' =>
                        $validated['notes'] ?? null,
                ]);


                /*
                |--------------------------------------------------------------------------
                | JIKA SESUAI
                |--------------------------------------------------------------------------
                */

                if (
                    $validated['status'] === 'confirmed'
                ) {

                    $product = Product::lockForUpdate()
                        ->findOrFail(
                            $transaction->product_id
                        );


                    $product->increment(
                        'stock',
                        $transaction->quantity
                    );
                }
            }
        );


        if (
            $validated['status'] === 'confirmed'
        ) {

            return redirect()
                ->route(
                    'staff-gudang.stok.masuk'
                )
                ->with(
                    'success',
                    'Barang berhasil dikonfirmasi dan stok telah diperbarui.'
                );
        }


        return redirect()
            ->route(
                'staff-gudang.stok.masuk'
            )
            ->with(
                'success',
                'Barang ditandai tidak sesuai dan hasil pemeriksaan telah disimpan.'
            );
    }


    /**
     * ============================================================
     * BARANG KELUAR
     * ============================================================
     */

    public function keluar()
    {
        $transactions = StockTransaction::with('product')
            ->where('type', 'out')
            ->latest()
            ->get();

        return view(
            'staff-gudang.stock.keluar',
            compact('transactions')
        );
    }


    /**
     * ============================================================
     * KONFIRMASI BARANG KELUAR
     * ============================================================
     */

    public function konfirmasiKeluar(
        Request $request,
        StockTransaction $transaction
    ) {

        $validated = $request->validate([
            'status' => [
                'required',
                'in:confirmed,rejected',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        if ($transaction->type !== 'out') {

            return back()
                ->with(
                    'error',
                    'Transaksi bukan barang keluar.'
                );
        }


        if (
            !in_array(
                $transaction->status,
                ['pending', 'menunggu']
            )
        ) {

            return back()
                ->with(
                    'error',
                    'Transaksi sudah diproses.'
                );
        }


        DB::transaction(
            function () use (
                $validated,
                $transaction
            ) {

                if (
                    $validated['status'] === 'confirmed'
                ) {

                    $product = Product::lockForUpdate()
                        ->findOrFail(
                            $transaction->product_id
                        );


                    if (
                        $product->stock <
                        $transaction->quantity
                    ) {

                        throw ValidationException::withMessages([
                            'status' =>
                                'Stok tidak mencukupi.',
                        ]);
                    }


                    $product->decrement(
                        'stock',
                        $transaction->quantity
                    );
                }


                $transaction->update([
                    'status' =>
                        $validated['status'],

                    'notes' =>
                        $validated['notes'] ?? null,
                ]);
            }
        );


        return redirect()
            ->route(
                'staff-gudang.stok.keluar'
            )
            ->with(
                'success',
                'Transaksi barang keluar berhasil diproses.'
            );
    }
}