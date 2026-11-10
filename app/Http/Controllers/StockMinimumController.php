<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StockMinimumController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')
            ->get();

        return view(
            'stock.minimum',
            compact('products')
        );
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        $product->update([
            'minimum_stock' =>
                $validated['minimum_stock'],
        ]);

        return redirect()
            ->route('stok.minimum')
            ->with(
                'success',
                'Stok minimum berhasil diperbarui.'
            );
    }
}

