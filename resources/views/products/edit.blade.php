@extends('layouts.app')

@section('title', 'Edit Produk - Stockify')

@section('page-title', 'Produk')

@section('page-description', 'Edit data produk Stockify')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>

        <h2 class="text-2xl font-bold text-white">
            Edit Produk
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Perbarui informasi produk dan atributnya.
        </p>

    </div>


    <a
        href="{{ route('produk.index') }}"
        class="px-4 py-2.5
               text-sm font-medium
               text-gray-300
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               hover:bg-[#2D3445]"
    >
        ← Kembali
    </a>

</div>


@if($errors->any())

    <div
        class="p-4 mb-6
               text-sm text-red-300
               bg-red-900/30
               border border-red-800
               rounded-lg"
    >

        <p class="font-semibold mb-2">
            Data belum dapat disimpan.
        </p>

        <ul class="list-disc pl-5">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif


<form
    action="{{ route('produk.update', $product) }}"
    method="POST"
>

@csrf

@method('PUT')


<!-- INFORMASI PRODUK -->

<div
    class="mb-6
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           overflow-hidden"
>

    <div class="p-5 border-b border-[#3A4254]">

        <h3 class="text-lg font-semibold text-white">
            Informasi Produk
        </h3>

    </div>


    <div class="p-5">

        <div class="grid grid-cols-2 gap-5 mb-5">

            <div>

                <label class="block mb-2 text-sm text-gray-300">
                    Nama Produk
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $product->name) }}"
                    required
                    class="w-full px-4 py-2.5
                           text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none"
                >

            </div>


            <div>

                <label class="block mb-2 text-sm text-gray-300">
                    SKU
                </label>

                <input
                    type="text"
                    name="sku"
                    value="{{ old('sku', $product->sku) }}"
                    required
                    class="w-full px-4 py-2.5
                           text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none"
                >

            </div>

        </div>


        <div class="grid grid-cols-2 gap-5 mb-5">

            <div>

                <label class="block mb-2 text-sm text-gray-300">
                    Kategori
                </label>

                <select
                    name="category_id"
                    required
                    class="w-full px-4 py-2.5
                           text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none"
                >

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div>

                <label class="block mb-2 text-sm text-gray-300">
                    Satuan
                </label>

                <select
                    name="unit"
                    required
                    class="w-full px-4 py-2.5
                           text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none"
                >

                    @foreach([
                        'pcs' => 'Pcs',
                        'unit' => 'Unit',
                        'box' => 'Box',
                        'lusin' => 'Lusin',
                        'pack' => 'Pack',
                        'kg' => 'Kg',
                        'liter' => 'Liter'
                    ] as $value => $label)

                        <option
                            value="{{ $value }}"
                            {{ old('unit', $product->unit) == $value ? 'selected' : '' }}
                        >
                            {{ $label }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


        <div>

            <label class="block mb-2 text-sm text-gray-300">
                Deskripsi
            </label>

            <textarea
                name="description"
                rows="4"
                class="w-full px-4 py-3
                       text-sm text-white
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg
                       focus:outline-none"
            >{{ old('description', $product->description) }}</textarea>

        </div>

    </div>

</div>


<!-- ATRIBUT -->

<div
    class="mb-6
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           overflow-hidden"
>

    <div class="p-5 border-b border-[#3A4254]">

        <h3 class="text-lg font-semibold text-white">
            Atribut Produk
        </h3>

        <p class="mt-1 text-sm text-gray-400">
            Pilih nilai atribut produk.
        </p>

    </div>


    <div class="p-5">

        @forelse($attributes as $attribute)

            @php

                $selectedValue = old(
                    "attribute_values.{$attribute->id}",
                    optional(
                        $selectedAttributes->get($attribute->id)
                    )->id
                );

            @endphp


            <div class="mb-5 last:mb-0">

                <label
                    for="attribute_{{ $attribute->id }}"
                    class="block mb-2
                           text-sm font-medium
                           text-gray-300"
                >
                    {{ $attribute->name }}
                </label>


                <select
                    id="attribute_{{ $attribute->id }}"
                    name="attribute_values[{{ $attribute->id }}]"
                    class="w-full px-4 py-2.5
                           text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none"
                >

                    <option value="">
                        -- Pilih {{ $attribute->name }} --
                    </option>

                    @foreach($attribute->values as $value)

                        <option
                            value="{{ $value->id }}"
                            {{ $selectedValue == $value->id ? 'selected' : '' }}
                        >
                            {{ $value->value }}
                        </option>

                    @endforeach

                </select>

            </div>

        @empty

            <p class="text-sm text-gray-400">
                Belum ada atribut produk.
            </p>

        @endforelse

    </div>

</div>


<!-- HARGA DAN STOK -->

<div
    class="mb-6
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg"
>

    <div class="p-5 border-b border-[#3A4254]">

        <h3 class="text-lg font-semibold text-white">
            Harga dan Persediaan
        </h3>

    </div>


    <div class="p-5">

        <div class="grid grid-cols-3 gap-5">

            <div>

                <label class="block mb-2 text-sm text-gray-300">
                    Harga
                </label>

                <input
                    type="number"
                    name="price"
                    value="{{ old('price', $product->price) }}"
                    min="0"
                    step="0.01"
                    required
                    class="w-full px-4 py-2.5
                           text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none"
                >

            </div>


            <div>

                <label class="block mb-2 text-sm text-gray-300">
                    Stok
                </label>

                <input
                    type="number"
                    name="stock"
                    value="{{ old('stock', $product->stock) }}"
                    min="0"
                    required
                    class="w-full px-4 py-2.5
                           text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none"
                >

            </div>


            <div>

                <label class="block mb-2 text-sm text-gray-300">
                    Stok Minimum
                </label>

                <input
                    type="number"
                    name="minimum_stock"
                    value="{{ old('minimum_stock', $product->minimum_stock) }}"
                    min="0"
                    required
                    class="w-full px-4 py-2.5
                           text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none"
                >

            </div>

        </div>

    </div>

</div>


<!-- STATUS -->

<div
    class="mb-6
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg"
>

    <div class="p-5">

        <label class="block mb-2 text-sm text-gray-300">
            Status
        </label>

        <select
            name="status"
            required
            class="w-full max-w-md
                   px-4 py-2.5
                   text-sm text-white
                   bg-[#2D3445]
                   border border-[#3A4254]
                   rounded-lg
                   focus:outline-none"
        >

            <option
                value="active"
                {{ old('status', $product->status) == 'active' ? 'selected' : '' }}
            >
                Aktif
            </option>

            <option
                value="inactive"
                {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}
            >
                Tidak Aktif
            </option>

        </select>

    </div>

</div>


<div class="flex justify-end gap-3 mb-6">

    <a
        href="{{ route('produk.index') }}"
        class="px-5 py-2.5
               text-sm text-gray-300
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >
        Batal
    </a>


    <button
        type="submit"
        class="px-5 py-2.5
               text-sm font-medium
               text-white
               bg-[#111B36]
               border border-[#3A4254]
               rounded-lg"
    >
        ✓ Simpan Perubahan
    </button>

</div>

</form>

@endsection