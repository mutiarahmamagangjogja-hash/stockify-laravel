@extends('layouts.manager-gudang')

@section('title', 'Laporan Transaksi - Stockify')

@section('page-title', 'Barang Masuk & Keluar')

@section(
    'page-description',
    'Laporan transaksi persediaan Stockify'
)

@section('content')

<!-- ===================================================== -->
<!-- HEADER -->
<!-- ===================================================== -->

<div class="mb-6">

    <h2 class="text-2xl font-bold text-white">
        Barang Masuk & Keluar
    </h2>

    <p class="mt-1 text-sm text-gray-400">
        Riwayat transaksi persediaan
    </p>

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
        method="GET"
        action="{{ route('manager-gudang.laporan.transaksi') }}"
        class="flex items-end gap-4"
    >

        <div>

            <label
                class="block mb-2
                       text-sm text-gray-400"
            >
                Tanggal Mulai
            </label>

            <input
                type="date"
                name="start_date"
                value="{{ $startDate }}"
                class="px-3 py-2
                       text-sm text-white
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg
                       focus:outline-none"
            >

        </div>


        <div>

            <label
                class="block mb-2
                       text-sm text-gray-400"
            >
                Tanggal Akhir
            </label>

            <input
                type="date"
                name="end_date"
                value="{{ $endDate }}"
                class="px-3 py-2
                       text-sm text-white
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg
                       focus:outline-none"
            >

        </div>


        <button
            type="submit"
            class="px-4 py-2
                   text-sm font-medium
                   text-white
                   bg-[#111B36]
                   border border-[#3A4254]
                   rounded-lg
                   hover:bg-[#0B132B]"
        >

            Filter

        </button>

    </form>

</div>


<!-- ===================================================== -->
<!-- RINGKASAN -->
<!-- ===================================================== -->

<div class="grid grid-cols-2 gap-5 mb-6">

    <div
        class="p-5
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        <p class="text-sm text-gray-400">
            Total Barang Masuk
        </p>

        <h3
            class="mt-2
                   text-3xl
                   font-bold
                   text-green-400"
        >

            {{ $stockIn }}

        </h3>

    </div>


    <div
        class="p-5
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        <p class="text-sm text-gray-400">
            Total Barang Keluar
        </p>

        <h3
            class="mt-2
                   text-3xl
                   font-bold
                   text-red-400"
        >

            {{ $stockOut }}

        </h3>

    </div>

</div>


<!-- ===================================================== -->
<!-- TABLE TRANSAKSI -->
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
            Riwayat Transaksi
        </h3>

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
                        Tanggal
                    </th>

                    <th class="px-6 py-3">
                        Produk
                    </th>

                    <th class="px-6 py-3">
                        Jenis
                    </th>

                    <th class="px-6 py-3">
                        Jumlah
                    </th>

                    <th class="px-6 py-3">
                        Referensi
                    </th>

                    <th class="px-6 py-3">
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
                                           text-xs font-medium
                                           text-green-300
                                           bg-green-900/40
                                           rounded-full"
                                >

                                    Barang Masuk

                                </span>

                            @else

                                <span
                                    class="px-2.5 py-1
                                           text-xs font-medium
                                           text-red-300
                                           bg-red-900/40
                                           rounded-full"
                                >

                                    Barang Keluar

                                </span>

                            @endif

                        </td>


                        <td
                            class="px-6 py-4
                                   font-semibold
                                   text-white"
                        >

                            {{ $transaction->quantity }}

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
                            class="px-6 py-10
                                   text-center
                                   text-gray-400"
                        >

                            Tidak ada transaksi
                            pada periode tersebut.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
