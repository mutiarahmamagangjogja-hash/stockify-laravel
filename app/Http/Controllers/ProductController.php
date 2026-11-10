<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\Activity;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DATA PRODUK
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'sku',
                    'like',
                    "%{$search}%"
                );

            });
        }


        if ($request->filled('category_id')) {

            $query->where(
                'category_id',
                $request->category_id
            );
        }


        $products = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        $categories = Category::orderBy('name')
            ->get();


        $totalProducts = Product::count();


        $activeProducts = Product::where(
            'status',
            'active'
        )->count();


        $lowStockProducts = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();


        $totalCategories = Category::count();


        return view(
            'products.index',
            compact(
                'products',
                'categories',
                'totalProducts',
                'activeProducts',
                'lowStockProducts',
                'totalCategories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH PRODUK
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = Category::orderBy('name')
            ->get();


        $attributes = ProductAttribute::with('values')
            ->orderBy('name')
            ->get();


        return view(
            'products.create',
            compact(
                'categories',
                'attributes'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN PRODUK
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'sku' => [
                'required',
                'string',
                'max:100',
                'unique:products,sku'
            ],

            'category_id' => [
                'required',
                'exists:categories,id'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'price' => [
                'required',
                'numeric',
                'min:0'
            ],

            'stock' => [
                'required',
                'integer',
                'min:0'
            ],

            'minimum_stock' => [
                'required',
                'integer',
                'min:0'
            ],

            'unit' => [
                'required',
                'string',
                'max:50'
            ],

            'status' => [
                'required',
                'in:active,inactive'
            ],

            'attribute_values' => [
                'nullable',
                'array'
            ],

            'attribute_values.*' => [
                'nullable',
                'integer',
                'exists:product_attribute_values,id'
            ],

        ]);


        DB::transaction(function () use (
            $validated,
            $request
        ) {

            $product = Product::create(

                collect($validated)
                    ->except('attribute_values')
                    ->toArray()

            );


            $this->syncAttributes(
                $product,
                $request->input(
                    'attribute_values',
                    []
                )
            );


            /*
            |--------------------------------------------------------------------------
            | CATAT AKTIVITAS
            |--------------------------------------------------------------------------
            */

            ActivityLog::create([

                'user_id' => Auth::id(),

                'action' =>
                    'menambahkan produk',

                'description' =>
                    $product->name,

                'reference_type' =>
                    'Product',

                'reference_id' =>
                    $product->id,

            ]);

        });


        return redirect()
            ->route('produk.index')
            ->with(
                'success',
                'Produk berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')
            ->get();


        $attributes = ProductAttribute::with('values')
            ->orderBy('name')
            ->get();


        $selectedAttributes = $product
            ->attributeValues()
            ->get()
            ->keyBy(function ($value) {

                return $value
                    ->pivot
                    ->product_attribute_id;

            });


        return view(
            'products.edit',
            compact(
                'product',
                'categories',
                'attributes',
                'selectedAttributes'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PRODUK
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Product $product
    ) {

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'sku' => [
                'required',
                'string',
                'max:100',
                'unique:products,sku,' . $product->id
            ],

            'category_id' => [
                'required',
                'exists:categories,id'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'price' => [
                'required',
                'numeric',
                'min:0'
            ],

            'stock' => [
                'required',
                'integer',
                'min:0'
            ],

            'minimum_stock' => [
                'required',
                'integer',
                'min:0'
            ],

            'unit' => [
                'required',
                'string',
                'max:50'
            ],

            'status' => [
                'required',
                'in:active,inactive'
            ],

            'attribute_values' => [
                'nullable',
                'array'
            ],

            'attribute_values.*' => [
                'nullable',
                'integer',
                'exists:product_attribute_values,id'
            ],

        ]);


        DB::transaction(function () use (
            $validated,
            $request,
            $product
        ) {

            $product->update(

                collect($validated)
                    ->except('attribute_values')
                    ->toArray()

            );


            $this->syncAttributes(
                $product,
                $request->input(
                    'attribute_values',
                    []
                )
            );


            /*
            |--------------------------------------------------------------------------
            | CATAT AKTIVITAS
            |--------------------------------------------------------------------------
            */

            ActivityLog::create([

                'user_id' => Auth::id(),

                'action' =>
                    'memperbarui produk',

                'description' =>
                    $product->name,

                'reference_type' =>
                    'Product',

                'reference_id' =>
                    $product->id,

            ]);

        });


        return redirect()
            ->route('produk.index')
            ->with(
                'success',
                'Produk berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS PRODUK
    |--------------------------------------------------------------------------
    */

    public function destroy(Product $product)
    {
        $productName = $product->name;

        $productId = $product->id;


        $product->delete();


        ActivityLog::create([

            'user_id' => Auth::id(),

            'action' =>
                'menghapus produk',

            'description' =>
                $productName,

            'reference_type' =>
                'Product',

            'reference_id' =>
                $productId,

        ]);


        return redirect()
            ->route('produk.index')
            ->with(
                'success',
                'Produk berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SYNC ATRIBUT
    |--------------------------------------------------------------------------
    */

    private function syncAttributes(
        Product $product,
        array $attributeValues
    ): void {

        $syncData = [];


        foreach (
            $attributeValues
            as $attributeId => $valueId
        ) {

            if (!$valueId) {
                continue;
            }


            $syncData[$attributeId] = [

                'product_attribute_value_id' =>
                    $valueId

            ];

        }


        $product
            ->attributes()
            ->sync($syncData);
    }
}