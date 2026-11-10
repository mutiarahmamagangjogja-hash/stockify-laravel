```blade
@extends('layouts.app')

@section('title', 'Laporan')

@section('page-title', 'Laporan')

@section('page-description', 'Laporan dan rekapitulasi aktivitas stok Stockify')

@section('content')

<div class="space-y-6">

    {{-- FILTER --}}

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        <div
            class="px-6 py-5
                   border-b border-[#3A4254]"
        >

            <h2 class="text-lg font-semibold text-white">
                Filter Laporan
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                Pilih periode laporan yang ingin ditampilkan.
            </p>

        </div>


        <form
            action="{{ route('laporan.index') }}"
            method="GET"
            class="p-6"
        >

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>

                    <label
                        for="start_date"
                        class="block mb-2
                               text-sm
                               font-medium
                               text-gray-300"
                    >
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ $startDate }}"
                        class="w-full
                               px-4 py-3
                               text-sm
                               text-white
                               bg-[#111B36]
                               border border-[#3A4254]
                               rounded-lg"
                    >

                </div>


                <div>

                    <label
                        for="end_date"
                        class="block mb-2
                               text-sm
                               font-medium
                               text-gray-300"
                    >
                        Tanggal Akhir
                    </label>

                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ $endDate }}"
                        class="w-full
                               px-4 py-3
                               text-sm
                               text-white
                               bg-[#111B36]
                               border border-[#3A4254]
                               rounded-lg"
                    >

                </div>


                <div class="flex items-end">

                    <button
                        type="submit"
                        class="w-full
                               px-4 py-3
                               text-sm
                               font-medium
                               text-white
                               bg-[#111B36]
                               border border-[#3A4254]
                               rounded-lg
                               hover:bg-[#0B132B]"
                    >
                        Tampilkan Laporan
                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- SUMMARY --}}

    <div
        class="grid grid-cols-1
               sm:grid-cols-2
               lg:grid-cols-5
               gap-4"
    >

        {{-- PRODUK --}}

        <div
            class="bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   p-5"
        >

            <p class="text-sm text-gray-400">
                Total Produk
            </p>

            <p class="mt-2 text-2xl font-bold text-white">
                {{ $totalProducts }}
            </p>

        </div>


        {{-- STOK --}}

        <div
            class="bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   p-5"
        >

            <p class="text-sm text-gray-400">
                Total Stok
            </p>

            <p class="mt-2 text-2xl font-bold text-white">
                {{ number_format($totalStock) }}
            </p>

        </div>


        {{-- MASUK --}}

        <div
            class="bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   p-5"
        >

            <p class="text-sm text-gray-400">
                Stok Masuk
            </p>

            <p class="mt-2 text-2xl font-bold text-green-400">
                +{{ number_format($stockIn) }}
            </p>

        </div>


        {{-- KELUAR --}}

        <div
            class="bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   p-5"
        >

            <p class="text-sm text-gray-400">
                Stok Keluar
            </p>

            <p class="mt-2 text-2xl font-bold text-red-400">
                -{{ number_format($stockOut) }}
            </p>

        </div>


        {{-- STOK RENDAH --}}

        <div
            class="bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   p-5"
        >

            <p class="text-sm text-gray-400">
                Stok Rendah
            </p>

            <p class="mt-2 text-2xl font-bold text-yellow-400">
                {{ $lowStock }}
            </p>

        </div>

    </div>


    {{-- TRANSACTION TABLE --}}

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               overflow-hidden"
    >

        <div
            class="px-6 py-5
                   border-b border-[#3A4254]"
        >

            <h2 class="text-lg font-semibold text-white">
                Riwayat Transaksi
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                {{ $startDate }} sampai {{ $endDate }}
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

                        <th class="px-6 py-4">
                            Tanggal
                        </th>

                        <th class="px-6 py-4">
                            Produk
                        </th>

                        <th class="px-6 py-4">
                            Tipe
                        </th>

                        <th class="px-6 py-4">
                            Jumlah
                        </th>

                        <th class="px-6 py-4">
                            Referensi
                        </th>

                        <th class="px-6 py-4">
                            Keterangan
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($transactions as $transaction)

                        <tr
                            class="border-b
                                   border-[#3A4254]
                                   hover:bg-[#2D3445]"
                        >

                            <td class="px-6 py-4 text-gray-400">

                                {{ $transaction->created_at->format('d/m/Y H:i') }}

                            </td>


                            <td
                                class="px-6 py-4
                                       font-medium
                                       text-white"
                            >

                                {{ $transaction->product->name ?? '-' }}

                            </td>


                            <td class="px-6 py-4">

                                @if($transaction->type === 'in')

                                    <span
                                        class="px-2.5 py-1
                                               text-xs
                                               font-medium
                                               text-green-300
                                               bg-green-900/30
                                               border border-green-800
                                               rounded-full"
                                    >
                                        Stok Masuk
                                    </span>

                                @else

                                    <span
                                        class="px-2.5 py-1
                                               text-xs
                                               font-medium
                                               text-red-300
                                               bg-red-900/30
                                               border border-red-800
                                               rounded-full"
                                    >
                                        Stok Keluar
                                    </span>

                                @endif

                            </td>


                            <td
                                class="px-6 py-4
                                       font-semibold
                                       text-white"
                            >

                                {{ number_format($transaction->quantity) }}

                            </td>


                            <td class="px-6 py-4 text-gray-400">

                                {{ $transaction->reference_number ?? '-' }}

                            </td>


                            <td class="px-6 py-4 text-gray-400">

                                {{ $transaction->description ?? '-' }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-12
                                       text-center
                                       text-gray-500"
                            >

                                Belum ada transaksi pada periode tersebut.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
```
