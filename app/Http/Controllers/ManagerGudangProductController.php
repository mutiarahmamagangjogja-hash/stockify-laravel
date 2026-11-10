<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ManagerGudangProductController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'sku',
                    'like',
                    '%' . $search . '%'
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {

            $query->where(
                'category_id',
                $request->category
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DATA PRODUK
        |--------------------------------------------------------------------------
        */

        $products = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        $categories = Category::orderBy('name')
            ->get();


        return view(
            'manager-gudang.produk.index',
            compact(
                'products',
                'categories'
            )
        );
    }


    /**
     * Form tambah produk.
     */
    public function create()
    {
        $categories = Category::orderBy('name')
            ->get();


        return view(
            'manager-gudang.produk.create',
            compact('categories')
        );
    }


    /**
     * Menyimpan produk baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [

                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'sku' => [
                    'required',
                    'string',
                    'max:100',
                    'unique:products,sku',
                ],

                'category_id' => [
                    'nullable',
                    'exists:categories,id',
                ],

                'description' => [
                    'nullable',
                    'string',
                ],

                'purchase_price' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'price' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'stock' => [
                    'required',
                    'integer',
                    'min:0',
                ],

                'minimum_stock' => [
                    'required',
                    'integer',
                    'min:0',
                ],

                'unit' => [
                    'required',
                    'string',
                    'max:50',
                ],

                'status' => [
                    'required',
                    Rule::in([
                        'active',
                        'inactive',
                    ]),
                ],

                'image' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],

            ],
            [

                'name.required' =>
                    'Nama produk wajib diisi.',

                'sku.required' =>
                    'SKU wajib diisi.',

                'sku.unique' =>
                    'SKU tersebut sudah digunakan.',

                'category_id.exists' =>
                    'Kategori tidak ditemukan.',

                'purchase_price.required' =>
                    'Harga beli wajib diisi.',

                'price.required' =>
                    'Harga jual wajib diisi.',

                'stock.required' =>
                    'Stok awal wajib diisi.',

                'minimum_stock.required' =>
                    'Minimum stok wajib diisi.',

                'image.image' =>
                    'File harus berupa gambar.',

                'image.mimes' =>
                    'Gambar harus berformat JPG, JPEG, PNG, atau WEBP.',

                'image.max' =>
                    'Ukuran gambar maksimal 2 MB.',

            ]
        );


        /*
        |--------------------------------------------------------------------------
        | UPLOAD GAMBAR
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $validated['image'] =
                $request
                    ->file('image')
                    ->store(
                        'products',
                        'public'
                    );

        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN PRODUK
        |--------------------------------------------------------------------------
        */

        Product::create($validated);


        return redirect()
            ->route('manager-gudang.produk.index')
            ->with(
                'success',
                'Produk berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail produk.
     */
    public function show(Product $product)
    {
        $product->load([
            'category',
            'stockTransactions',
        ]);


        return view(
            'manager-gudang.produk.show',
            compact('product')
        );
    }
}