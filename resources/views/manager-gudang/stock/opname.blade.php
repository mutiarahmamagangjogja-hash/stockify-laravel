@extends('layouts.manager-gudang')

@section('title', 'Stock Opname')

@section('page-title', 'Stock Opname')

@section('page-description', 'Pemeriksaan dan penyesuaian stok')

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
        Melihat hasil pemeriksaan dan penyesuaian stok yang dilakukan oleh Staff Gudang.
    </p>
</div>


{{-- ===================================================== --}}
{{-- SUCCESS MESSAGE --}}
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
{{-- ERROR MESSAGE --}}
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
{{-- VALIDATION ERROR --}}
{{-- ===================================================== --}}

@if($errors->any())

    <div
        class="p-4
               text-sm text-red-300
               bg-red-900/30
               border border-red-800
               rounded-lg"
    >

        <ul class="list-disc list-inside space-y-1">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

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

    {{-- ================================================= --}}
    {{-- TABLE HEADER --}}
    {{-- ================================================= --}}

    <div
        class="p-5
               border-b border-[#3A4254]"
    >

        <h3 class="text-lg font-semibold text-white">
            Riwayat Stock Opname
        </h3>

        <p class="mt-1 text-sm text-gray-400">
            Daftar pemeriksaan stok yang telah dilakukan.
        </p>

    </div>


    {{-- ================================================= --}}
    {{-- TABLE --}}
    {{-- ================================================= --}}

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-[#1E2533]">

                <tr>

                    {{-- NO --}}

                    <th
                        class="px-5 py-4
                               text-left
                               text-xs
                               font-semibold
                               text-gray-400
                               uppercase"
                    >
                        No
                    </th>


                    {{-- PRODUK --}}

                    <th
                        class="px-5 py-4
                               text-left
                               text-xs
                               font-semibold
                               text-gray-400
                               uppercase"
                    >
                        Produk
                    </th>


                    {{-- STOK SISTEM --}}

                    <th
                        class="px-5 py-4
                               text-center
                               text-xs
                               font-semibold
                               text-gray-400
                               uppercase"
                    >
                        Stok Sistem
                    </th>


                    {{-- STOK FISIK --}}

                    <th
                        class="px-5 py-4
                               text-center
                               text-xs
                               font-semibold
                               text-gray-400
                               uppercase"
                    >
                        Stok Fisik
                    </th>


                    {{-- SELISIH --}}

                    <th
                        class="px-5 py-4
                               text-center
                               text-xs
                               font-semibold
                               text-gray-400
                               uppercase"
                    >
                        Selisih
                    </th>


                    {{-- PEMERIKSA --}}

                    <th
                        class="px-5 py-4
                               text-left
                               text-xs
                               font-semibold
                               text-gray-400
                               uppercase"
                    >
                        Pemeriksa
                    </th>


                    {{-- TANGGAL --}}

                    <th
                        class="px-5 py-4
                               text-left
                               text-xs
                               font-semibold
                               text-gray-400
                               uppercase"
                    >
                        Tanggal
                    </th>


                    {{-- AKSI --}}

                    <th
                        class="px-5 py-4
                               text-center
                               text-xs
                               font-semibold
                               text-gray-400
                               uppercase"
                    >
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-[#3A4254]">

                @forelse($opnames as $index => $opname)

                    <tr
                        class="hover:bg-[#2D3445]
                               transition"
                    >

                        {{-- ================================================= --}}
                        {{-- NO --}}
                        {{-- ================================================= --}}

                        <td
                            class="px-5 py-4
                                   text-sm
                                   text-gray-400"
                        >

                            {{ $index + 1 }}

                        </td>


                        {{-- ================================================= --}}
                        {{-- PRODUK --}}
                        {{-- ================================================= --}}

                        <td class="px-5 py-4">

                            <div
                                class="text-sm
                                       font-medium
                                       text-white"
                            >

                                {{ $opname->product->name ?? '-' }}

                            </div>

                        </td>


                        {{-- ================================================= --}}
                        {{-- STOK SISTEM --}}
                        {{-- ================================================= --}}

                        <td
                            class="px-5 py-4
                                   text-center
                                   text-sm
                                   text-gray-300"
                        >

                            {{ $opname->system_stock }}

                            @if(
                                $opname->product &&
                                $opname->product->unit
                            )

                                {{ $opname->product->unit }}

                            @endif

                        </td>


                        {{-- ================================================= --}}
                        {{-- STOK FISIK --}}
                        {{-- ================================================= --}}

                        <td
                            class="px-5 py-4
                                   text-center
                                   text-sm
                                   font-medium
                                   text-white"
                        >

                            {{ $opname->physical_stock }}

                            @if(
                                $opname->product &&
                                $opname->product->unit
                            )

                                {{ $opname->product->unit }}

                            @endif

                        </td>


                        {{-- ================================================= --}}
                        {{-- SELISIH --}}
                        {{-- ================================================= --}}

                        <td class="px-5 py-4 text-center">

                            @if($opname->difference > 0)

                                <span
                                    class="inline-flex
                                           px-2.5 py-1
                                           rounded-md
                                           text-xs
                                           font-medium
                                           text-green-300
                                           bg-green-900/30
                                           border
                                           border-green-800"
                                >

                                    +{{ $opname->difference }}

                                </span>

                            @elseif($opname->difference < 0)

                                <span
                                    class="inline-flex
                                           px-2.5 py-1
                                           rounded-md
                                           text-xs
                                           font-medium
                                           text-red-300
                                           bg-red-900/30
                                           border
                                           border-red-800"
                                >

                                    {{ $opname->difference }}

                                </span>

                            @else

                                <span
                                    class="inline-flex
                                           px-2.5 py-1
                                           rounded-md
                                           text-xs
                                           font-medium
                                           text-gray-300
                                           bg-[#111B36]
                                           border
                                           border-[#3A4254]"
                                >

                                    0

                                </span>

                            @endif

                        </td>


                        {{-- ================================================= --}}
                        {{-- PEMERIKSA --}}
                        {{-- ================================================= --}}

                        <td
                            class="px-5 py-4
                                   text-sm
                                   text-gray-300"
                        >

                            {{ $opname->user->name ?? '-' }}

                        </td>


                        {{-- ================================================= --}}
                        {{-- TANGGAL --}}
                        {{-- ================================================= --}}

                        <td
                            class="px-5 py-4
                                   text-sm
                                   text-gray-400"
                        >

                            @if($opname->created_at)

                                {{ $opname->created_at->format('d/m/Y H:i') }}

                            @else

                                -

                            @endif

                        </td>


                        {{-- ================================================= --}}
                        {{-- AKSI --}}
                        {{-- ================================================= --}}

                        <td
                            class="px-5 py-4
                                   text-center"
                        >

                            {{-- 
                                PENTING:
                                INI ROUTE ADMIN.
                                JANGAN DIARAHKAN KE MANAGER.
                            --}}

                            <a
                                href="{{ route(
                                    'stok.opname.detail',
                                    $opname->id
                                ) }}"
                                class="inline-flex
                                       items-center
                                       justify-center
                                       px-3 py-2
                                       rounded-lg
                                       text-xs
                                       font-medium
                                       text-gray-300
                                       bg-[#111B36]
                                       border
                                       border-[#3A4254]
                                       hover:bg-[#0B132B]
                                       hover:text-white
                                       transition"
                            >

                                Lihat Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    {{-- ================================================= --}}
                    {{-- EMPTY DATA --}}
                    {{-- ================================================= --}}

                    <tr>

                        <td
                            colspan="8"
                            class="px-5 py-12
                                   text-center
                                   text-sm
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
