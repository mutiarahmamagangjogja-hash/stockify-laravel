```blade
@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('page-title', 'Riwayat Transaksi')

@section('page-description', 'Riwayat seluruh transaksi stok masuk dan stok keluar')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}

    <div>

        <h2 class="text-2xl font-bold text-white">
            Riwayat Transaksi
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Menampilkan seluruh aktivitas stok masuk dan stok keluar.
        </p>

    </div>


    {{-- TABLE --}}

    <div
        class="overflow-hidden
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        <div
            class="p-5
                   border-b border-[#3A4254]"
        >

            <h3 class="text-lg font-semibold text-white">
                Semua Transaksi
            </h3>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead
                    class="bg-[#2D3445]
                           text-xs
                           uppercase
                           text-gray-400"
                >

                    <tr>

                        <th class="px-6 py-4">
                            No
                        </th>

                        <th class="px-6 py-4">
                            Tanggal
                        </th>

                        <th class="px-6 py-4">
                            Produk
                        </th>

                        <th class="px-6 py-4">
                            SKU
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


                <tbody class="divide-y divide-[#3A4254]">

                    @forelse($transactions as $transaction)

                        <tr class="hover:bg-[#2D3445]">

                            {{-- NO --}}

                            <td class="px-6 py-4 text-gray-400">

                                {{ $transactions->firstItem() + $loop->index }}

                            </td>


                            {{-- TANGGAL --}}

                            <td
                                class="px-6 py-4
                                       text-gray-400
                                       whitespace-nowrap"
                            >

                                {{ $transaction->created_at->format('d/m/Y H:i') }}

                            </td>


                            {{-- PRODUK --}}

                            <td class="px-6 py-4">

                                <span class="font-medium text-white">

                                    {{ $transaction->product->name }}

                                </span>

                            </td>


                            {{-- SKU --}}

                            <td class="px-6 py-4 text-gray-400">

                                {{ $transaction->product->sku }}

                            </td>


                            {{-- TIPE --}}

                            <td class="px-6 py-4">

                                @if($transaction->type === 'in')

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               text-xs
                                               font-medium
                                               text-green-300
                                               bg-green-900/30
                                               border border-green-800
                                               rounded-lg"
                                    >

                                        Stok Masuk

                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               text-xs
                                               font-medium
                                               text-red-300
                                               bg-red-900/30
                                               border border-red-800
                                               rounded-lg"
                                    >

                                        Stok Keluar

                                    </span>

                                @endif

                            </td>


                            {{-- JUMLAH --}}

                            <td class="px-6 py-4">

                                @if($transaction->type === 'in')

                                    <span class="font-semibold text-green-400">

                                        +{{ $transaction->quantity }}

                                    </span>

                                @else

                                    <span class="font-semibold text-red-400">

                                        -{{ $transaction->quantity }}

                                    </span>

                                @endif

                                <span class="text-gray-500">

                                    {{ $transaction->product->unit }}

                                </span>

                            </td>


                            {{-- REFERENSI --}}

                            <td class="px-6 py-4 text-gray-300">

                                {{ $transaction->reference_number ?? '-' }}

                            </td>


                            {{-- KETERANGAN --}}

                            <td class="px-6 py-4 text-gray-400">

                                {{ $transaction->description ?? '-' }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="px-6 py-12
                                       text-center
                                       text-gray-500"
                            >

                                Belum ada transaksi stok.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        @if($transactions->hasPages())

            <div
                class="p-5
                       border-t border-[#3A4254]"
            >

                {{ $transactions->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
```
