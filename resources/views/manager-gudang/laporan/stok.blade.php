@extends('layouts.manager-gudang')

@section('title', 'Laporan Stok - Stockify')

@section('page-title', 'Laporan Stok')

@section(
    'page-description',
    'Informasi persediaan barang Stockify'
)

@section('content')

<!-- ===================================================== -->
<!-- HEADER -->
<!-- ===================================================== -->

<div class="mb-6">

    <h2 class="text-2xl font-bold text-white">
        Laporan Stok
    </h2>

    <p class="mt-1 text-sm text-gray-400">
        Informasi stok seluruh produk
    </p>

</div>


<!-- ===================================================== -->
<!-- CARDS -->
<!-- ===================================================== -->

<div class="grid grid-cols-3 gap-5 mb-6">

    <div
        class="p-5 bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        <p class="text-sm text-gray-400">
            Total Produk
        </p>

        <h3 class="mt-2 text-3xl font-bold text-white">
            {{ $totalProducts }}
        </h3>

    </div>


    <div
        class="p-5 bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        <p class="text-sm text-gray-400">
            Total Stok
        </p>

        <h3 class="mt-2 text-3xl font-bold text-white">
            {{ $totalStock }}
        </h3>

    </div>


    <div
        class="p-5 bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        <p class="text-sm text-gray-400">
            Stok Menipis
        </p>

        <h3 class="mt-2 text-3xl font-bold text-white">
            {{ $lowStock }}
        </h3>

    </div>

</div>


<!-- ===================================================== -->
<!-- TABLE -->
<!-- ===================================================== -->

<div
    class="bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           shadow-sm"
>

    <div
        class="p-5
               border-b border-[#3A4254]"
    >

        <h3 class="text-lg font-semibold text-white">
            Daftar Stok Produk
        </h3>

        <p class="text-sm text-gray-400">
            Kondisi stok produk saat ini
        </p>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full text-sm text-left">

            <thead
                class="text-xs
                       text-gray-400
                       uppercase
                       bg-[#2D3445]"
            >

                <tr>

                    <th class="px-6 py-3">
                        Produk
                    </th>

                    <th class="px-6 py-3">
                        Kategori
                    </th>

                    <th class="px-6 py-3">
                        Stok
                    </th>

                    <th class="px-6 py-3">
                        Minimum
                    </th>

                    <th class="px-6 py-3">
                        Status
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($products as $product)

                    <tr
                        class="border-b
                               border-[#3A4254]
                               hover:bg-[#2D3445]"
                    >

                        <td
                            class="px-6 py-4
                                   font-medium
                                   text-white"
                        >

                            {{ $product->name }}

                        </td>


                        <td class="px-6 py-4 text-gray-400">

                            {{ $product->category->name ?? '-' }}

                        </td>


                        <td
                            class="px-6 py-4
                                   font-semibold
                                   text-white"
                        >

                            {{ $product->stock }}

                            {{ $product->unit }}

                        </td>


                        <td class="px-6 py-4 text-gray-300">

                            {{ $product->minimum_stock }}

                        </td>


                        <td class="px-6 py-4">

                            @if(
                                $product->stock <=
                                $product->minimum_stock
                            )

                                <span
                                    class="px-2.5 py-1
                                           text-xs font-medium
                                           text-red-300
                                           bg-red-900/40
                                           rounded-full"
                                >

                                    Stok Rendah

                                </span>

                            @else

                                <span
                                    class="px-2.5 py-1
                                           text-xs font-medium
                                           text-green-300
                                           bg-green-900/40
                                           rounded-full"
                                >

                                    Aman

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="px-6 py-10
                                   text-center
                                   text-gray-400"
                        >

                            Belum ada data produk.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
