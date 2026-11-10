@extends('layouts.app')

@section('title', 'Detail Stock Opname')

@section('page-title', 'Detail Stock Opname')

@section('page-description', 'Detail hasil pemeriksaan stok fisik')

@section('content')

<div class="space-y-6">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}

    <div class="flex items-center justify-between">

        <div>

            <h2 class="text-2xl font-bold text-white">
                Detail Stock Opname
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                Informasi lengkap hasil pemeriksaan stok.
            </p>

        </div>


        <a
            href="{{ route('stok.opname') }}"
            class="inline-flex
                   items-center
                   px-4 py-2
                   text-sm
                   font-medium
                   text-gray-300
                   bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   hover:bg-[#2D3445]
                   hover:text-white"
        >

            Kembali

        </a>

    </div>


    {{-- ===================================================== --}}
    {{-- INFORMASI --}}
    {{-- ===================================================== --}}

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               overflow-hidden"
    >

        <div
            class="px-5 py-4
                   border-b border-[#3A4254]"
        >

            <h3 class="text-lg font-semibold text-white">
                Informasi Stock Opname
            </h3>

        </div>


        <div class="p-5">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>

                    <p class="text-sm text-gray-500">
                        Produk
                    </p>

                    <p class="mt-1 text-base font-medium text-white">

                        {{ $opname->product->name ?? '-' }}

                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Petugas
                    </p>

                    <p class="mt-1 text-base font-medium text-white">

                        {{ $opname->user->name ?? '-' }}

                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Tanggal Pemeriksaan
                    </p>

                    <p class="mt-1 text-base font-medium text-white">

                        {{ $opname->created_at?->format('d F Y, H:i') ?? '-' }}

                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Satuan
                    </p>

                    <p class="mt-1 text-base font-medium text-white">

                        {{ $opname->product->unit ?? '-' }}

                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- STOK --}}
    {{-- ===================================================== --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- SYSTEM --}}

        <div
            class="bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   p-5"
        >

            <p class="text-sm text-gray-400">
                Stok Sistem
            </p>

            <p class="mt-2 text-3xl font-bold text-white">

                {{ $opname->system_stock }}

            </p>

            <p class="mt-1 text-sm text-gray-500">

                {{ $opname->product->unit ?? '' }}

            </p>

        </div>


        {{-- FISIK --}}

        <div
            class="bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   p-5"
        >

            <p class="text-sm text-gray-400">
                Stok Fisik
            </p>

            <p class="mt-2 text-3xl font-bold text-white">

                {{ $opname->physical_stock }}

            </p>

            <p class="mt-1 text-sm text-gray-500">

                {{ $opname->product->unit ?? '' }}

            </p>

        </div>


        {{-- SELISIH --}}

        <div
            class="bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   p-5"
        >

            <p class="text-sm text-gray-400">
                Selisih
            </p>


            @if($opname->difference > 0)

                <p class="mt-2 text-3xl font-bold text-green-400">

                    +{{ $opname->difference }}

                </p>

            @elseif($opname->difference < 0)

                <p class="mt-2 text-3xl font-bold text-red-400">

                    {{ $opname->difference }}

                </p>

            @else

                <p class="mt-2 text-3xl font-bold text-gray-300">

                    0

                </p>

            @endif


            <p class="mt-1 text-sm text-gray-500">

                {{ $opname->product->unit ?? '' }}

            </p>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- KETERANGAN --}}
    {{-- ===================================================== --}}

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        <div
            class="px-5 py-4
                   border-b border-[#3A4254]"
        >

            <h3 class="text-lg font-semibold text-white">
                Keterangan
            </h3>

        </div>


        <div class="p-5">

            @if($opname->description)

                <p class="text-sm leading-6 text-gray-300">

                    {{ $opname->description }}

                </p>

            @else

                <p class="text-sm text-gray-500">

                    Tidak ada keterangan.

                </p>

            @endif

        </div>

    </div>

</div>

@endsection