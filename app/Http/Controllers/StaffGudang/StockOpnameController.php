<?php

namespace App\Http\Controllers\StaffGudang;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockOpname;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockOpnameController extends Controller
{
    /**
     * Menampilkan daftar stock opname.
     */
 public function index()
{
    $opnames = StockOpname::with([
        'product',
        'user',
    ])
        ->latest()
        ->get();

    return view(
        'staff-gudang.stock.opname',
        compact('opnames')
    );
}

    /**
     * Menampilkan form stock opname.
     */
    public function create()
    {
        $products = Product::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view(
            'staff-gudang.stock.opname-tambah',
            compact('products')
        );
    }

    /**
     * Menyimpan stock opname.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'product_id' => [
                    'required',
                    'exists:products,id',
                ],

                'physical_stock' => [
                    'required',
                    'integer',
                    'min:0',
                ],


        'inspector_name' => [
            'required',
            'string',
            'max:100',
        ],

                'description' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
            ],
            [
                'product_id.required' =>
                    'Produk wajib dipilih.',

                'product_id.exists' =>
                    'Produk yang dipilih tidak ditemukan.',

                'physical_stock.required' =>
                    'Stok fisik wajib diisi.',

                'physical_stock.integer' =>
                    'Stok fisik harus berupa angka.',

                'physical_stock.min' =>
                    'Stok fisik tidak boleh kurang dari 0.',


                     'inspector_name.required' =>
            'Nama petugas pemeriksa wajib diisi.',

        'inspector_name.max' =>
            'Nama petugas pemeriksa maksimal 100 karakter.',
    ]
);
        
        

        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | LOCK PRODUK
            |--------------------------------------------------------------------------
            */

            $product = Product::lockForUpdate()
                ->findOrFail(
                    $validated['product_id']
                );

            /*
            |--------------------------------------------------------------------------
            | STOK SISTEM
            |--------------------------------------------------------------------------
            */

            $systemStock = (int) $product->stock;

            /*
            |--------------------------------------------------------------------------
            | STOK FISIK
            |--------------------------------------------------------------------------
            */

            $physicalStock =
                (int) $validated['physical_stock'];

            /*
            |--------------------------------------------------------------------------
            | SELISIH
            |--------------------------------------------------------------------------
            */

            $difference =
                $physicalStock - $systemStock;

            /*
            |--------------------------------------------------------------------------
            | SIMPAN STOCK OPNAME
            |--------------------------------------------------------------------------
            */

            $opname = StockOpname::create([
                'product_id' =>
                    $product->id,

                'system_stock' =>
                    $systemStock,

                'physical_stock' =>
                    $physicalStock,

                'difference' =>
                    $difference,

                'description' =>
                    $validated['description'] ?? null,

                'user_id' =>
                    Auth::id(),

                     'inspector_name' =>
        $validated['inspector_name'],

            ]);

            /*
            |--------------------------------------------------------------------------
            | CATAT PENYESUAIAN STOK
            |--------------------------------------------------------------------------
            |
            | Jika terdapat selisih, dibuat transaksi penyesuaian.
            |
            */

            if ($difference !== 0) {

                StockTransaction::create([
                    'product_id' =>
                        $product->id,

                    'type' =>
                        $difference > 0
                            ? 'in'
                            : 'out',

                    'quantity' =>
                        abs($difference),

                    'reference_number' =>
                        'OPNAME-' . $opname->id,

                    'description' =>
                        'Penyesuaian stok berdasarkan stock opname.',

                    'status' =>
                        'confirmed',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | UPDATE STOK PRODUK
            |--------------------------------------------------------------------------
            */

            $product->update([
                'stock' =>
                    $physicalStock,
            ]);
        });

        return redirect()
            ->route('staff-gudang.stok.opname')
            ->with(
                'success',
                'Stock opname berhasil disimpan dan stok telah diperbarui.'
            );
    }

    /**
     * Menampilkan detail stock opname.
     */
    public function show(StockOpname $opname)
    {
        $opname->load([
            'product',
            'user',
        ]);

        return view(
            'staff-gudang.stock.opname-detail',
            compact('opname')
        );
    }
}