@extends('layouts.app')

@section('title', 'Produk - Stockify')

@section('page-title', 'Produk')

@section('page-description', 'Kelola data produk dan persediaan Stockify')

@section('content')

<!-- ===================================================== -->
<!-- HEADER -->
<!-- ===================================================== -->

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-white">
            Data Produk
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            Kelola data produk, kategori, atribut, dan persediaan.
        </p>
    </div>

    <div class="flex items-center gap-3">
        <!-- KATEGORI -->
        <a
            href="{{ route('kategori.index') }}"
            class="inline-flex items-center
                   px-4 py-2.5
                   text-sm font-medium
                   text-gray-300
                   bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   hover:bg-[#2D3445]
                   hover:text-white"
        >
            <svg
                class="w-5 h-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
            Kategori
        </a>

        <!-- TAMBAH PRODUK -->
        <a
            href="{{ route('produk.create') }}"
            class="inline-flex items-center
                   px-4 py-2.5
                   text-sm font-medium
                   text-white
                   bg-[#111B36]
                   border border-[#3A4254]
                   rounded-lg
                   hover:bg-[#0B132B]"
        >
            <svg
                class="w-5 h-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16
                       M4 12h16"
                />
            </svg>
            Tambah Produk
        </a>
    </div>
</div>

<!-- ===================================================== -->
<!-- SUCCESS -->
<!-- ===================================================== -->

@if(session('success'))
    <div
        class="p-4 mb-6
               text-sm text-green-300
               bg-green-900/30
               border border-green-800
               rounded-lg"
    >
        {{ session('success') }}
    </div>
@endif

<!-- ===================================================== -->
<!-- ERROR -->
<!-- ===================================================== -->

@if($errors->any())
    <div
        class="p-4 mb-6
               text-sm text-red-300
               bg-red-900/30
               border border-red-800
               rounded-lg"
    >
        <p class="mb-2 font-semibold">
            Terjadi kesalahan:
        </p>
        <ul class="pl-5 list-disc">
            @foreach($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<!-- ===================================================== -->
<!-- STATISTIK -->
<!-- ===================================================== -->

<div class="grid grid-cols-4 gap-5 mb-6">
    <!-- TOTAL PRODUK -->
    <div
        class="p-5
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >
        <p class="text-sm text-gray-400">
            Total Produk
        </p>
        <p class="mt-2 text-2xl font-bold text-white">
            {{ $totalProducts }}
        </p>
    </div>

    <!-- PRODUK AKTIF -->
    <div
        class="p-5
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >
        <p class="text-sm text-gray-400">
            Produk Aktif
        </p>
        <p class="mt-2 text-2xl font-bold text-white">
            {{ $activeProducts }}
        </p>
    </div>

    <!-- STOK RENDAH -->
    <div
        class="p-5
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >
        <p class="text-sm text-gray-400">
            Stok Rendah
        </p>
        <p class="mt-2 text-2xl font-bold text-white">
            {{ $lowStockProducts }}
        </p>
    </div>

    <!-- TOTAL KATEGORI -->
    <div
        class="p-5
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >
        <p class="text-sm text-gray-400">
            Total Kategori
        </p>
        <p class="mt-2 text-2xl font-bold text-white">
            {{ $totalCategories }}
        </p>
    </div>
</div>

<!-- ===================================================== -->
<!-- FILTER -->
<!-- ===================================================== -->

<div
    class="p-5 mb-6
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg"
>
    <form
        action="{{ route('produk.index') }}"
        method="GET"
        class="grid grid-cols-12 gap-4"
    >
        <!-- SEARCH -->
        <div class="col-span-6">
            <label
                class="block mb-2
                       text-sm font-medium
                       text-gray-300"
            >
                Cari Produk
            </label>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama produk atau SKU..."
                class="w-full
                       px-4 py-2.5
                       text-sm text-white
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg
                       placeholder-gray-500
                       focus:outline-none
                       focus:ring-2
                       focus:ring-gray-600"
            >
        </div>

        <!-- KATEGORI FILTER -->
        <div class="col-span-4">
            <label
                class="block mb-2
                       text-sm font-medium
                       text-gray-300"
            >
                Kategori
            </label>
            <select
                name="category_id"
                class="w-full
                       px-4 py-2.5
                       text-sm text-white
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg
                       focus:outline-none
                       focus:ring-2
                       focus:ring-gray-600"
            >
                <option
                    value=""
                    class="bg-[#252B3A]"
                >
                    Semua Kategori
                </option>

                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        class="bg-[#252B3A]"
                        {{ request('category_id') == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- BUTTON -->
        <div class="col-span-2 flex items-end">
            <button
                type="submit"
                class="w-full
                       px-4 py-2.5
                       text-sm font-medium
                       text-white
                       bg-[#111B36]
                       border border-[#3A4254]
                       rounded-lg
                       hover:bg-[#0B132B]"
            >
                Filter
            </button>
        </div>
    </form>
</div>

<!-- ===================================================== -->
<!-- TABLE PRODUK -->
<!-- ===================================================== -->

<div
    class="bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           overflow-hidden"
>
    <!-- TABLE HEADER -->
    <div
        class="p-5
               border-b border-[#3A4254]"
    >
        <h3 class="text-lg font-semibold text-white">
            Daftar Produk
        </h3>
        <p class="mt-1 text-sm text-gray-400">
            Daftar seluruh produk yang tersedia dalam sistem.
        </p>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#2D3445] border-b border-[#3A4254]">
                <tr>
                    <th class="px-5 py-4 font-semibold text-gray-300 text-center">Produk</th>
                    <th class="px-5 py-4 font-semibold text-gray-300 text-center">SKU</th>
                    <th class="px-5 py-4 font-semibold text-gray-300 text-center">Kategori</th>
                    <th class="px-5 py-4 font-semibold text-gray-300 text-center">Deskripsi</th>
                    <th class="px-5 py-4 font-semibold text-gray-300 text-center">Atribut</th>
                    <th class="px-5 py-4 font-semibold text-gray-300 text-center">Harga</th>
                    <th class="px-5 py-4 font-semibold text-gray-300 text-center">Stok</th>
                    <th class="px-5 py-4 font-semibold text-gray-300 text-center">Status</th>
                    <th class="px-5 py-4 font-semibold text-gray-300 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#3A4254]">
                @forelse($products as $product)
                    <tr class="hover:bg-[#2D3445]">
                        <!-- PRODUK -->
                        <td class="px-5 py-4 whitespace-nowrap">
                            <p class="font-medium text-white">
                                {{ $product->name }}
                            </p>
                        </td>

                        <!-- SKU -->
                        <td class="px-5 py-4 whitespace-nowrap">
                            <p class="font-medium text-white">
                                {{ $product->sku }}
                            </p>
                        </td>

                        <!-- KATEGORI -->
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($product->category)
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-white bg-[#2D3445] border border-[#3A4254] rounded-md">
                                    {{ $product->category->name }}
                                </span>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>

                        <!-- DESKRIPSI -->
                        <td class="px-5 py-4 max-w-xs">
                            @if($product->description)
                                <p class="text-white line-clamp-2" title="{{ $product->description }}">
                                    {{ $product->description }}
                                </p>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <!-- ATRIBUT -->
                        <td class="px-5 py-4">
                            @if($product->attributeValues && $product->attributeValues->count())
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($product->attributeValues as $attributeValue)
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium text-white bg-[#2D3445] border border-[#3A4254] rounded-md">
                                            {{ $attributeValue->value }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>

                        <!-- HARGA -->
                        <td class="px-5 py-4 whitespace-nowrap text-white">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        <!-- STOK -->
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-baseline">
                                <span class="font-medium text-white">{{ $product->stock }}</span>
                                <span class="ml-1 text-xs text-gray-400">{{ $product->unit }}</span>
                            </div>
                        </td>

                        <!-- STATUS -->
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($product->status === 'active')
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-green-300 bg-green-900/30 border border-green-800 rounded-md">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-red-300 bg-red-900/30 border border-red-800 rounded-md">
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>

                        <!-- AKSI -->
                        <td class="px-5 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- EDIT -->
                                <a href="{{ route('produk.edit', $product) }}" class="px-2.5 py-1 text-xs text-blue-300 bg-blue-900/30 border border-blue-800 rounded-lg hover:bg-blue-900/50">
                                    Edit
                                </a>

                                <!-- DELETE -->
                                <form action="{{ route('produk.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline-block m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 text-xs text-red-300 bg-red-900/30 border border-red-800 rounded-lg hover:bg-red-900/50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-[#2D3445] rounded-full">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Belum ada produk</h3>
                            <p class="mt-1 text-sm text-gray-400">Tambahkan produk pertama untuk mulai mengelola persediaan.</p>
                            <a href="{{ route('produk.create') }}" class="inline-flex items-center mt-4 px-4 py-2.5 text-sm font-medium text-white bg-[#111B36] border border-[#3A4254] rounded-lg hover:bg-[#0B132B]">
                                + Tambah Produk
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if($products->hasPages())
        <div
            class="px-5 py-4
                   border-t
                   border-[#3A4254]"
        >
            {{ $products->links() }}
        </div>
    @endif
</div>

@endsection