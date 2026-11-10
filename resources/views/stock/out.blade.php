```blade
@extends('layouts.app')

@section('title', 'Stok Keluar - Stockify')

@section('page-title', 'Stok Keluar')

@section('page-description', 'Kelola transaksi stok keluar produk')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}

    <div>

        <h2 class="text-2xl font-bold text-white">
            Stok Keluar
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Catat pengurangan stok produk dari persediaan.
        </p>

    </div>


    {{-- SUCCESS --}}

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


    {{-- ERROR --}}

    @if($errors->any())

        <div
            class="p-4
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


    {{-- ================================================= --}}
    {{-- FORM STOK KELUAR --}}
    {{-- ================================================= --}}

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               overflow-hidden"
    >

        <div
            class="p-5
                   border-b border-[#3A4254]"
        >

            <h3 class="text-lg font-semibold text-white">
                Tambah Stok Keluar
            </h3>

            <p class="mt-1 text-sm text-gray-400">
                Pilih produk dan masukkan jumlah stok yang keluar.
            </p>

        </div>


        <div class="p-5">

            <form
                action="{{ route('stok.keluar.store') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf


                {{-- PRODUK --}}

                <div>

                    <label
                        for="product_id"
                        class="block mb-2
                               text-sm font-medium
                               text-gray-300"
                    >

                        Produk

                        <span class="text-red-400">
                            *
                        </span>

                    </label>


                    <select
                        id="product_id"
                        name="product_id"
                        required
                        class="w-full
                               px-4 py-3
                               text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg
                               focus:outline-none
                               focus:ring-2
                               focus:ring-gray-600"
                    >

                        <option value="">
                            -- Pilih Produk --
                        </option>


                        @forelse($products as $product)

                            <option
                                value="{{ $product->id }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}
                            >

                                {{ $product->name }}

                                — Stok:
                                {{ $product->stock }}
                                {{ $product->unit }}

                            </option>

                        @empty

                            <option value="" disabled>
                                Belum ada produk aktif
                            </option>

                        @endforelse

                    </select>

                </div>


                {{-- JUMLAH --}}

                <div>

                    <label
                        for="quantity"
                        class="block mb-2
                               text-sm font-medium
                               text-gray-300"
                    >

                        Jumlah Stok Keluar

                        <span class="text-red-400">
                            *
                        </span>

                    </label>


                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        value="{{ old('quantity') }}"
                        min="1"
                        required
                        placeholder="Contoh: 5"
                        class="w-full
                               px-4 py-3
                               text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg
                               placeholder-gray-500
                               focus:outline-none
                               focus:ring-2
                               focus:ring-gray-600"
                    >

                </div>


                {{-- REFERENSI --}}

                <div>

                    <label
                        for="reference_number"
                        class="block mb-2
                               text-sm font-medium
                               text-gray-300"
                    >

                        Nomor Referensi

                    </label>


                    <input
                        type="text"
                        id="reference_number"
                        name="reference_number"
                        value="{{ old('reference_number') }}"
                        placeholder="Contoh: SO-001"
                        class="w-full
                               px-4 py-3
                               text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg
                               placeholder-gray-500
                               focus:outline-none
                               focus:ring-2
                               focus:ring-gray-600"
                    >

                </div>


                {{-- KETERANGAN --}}

                <div>

                    <label
                        for="description"
                        class="block mb-2
                               text-sm font-medium
                               text-gray-300"
                    >

                        Keterangan

                    </label>


                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        placeholder="Masukkan keterangan..."
                        class="w-full
                               px-4 py-3
                               text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg
                               placeholder-gray-500
                               focus:outline-none
                               focus:ring-2
                               focus:ring-gray-600"
                    >{{ old('description') }}</textarea>

                </div>


                {{-- BUTTON --}}

                <div class="flex justify-end">

                    <button
                        type="submit"
                        class="px-5 py-3
                               text-sm font-medium
                               text-white
                               bg-[#111B36]
                               border border-[#3A4254]
                               rounded-lg
                               hover:bg-[#0B132B]"
                    >

                        Simpan Stok Keluar

                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- RIWAYAT STOK KELUAR --}}
    {{-- ================================================= --}}

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               overflow-hidden"
    >

        <div
            class="p-5
                   border-b border-[#3A4254]"
        >

            <h3 class="text-lg font-semibold text-white">
                Riwayat Stok Keluar
            </h3>

            <p class="mt-1 text-sm text-gray-400">
                Daftar transaksi stok keluar.
            </p>

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
                            Produk
                        </th>

                        <th class="px-6 py-4">
                            SKU
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

                        <th class="px-6 py-4">
                            Tanggal
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-[#3A4254]">

                    @forelse($transactions as $transaction)

                        <tr
                            class="hover:bg-[#2D3445]"
                        >

                            {{-- NO --}}

                            <td class="px-6 py-4 text-gray-400">

                                {{ $transactions->firstItem() + $loop->index }}

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


                            {{-- JUMLAH --}}

                            <td class="px-6 py-4">

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

                                    -{{ $transaction->quantity }}
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


                            {{-- TANGGAL --}}

                            <td
                                class="px-6 py-4
                                       text-gray-400
                                       whitespace-nowrap"
                            >

                                {{ $transaction->created_at->format('d/m/Y H:i') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-10
                                       text-center
                                       text-gray-500"
                            >

                                Belum ada transaksi stok keluar.

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
