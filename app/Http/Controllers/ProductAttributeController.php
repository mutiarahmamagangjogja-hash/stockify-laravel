<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function index()
    {
        $attributes = ProductAttribute::with('values')
            ->latest()
            ->get();

        return view(
            'product-attributes.index',
            compact('attributes')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'nullable',
                'string'
            ],
        ]);

        ProductAttribute::create($validated);

        return redirect()
            ->route('atribut.index')
            ->with(
                'success',
                'Atribut produk berhasil ditambahkan.'
            );
    }

    public function update(
        Request $request,
        ProductAttribute $attribute
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'nullable',
                'string'
            ],
        ]);

        $attribute->update($validated);

        return redirect()
            ->route('atribut.index')
            ->with(
                'success',
                'Atribut produk berhasil diperbarui.'
            );
    }

    public function destroy(
        ProductAttribute $attribute
    ) {
        $attribute->delete();

        return redirect()
            ->route('atribut.index')
            ->with(
                'success',
                'Atribut produk berhasil dihapus.'
            );
    }

    public function storeValue(
        Request $request,
        ProductAttribute $attribute
    ) {
        $validated = $request->validate([
            'value' => [
                'required',
                'string',
                'max:255'
            ],
        ]);

        $attribute->values()->create([
            'value' => $validated['value'],
        ]);

        return redirect()
            ->route('atribut.index')
            ->with(
                'success',
                'Nilai atribut berhasil ditambahkan.'
            );
    }

    public function destroyValue(
        ProductAttributeValue $value
    ) {
        $value->delete();

        return redirect()
            ->route('atribut.index')
            ->with(
                'success',
                'Nilai atribut berhasil dihapus.'
            );
    }
}