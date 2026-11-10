@extends('layouts.app')

@section('title', 'Tambah Produk - Stockify')

@section('page-title', 'Produk')

@section('page-description', 'Tambah produk baru ke dalam persediaan Stockify')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>

        <h2 class="text-2xl font-bold text-white">
            Tambah Produk
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Tambahkan produk baru ke dalam sistem Stockify.
        </p>

    </div>


    <a
        href="{{ route('produk.index') }}"
        class="inline-flex items-center
               px-4 py-2.5
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

        <ul class="list-disc pl-5 space-y-1">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


<form
    action="{{ route('produk.store') }}"
    method="POST"
>

@csrf


<!-- INFORMASI PRODUK -->

<div
    class="mb-6
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           overflow-hidden"
>

    <div
        class="p-5
               border-b border-[#3A4254]"
    >

        <h3 class="text-lg font-semibold text-white">
            Informasi Produk
        </h3>

        <p class="mt-1 text-sm text-gray-400">
            Masukkan informasi dasar produk.
        </p>

    </div>


    <div class="p-5">

        <div class="grid grid-cols-2 gap-5 mb-5">

            <div>

                <label
                    for="name"
                    class="block mb-2 text-sm font-medium text-gray-300"
                >
                    Nama Produk
                    <span class="text-red-400">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Laptop ASUS"
                    required
                    class="w-full px-4 py-2.5 text-sm text-white
                           bg-[#2D3445] border border-[#3A4254]
                           rounded-lg placeholder-gray-500
                           focus:ring-2 focus:ring-gray-600 focus:outline-none"
                >

            </div>


            <div>

                <label
                    for="sku"
                    class="block mb-2 text-sm font-medium text-gray-300"
                >
                    SKU
                    <span class="text-red-400">*</span>
                </label>

                <input
                    type="text"
                    id="sku"
                    name="sku"
                    value="{{ old('sku') }}"
                    placeholder="Contoh: LPT-ASUS-001"
                    required
                    class="w-full px-4 py-2.5 text-sm text-white
                           bg-[#2D3445] border border-[#3A4254]
                           rounded-lg placeholder-gray-500
                           focus:ring-2 focus:ring-gray-600 focus:outline-none"
                >

                <p class="mt-1.5 text-xs text-gray-500">
                    SKU harus unik untuk setiap produk.
                </p>

            </div>

        </div>


        <div class="grid grid-cols-2 gap-5 mb-5">

            <!-- KATEGORI -->

            <div>

                <label
                    for="category_id"
                    class="block mb-2 text-sm font-medium text-gray-300"
                >
                    Kategori
                    <span class="text-red-400">*</span>
                </label>

                <select
                    id="category_id"
                    name="category_id"
                    required
                    class="w-full px-4 py-2.5 text-sm text-white
                           bg-[#2D3445] border border-[#3A4254]
                           rounded-lg focus:ring-2 focus:ring-gray-600
                           focus:outline-none"
                >

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    @forelse($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>

                    @empty

                        <option value="" disabled>
                            Belum ada kategori
                        </option>

                    @endforelse

                </select>

            </div>


            <!-- UNIT -->

            <div>

                <label
                    for="unit"
                    class="block mb-2 text-sm font-medium text-gray-300"
                >
                    Satuan
                    <span class="text-red-400">*</span>
                </label>

                <select
                    id="unit"
                    name="unit"
                    required
                    class="w-full px-4 py-2.5 text-sm text-white
                           bg-[#2D3445] border border-[#3A4254]
                           rounded-lg focus:ring-2 focus:ring-gray-600
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
                            {{ old('unit', 'pcs') == $value ? 'selected' : '' }}
                        >
                            {{ $label }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


        <!-- DESKRIPSI -->

        <div>

            <label
                for="description"
                class="block mb-2 text-sm font-medium text-gray-300"
            >
                Deskripsi
            </label>

            <textarea
                id="description"
                name="description"
                rows="4"
                placeholder="Masukkan deskripsi produk..."
                class="w-full px-4 py-3 text-sm text-white
                       bg-[#2D3445] border border-[#3A4254]
                       rounded-lg placeholder-gray-500
                       focus:ring-2 focus:ring-gray-600 focus:outline-none"
            >{{ old('description') }}</textarea>

        </div>

    </div>

</div>


<!-- ATRIBUT PRODUK -->

<div
    class="mb-6
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           overflow-hidden"
>

    <div
        class="p-5
               border-b border-[#3A4254]"
    >

        <h3 class="text-lg font-semibold text-white">
            Atribut Produk
        </h3>

        <p class="mt-1 text-sm text-gray-400">
            Pilih atribut yang sesuai dengan produk.
        </p>

    </div>


    <div class="p-5">

        @forelse($attributes as $attribute)

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
                           focus:ring-2
                           focus:ring-gray-600
                           focus:outline-none"
                >

                    <option value="">
                        -- Pilih {{ $attribute->name }} --
                    </option>

                    @foreach($attribute->values as $value)

                        <option
                            value="{{ $value->id }}"
                            {{ old("attribute_values.{$attribute->id}") == $value->id ? 'selected' : '' }}
                        >
                            {{ $value->value }}
                        </option>

                    @endforeach

                </select>

            </div>

        @empty

            <div
                class="p-4
                       text-sm text-gray-400
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg"
            >
                Belum ada atribut produk.
                Silakan buat atribut terlebih dahulu
                melalui menu Atribut Produk.
            </div>

        @endforelse

    </div>

</div>


<!-- HARGA DAN STOK -->

<div
    class="mb-6
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           overflow-hidden"
>

    <div
        class="p-5
               border-b border-[#3A4254]"
    >

        <h3 class="text-lg font-semibold text-white">
            Harga dan Persediaan
        </h3>

        <p class="mt-1 text-sm text-gray-400">
            Tentukan harga dan jumlah persediaan produk.
        </p>

    </div>


    <div class="p-5">

        <div class="grid grid-cols-3 gap-5">

            <div>

                <label
                    for="price"
                    class="block mb-2 text-sm font-medium text-gray-300"
                >
                    Harga
                    <span class="text-red-400">*</span>
                </label>

                <div class="relative">

                    <span
                        class="absolute inset-y-0 left-0
                               flex items-center pl-4
                               text-sm text-gray-400"
                    >
                        Rp
                    </span>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        value="{{ old('price', 0) }}"
                        min="0"
                        step="0.01"
                        required
                        class="w-full pl-12 pr-4 py-2.5
                               text-sm text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg
                               focus:ring-2 focus:ring-gray-600
                               focus:outline-none"
                    >

                </div>

            </div>


            <div>

                <label
                    for="stock"
                    class="block mb-2 text-sm font-medium text-gray-300"
                >
                    Stok Awal
                    <span class="text-red-400">*</span>
                </label>

                <input
                    type="number"
                    id="stock"
                    name="stock"
                    value="{{ old('stock', 0) }}"
                    min="0"
                    required
                    class="w-full px-4 py-2.5
                           text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           focus:ring-2 focus:ring-gray-600
                           focus:outline-none"
                >

            </div>


            <div>

                <label
                    for="minimum_stock"
                    class="block mb-2 text-sm font-medium text-gray-300"
                >
                    Stok Minimum
                    <span class="text-red-400">*</span>
                </label>

                <input
                    type="number"
                    id="minimum_stock"
                    name="minimum_stock"
                    value="{{ old('minimum_stock', 0) }}"
                    min="0"
                    required
                    class="w-full px-4 py-2.5
                           text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           focus:ring-2 focus:ring-gray-600
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
           rounded-lg
           overflow-hidden"
>

    <div class="p-5 border-b border-[#3A4254]">

        <h3 class="text-lg font-semibold text-white">
            Status Produk
        </h3>

    </div>


    <div class="p-5">

        <select
            name="status"
            required
            class="w-full max-w-md
                   px-4 py-2.5
                   text-sm text-white
                   bg-[#2D3445]
                   border border-[#3A4254]
                   rounded-lg
                   focus:ring-2 focus:ring-gray-600
                   focus:outline-none"
        >

            <option
                value="active"
                {{ old('status', 'active') == 'active' ? 'selected' : '' }}
            >
                Aktif
            </option>

            <option
                value="inactive"
                {{ old('status') == 'inactive' ? 'selected' : '' }}
            >
                Tidak Aktif
            </option>

        </select>

    </div>

</div>


<!-- BUTTON -->

<div class="flex items-center justify-end gap-3 mb-6">

    <a
        href="{{ route('produk.index') }}"
        class="px-5 py-2.5
               text-sm font-medium
               text-gray-300
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               hover:bg-[#2D3445]"
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
               rounded-lg
               hover:bg-[#0B132B]"
    >
        ✓ Simpan Produk
    </button>

</div>

</form>

@endsection