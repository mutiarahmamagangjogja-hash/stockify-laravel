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
    /*
    |--------------------------------------------------------------------------
    | BARANG MASUK
    |--------------------------------------------------------------------------
    */

    /**
     * Menampilkan daftar barang masuk
     * yang masih menunggu pemeriksaan.
     */
    public function masuk()
    {
        $transactions = StockTransaction::with([
            'product',
            'supplier'
        ])
        ->where('type', 'in')
        ->whereIn('status', [
            'pending',
            'menunggu'
        ])
        ->latest()
        ->get();

        return view(
            'staff-gudang.stock.masuk',
            compact('transactions')
        );
    }


    /**
     * Form pencatatan barang masuk.
     */
    public function tambahMasuk()
    {
        $products = Product::where(
            'status',
            'active'
        )
        ->orderBy(
            'name'
        )
        ->get();


        $suppliers = Supplier::where(
            'status',
            true
        )
        ->orderBy(
            'name'
        )
        ->get();


        return view(
            'staff-gudang.stock.masuk-tambah',
            compact(
                'products',
                'suppliers'
            )
        );
    }


    /**
     * Menyimpan pencatatan barang masuk.
     *
     * Stok BELUM ditambahkan.
     * Status transaksi = pending.
     */
    public function simpanMasuk(Request $request)
    {
        $validated = $request->validate([
            'product_option' => [
                'required',
                'in:existing,new'
            ],

            'product_id' => [
                'nullable',
                'exists:products,id'
            ],

            'product_name' => [
                'nullable',
                'string',
                'max:255'
            ],

            'sku' => [
                'nullable',
                'string',
                'max:255'
            ],

            'category_id' => [
                'nullable',
                'exists:categories,id'
            ],

            'unit' => [
                'nullable',
                'string',
                'max:50'
            ],

            'purchase_price' => [
                'nullable',
                'numeric',
                'min:0'
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

            'received_at' => [
                'required',
                'date'
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
        ]);


        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | PRODUK SUDAH ADA
            |--------------------------------------------------------------------------
            */

            if (
                $validated['product_option']
                ===
                'existing'
            ) {

                if (
                    empty(
                        $validated['product_id']
                    )
                ) {

                    throw ValidationException::withMessages([
                        'product_id' =>
                            'Produk wajib dipilih.'
                    ]);
                }


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
                    empty(
                        $validated['product_name']
                    )
                ) {

                    throw ValidationException::withMessages([
                        'product_name' =>
                            'Nama produk baru wajib diisi.'
                    ]);
                }


                if (
                    empty(
                        $validated['sku']
                    )
                ) {

                    throw ValidationException::withMessages([
                        'sku' =>
                            'SKU produk baru wajib diisi.'
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | CEK SKU
                |--------------------------------------------------------------------------
                */

                $skuExists = Product::where(
                    'sku',
                    $validated['sku']
                )->exists();


                if ($skuExists) {

                    throw ValidationException::withMessages([
                        'sku' =>
                            'SKU tersebut sudah digunakan.'
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | BUAT PRODUK BARU
                |--------------------------------------------------------------------------
                */

                $product = Product::create([
                    'name' =>
                        $validated['product_name'],

                    'sku' =>
                        $validated['sku'],

                    'category_id' =>
                        $validated['category_id']
                        ?? null,

                    'purchase_price' =>
                        $validated['purchase_price']
                        ?? 0,

                    'price' =>
                        0,

                    'stock' =>
                        0,

                    'minimum_stock' =>
                        0,

                    'unit' =>
                        $validated['unit']
                        ?? 'pcs',

                    'status' =>
                        'active',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN TRANSAKSI
            |--------------------------------------------------------------------------
            */

            StockTransaction::create([
                'product_id' =>
                    $product->id,

                'supplier_id' =>
                    $validated['supplier_id']
                    ?? null,

                'type' =>
                    'in',

                'quantity' =>
                    $validated['quantity'],

                'reference_number' =>
                    $validated['reference_number']
                    ?? null,

                'description' =>
                    $validated['description']
                    ?? null,

                'received_at' =>
                    $validated['received_at'],

                'status' =>
                    'pending',
            ]);
        });


        return redirect()
            ->route(
                'staff-gudang.stok.masuk'
            )
            ->with(
                'success',
                'Barang masuk berhasil dicatat dan menunggu pemeriksaan.'
            );
    }


    /**
     * Konfirmasi pemeriksaan barang masuk.
     */
    public function konfirmasiMasuk(
        Request $request,
        StockTransaction $transaction
    ) {

        $validated = $request->validate([
            'product_match' => [
                'required',
                'boolean'
            ],

            'attribute_match' => [
                'required',
                'boolean'
            ],

            'quantity_match' => [
                'required',
                'boolean'
            ],

            'condition' => [
                'required',
                'in:baik,rusak,sebagian_rusak'
            ],

            'inspection_notes' => [
                'nullable',
                'string',
                'max:1000'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI TRANSAKSI
        |--------------------------------------------------------------------------
        */

        if (
            $transaction->type !== 'in'
        ) {

            return redirect()
                ->route(
                    'staff-gudang.stok.masuk'
                )
                ->with(
                    'error',
                    'Transaksi bukan barang masuk.'
                );
        }


        if (
            !in_array(
                $transaction->status,
                [
                    'pending',
                    'menunggu'
                ]
            )
        ) {

            return redirect()
                ->route(
                    'staff-gudang.stok.masuk'
                )
                ->with(
                    'error',
                    'Transaksi sudah diperiksa sebelumnya.'
                );
        }


        DB::transaction(function () use (
            $transaction,
            $validated
        ) {

            $sesuai =
                (bool) $validated['product_match']
                &&
                (bool) $validated['attribute_match']
                &&
                (bool) $validated['quantity_match']
                &&
                $validated['condition']
                ===
                'baik';


            /*
            |--------------------------------------------------------------------------
            | BARANG SESUAI
            |--------------------------------------------------------------------------
            */

            if ($sesuai) {

                $product = Product::lockForUpdate()
                    ->findOrFail(
                        $transaction->product_id
                    );


                $product->increment(
                    'stock',
                    $transaction->quantity
                );


                $status = 'confirmed';
            }


            /*
            |--------------------------------------------------------------------------
            | BARANG TIDAK SESUAI
            |--------------------------------------------------------------------------
            */

            else {

                $status = 'rejected';
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN HASIL PEMERIKSAAN
            |--------------------------------------------------------------------------
            */

            $transaction->update([
                'status' =>
                    $status,

                'product_match' =>
                    $validated['product_match'],

                'attribute_match' =>
                    $validated['attribute_match'],

                'quantity_match' =>
                    $validated['quantity_match'],

                'condition' =>
                    $validated['condition'],

                'inspection_notes' =>
                    $validated['inspection_notes']
                    ?? null,
            ]);
        });


        if (
            $validated['product_match']
            &&
            $validated['attribute_match']
            &&
            $validated['quantity_match']
            &&
            $validated['condition']
            ===
            'baik'
        ) {

            return redirect()
                ->route(
                    'staff-gudang.stok.masuk'
                )
                ->with(
                    'success',
                    'Barang sesuai. Stok berhasil ditambahkan.'
                );
        }


        return redirect()
            ->route(
                'staff-gudang.stok.masuk'
            )
            ->with(
                'error',
                'Barang tidak sesuai. Stok tidak ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | BARANG KELUAR
    |--------------------------------------------------------------------------
    */

    /**
     * Menampilkan daftar barang keluar
     * yang menunggu pemeriksaan.
     */
    public function keluar()
    {
        $transactions = StockTransaction::with(
            'product'
        )
        ->where(
            'type',
            'out'
        )
        ->whereIn(
            'status',
            [
                'pending',
                'menunggu'
            ]
        )
        ->latest()
        ->get();


        return view(
            'staff-gudang.stock.keluar',
            compact('transactions')
        );
    }


    /**
     * Form pencatatan barang keluar.
     */
    public function tambahKeluar()
    {
        $products = Product::where(
            'status',
            'active'
        )
        ->where(
            'stock',
            '>',
            0
        )
        ->orderBy(
            'name'
        )
        ->get();


        return view(
            'staff-gudang.stock.keluar-tambah',
            compact('products')
        );
    }


    /**
     * Menyimpan pencatatan barang keluar.
     *
     * Stok BELUM dikurangi.
     */
    public function simpanKeluar(
        Request $request
    ) {

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
        ]);


        DB::transaction(function () use (
            $validated
        ) {

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
                        'Jumlah barang keluar melebihi stok tersedia. '
                        .
                        'Stok saat ini: '
                        .
                        $product->stock
                        .
                        ' '
                        .
                        $product->unit
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN TRANSAKSI PENDING
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
                    $validated['reference_number']
                    ?? null,

                'description' =>
                    $validated['description']
                    ?? null,

                'status' =>
                    'pending',
            ]);
        });


        return redirect()
            ->route(
                'staff-gudang.stok.keluar'
            )
            ->with(
                'success',
                'Barang keluar berhasil dicatat dan menunggu pemeriksaan.'
            );
    }


    /**
     * Konfirmasi barang keluar.
     */
    public function konfirmasiKeluar(
        Request $request,
        StockTransaction $transaction
    ) {

        $validated = $request->validate([
            'quantity_match' => [
                'required',
                'boolean'
            ],

            'condition' => [
                'required',
                'in:baik,rusak,sebagian_rusak'
            ],

            'inspection_notes' => [
                'nullable',
                'string',
                'max:1000'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI TRANSAKSI
        |--------------------------------------------------------------------------
        */

        if (
            $transaction->type !== 'out'
        ) {

            return redirect()
                ->route(
                    'staff-gudang.stok.keluar'
                )
                ->with(
                    'error',
                    'Transaksi bukan barang keluar.'
                );
        }


        if (
            !in_array(
                $transaction->status,
                [
                    'pending',
                    'menunggu'
                ]
            )
        ) {

            return redirect()
                ->route(
                    'staff-gudang.stok.keluar'
                )
                ->with(
                    'error',
                    'Transaksi sudah diperiksa sebelumnya.'
                );
        }


        DB::transaction(function () use (
            $transaction,
            $validated
        ) {

            /*
            |--------------------------------------------------------------------------
            | SESUAI
            |--------------------------------------------------------------------------
            */

            if (
                $validated['quantity_match']
                &&
                $validated['condition']
                ===
                'baik'
            ) {

                $product = Product::lockForUpdate()
                    ->findOrFail(
                        $transaction->product_id
                    );


                /*
                |--------------------------------------------------------------------------
                | CEK STOK
                |--------------------------------------------------------------------------
                */

                if (
                    $product->stock <
                    $transaction->quantity
                ) {

                    throw ValidationException::withMessages([
                        'quantity_match' =>
                            'Stok tidak mencukupi untuk transaksi ini.'
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | KURANGI STOK
                |--------------------------------------------------------------------------
                */

                $product->decrement(
                    'stock',
                    $transaction->quantity
                );


                $status = 'confirmed';
            }


            /*
            |--------------------------------------------------------------------------
            | TIDAK SESUAI
            |--------------------------------------------------------------------------
            */

            else {

                $status = 'rejected';
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN HASIL
            |--------------------------------------------------------------------------
            */

            $transaction->update([
                'status' =>
                    $status,

                'quantity_match' =>
                    $validated['quantity_match'],

                'condition' =>
                    $validated['condition'],

                'inspection_notes' =>
                    $validated['inspection_notes']
                    ?? null,
            ]);
        });


        if (
            $validated['quantity_match']
            &&
            $validated['condition']
            ===
            'baik'
        ) {

            return redirect()
                ->route(
                    'staff-gudang.stok.keluar'
                )
                ->with(
                    'success',
                    'Barang keluar sesuai. Stok berhasil dikurangi.'
                );
        }


        return redirect()
            ->route(
                'staff-gudang.stok.keluar'
            )
            ->with(
                'error',
                'Barang keluar tidak sesuai. Stok tidak dikurangi.'
            );
    }
}