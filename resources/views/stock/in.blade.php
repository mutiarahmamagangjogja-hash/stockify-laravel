@extends('layouts.app')

@section('title', 'Stok Masuk')

@section('page-title', 'Stok Masuk')

@section('page-description', 'Kelola transaksi stok masuk produk')

@section('content')

<div class="space-y-6">

    {{-- FORM STOK MASUK --}}

    <div class="bg-[#252B3A] border border-[#3A4254] rounded-lg">

        <div class="p-5 border-b border-[#3A4254]">

            <h2 class="text-xl font-semibold text-white">
                Tambah Stok Masuk
            </h2>

            <p class="text-sm text-gray-400 mt-1">
                Tambahkan stok produk ke dalam persediaan.
            </p>

        </div>

        <div class="p-5">

            <form
                action="{{ route('stok.masuk.store') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf

                {{-- PRODUK --}}

                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Produk
                    </label>

                    <select
                        name="product_id"
                        required
                        class="w-full px-4 py-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                    >

                        <option value="">
                            -- Pilih Produk --
                        </option>

                        @foreach($products as $product)

                            <option value="{{ $product->id }}">

                                {{ $product->name }}

                                — Stok:
                                {{ $product->stock }}

                                {{ $product->unit }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- JUMLAH --}}

                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Jumlah Stok Masuk
                    </label>

                    <input
                        type="number"
                        name="quantity"
                        min="1"
                        required
                        placeholder="Masukkan jumlah"
                        class="w-full px-4 py-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                    >

                </div>


                {{-- NOMOR REFERENSI --}}

                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Nomor Referensi
                    </label>

                    <input
                        type="text"
                        name="reference_number"
                        placeholder="Contoh: PO-001"
                        class="w-full px-4 py-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                    >

                </div>


                {{-- KETERANGAN --}}

                <div>

                    <label class="block mb-2 text-sm text-gray-300">
                        Keterangan
                    </label>

                    <textarea
                        name="description"
                        rows="3"
                        placeholder="Masukkan keterangan..."
                        class="w-full px-4 py-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                    ></textarea>

                </div>


                {{-- BUTTON --}}

                <div class="flex justify-end">

                    <button
                        type="submit"
                        class="px-5 py-3 bg-[#111B36] border border-[#3A4254] rounded-lg text-white hover:bg-[#0B132B]"
                    >

                        Simpan Stok Masuk

                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- RIWAYAT --}}

    <div class="bg-[#252B3A] border border-[#3A4254] rounded-lg">

        <div class="p-5 border-b border-[#3A4254]">

            <h2 class="text-xl font-semibold text-white">
                Riwayat Stok Masuk
            </h2>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-[#2D3445]">

                    <tr>

                        <th class="px-6 py-4 text-left text-gray-400">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-gray-400">
                            Produk
                        </th>

                        <th class="px-6 py-4 text-left text-gray-400">
                            Jumlah
                        </th>

                        <th class="px-6 py-4 text-left text-gray-400">
                            Referensi
                        </th>

                        <th class="px-6 py-4 text-left text-gray-400">
                            Keterangan
                        </th>

                        <th class="px-6 py-4 text-left text-gray-400">
                            Tanggal
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-[#3A4254]">

                    @forelse($transactions as $transaction)

                        <tr>

                            <td class="px-6 py-4 text-gray-400">
                                {{ $transactions->firstItem() + $loop->index }}
                            </td>

                            <td class="px-6 py-4 text-white">
                                {{ $transaction->product->name }}
                            </td>

                            <td class="px-6 py-4 text-green-400">
                                +{{ $transaction->quantity }}
                            </td>

                            <td class="px-6 py-4 text-gray-400">
                                {{ $transaction->reference_number ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-gray-400">
                                {{ $transaction->description ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-gray-400">
                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-10 text-center text-gray-500"
                            >

                                Belum ada transaksi stok masuk.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection