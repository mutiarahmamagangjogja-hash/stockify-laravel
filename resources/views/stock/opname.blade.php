@extends('layouts.app')

@section('title', 'Stock Opname')

@section('page-title', 'Stock Opname')

@section('page-description', 'Melihat hasil pemeriksaan dan penyesuaian stok')

@section('content')

<div class="space-y-6">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}

    <div>

        <h2 class="text-2xl font-bold text-white">
            Stock Opname
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Daftar hasil pemeriksaan stok fisik yang dilakukan oleh Staff Gudang.
        </p>

    </div>


    {{-- ===================================================== --}}
    {{-- SUCCESS --}}
    {{-- ===================================================== --}}

    @if(session('success'))

        <div
            class="p-4
                   text-sm text-green-300
                   bg-green-900/30
                   border border-green-800
                   rounded-lg"
        >

            {{ session('success') }}

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- ERROR --}}
    {{-- ===================================================== --}}

    @if(session('error'))

        <div
            class="p-4
                   text-sm text-red-300
                   bg-red-900/30
                   border border-red-800
                   rounded-lg"
        >

            {{ session('error') }}

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- TABLE --}}
    {{-- ===================================================== --}}

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               overflow-hidden"
    >

        {{-- HEADER TABLE --}}

        <div
            class="px-5 py-4
                   border-b border-[#3A4254]"
        >

            <h3 class="text-lg font-semibold text-white">
                Riwayat Stock Opname
            </h3>

            <p class="mt-1 text-sm text-gray-400">
                Hasil pemeriksaan stok berdasarkan data sistem dan stok fisik.
            </p>

        </div>


        {{-- TABLE --}}

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead
                    class="bg-[#1E2432]
                           text-xs uppercase
                           text-gray-400"
                >

                    <tr>

                        <th class="px-5 py-4">
                            No
                        </th>

                        <th class="px-5 py-4">
                            Produk
                        </th>

                        <th class="px-5 py-4">
                            Stok Sistem
                        </th>

                        <th class="px-5 py-4">
                            Stok Fisik
                        </th>

                        <th class="px-5 py-4">
                            Selisih
                        </th>

                        <th class="px-5 py-4">
                            Petugas Pemeriksa
                        </th>

                        <th class="px-5 py-4">
                            Tanggal
                        </th>

                        <th class="px-5 py-4 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-[#3A4254]">

                    @forelse($opnames as $index => $opname)

                        <tr class="hover:bg-[#2D3445]">

                            {{-- NO --}}

                            <td class="px-5 py-4 text-gray-300">

                                {{ $index + 1 }}

                            </td>


                            {{-- PRODUK --}}

                            <td class="px-5 py-4">

                                <span class="font-medium text-white">

                                    {{ $opname->product->name ?? '-' }}

                                </span>

                            </td>


                            {{-- STOK SISTEM --}}

                            <td class="px-5 py-4 text-gray-300">

                                {{ $opname->system_stock }}

                                {{ $opname->product->unit ?? '' }}

                            </td>


                            {{-- STOK FISIK --}}

                            <td class="px-5 py-4 text-gray-300">

                                {{ $opname->physical_stock }}

                                {{ $opname->product->unit ?? '' }}

                            </td>


                            {{-- SELISIH --}}

                            <td class="px-5 py-4">

                                @if($opname->difference > 0)

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-md
                                               text-xs
                                               font-medium
                                               bg-green-900/30
                                               text-green-300
                                               border border-green-800"
                                    >

                                        +{{ $opname->difference }}
                                        {{ $opname->product->unit ?? '' }}

                                    </span>

                                @elseif($opname->difference < 0)

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-md
                                               text-xs
                                               font-medium
                                               bg-red-900/30
                                               text-red-300
                                               border border-red-800"
                                    >

                                        {{ $opname->difference }}
                                        {{ $opname->product->unit ?? '' }}

                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-md
                                               text-xs
                                               font-medium
                                               bg-gray-800
                                               text-gray-300
                                               border border-gray-700"
                                    >

                                        0
                                        {{ $opname->product->unit ?? '' }}

                                    </span>

                                @endif

                            </td>


                            {{-- PETUGAS PEMERIKSA --}}

                            <td class="px-5 py-4 text-gray-300">

                                {{ $opname->inspector_name ?? '-' }}

                            </td>


                            {{-- TANGGAL --}}

                            <td class="px-5 py-4 text-gray-400">

                                {{ $opname->created_at?->format('d/m/Y H:i') ?? '-' }}

                            </td>


                            {{-- AKSI --}}

                            <td class="px-5 py-4 text-center">

                                <a
                                    href="{{ route('stok.opname.detail', $opname) }}"
                                    class="inline-flex
                                           items-center
                                           px-3 py-2
                                           text-xs
                                           font-medium
                                           text-gray-300
                                           bg-[#2D3445]
                                           border border-[#3A4254]
                                           rounded-lg
                                           hover:bg-[#3A4254]
                                           hover:text-white"
                                >

                                    Lihat Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="px-5 py-12
                                       text-center
                                       text-gray-500"
                            >

                                Belum ada data stock opname.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection