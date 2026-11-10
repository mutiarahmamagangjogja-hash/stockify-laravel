@extends('layouts.manager-gudang')

@section('title', 'Barang Keluar - Manager Gudang')

@section('page-title', 'Barang Keluar')

@section(
    'page-description',
    'Pencatatan dan pengelolaan barang keluar'
)

@section('content')

<div class="space-y-6">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}

    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div>

            <h2 class="text-2xl font-bold text-white">
                Barang Keluar
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                Daftar dan pencatatan barang yang keluar dari gudang.
            </p>

        </div>


        <a
            href="{{ route('manager-gudang.stok.keluar.create') }}"
            class="
                inline-flex
                items-center
                justify-center
                px-5
                py-3
                rounded-lg
                bg-[#252B3A]
                text-white
                font-medium
                hover:bg-[#2D3445]
                transition
            "
        >
            + Tambah Barang Keluar
        </a>

    </div>


    {{-- ===================================================== --}}
    {{-- SUCCESS --}}
    {{-- ===================================================== --}}

    @if(session('success'))

        <div
            class="
                rounded-lg
                border
                border-green-500/30
                bg-green-500/10
                px-4
                py-3
                text-sm
                text-green-400
            "
        >

            {{ session('success') }}

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- ERROR --}}
    {{-- ===================================================== --}}

    @if($errors->any())

        <div
            class="
                rounded-lg
                border
                border-red-500/30
                bg-red-500/10
                px-4
                py-3
                text-sm
                text-red-400
            "
        >

            <ul class="list-disc ml-5 space-y-1">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- FORM TAMBAH --}}
    {{-- ===================================================== --}}

    @if(isset($products))

        <div
            class="
                bg-[#111B36]
                border
                border-[#252B3A]
                rounded-xl
                p-6
            "
        >

            <div class="mb-6">

                <h3 class="text-lg font-semibold text-white">
                    Tambah Barang Keluar
                </h3>

                <p class="mt-1 text-sm text-gray-400">
                    Isi data barang yang dikeluarkan dari gudang.
                </p>

            </div>


            <form
                action="{{ route('manager-gudang.stok.keluar.store') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf


                {{-- PRODUK --}}

                <div>

                    <label
                        class="
                            block
                            mb-2
                            text-sm
                            font-medium
                            text-gray-300
                        "
                    >
                        Produk
                    </label>

                    <select
                        name="product_id"
                        required
                        class="
                            w-full
                            rounded-lg
                            bg-[#252B3A]
                            border
                            border-[#3A4254]
                            px-4
                            py-3
                            text-white
                            focus:outline-none
                        "
                    >

                        <option value="">
                            -- Pilih Produk --
                        </option>

                        @foreach($products as $product)

                            <option
                                value="{{ $product->id }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}
                            >

                                {{ $product->name }}

                                -
                                Stok:
                                {{ $product->stock }}
                                {{ $product->unit ?? '' }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- JUMLAH --}}

                <div>

                    <label
                        class="
                            block
                            mb-2
                            text-sm
                            font-medium
                            text-gray-300
                        "
                    >
                        Jumlah
                    </label>

                    <input
                        type="number"
                        name="quantity"
                        min="1"
                        value="{{ old('quantity') }}"
                        required
                        class="
                            w-full
                            rounded-lg
                            bg-[#252B3A]
                            border
                            border-[#3A4254]
                            px-4
                            py-3
                            text-white
                            focus:outline-none
                        "
                        placeholder="Masukkan jumlah barang"
                    >

                </div>


                {{-- NOMOR REFERENSI --}}

                <div>

                    <label
                        class="
                            block
                            mb-2
                            text-sm
                            font-medium
                            text-gray-300
                        "
                    >
                        Nomor Referensi
                    </label>

                    <input
                        type="text"
                        name="reference_number"
                        value="{{ old('reference_number') }}"
                        class="
                            w-full
                            rounded-lg
                            bg-[#252B3A]
                            border
                            border-[#3A4254]
                            px-4
                            py-3
                            text-white
                            focus:outline-none
                        "
                        placeholder="Contoh: SO-001"
                    >

                </div>


                {{-- KETERANGAN --}}

                <div>

                    <label
                        class="
                            block
                            mb-2
                            text-sm
                            font-medium
                            text-gray-300
                        "
                    >
                        Keterangan
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="
                            w-full
                            rounded-lg
                            bg-[#252B3A]
                            border
                            border-[#3A4254]
                            px-4
                            py-3
                            text-white
                            focus:outline-none
                        "
                        placeholder="Keterangan tambahan..."
                    >{{ old('description') }}</textarea>

                </div>


                {{-- BUTTON --}}

                <div class="flex justify-end gap-3 pt-3">

                    <a
                        href="{{ route('manager-gudang.stok.keluar') }}"
                        class="
                            px-5
                            py-3
                            rounded-lg
                            bg-[#252B3A]
                            text-gray-300
                            hover:bg-[#2D3445]
                        "
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="
                            px-5
                            py-3
                            rounded-lg
                            bg-white
                            text-[#0B132B]
                            font-semibold
                            hover:bg-gray-200
                        "
                    >
                        Simpan Barang Keluar
                    </button>

                </div>

            </form>

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- DETAIL --}}
    {{-- ===================================================== --}}

    @if(isset($transaction))

        <div
            class="
                bg-[#111B36]
                border
                border-[#252B3A]
                rounded-xl
                p-6
            "
        >

            <h3 class="text-lg font-semibold text-white mb-5">
                Detail Barang Keluar
            </h3>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>

                    <p class="text-sm text-gray-400">
                        Produk
                    </p>

                    <p class="mt-1 font-medium">
                        {{ $transaction->product->name ?? '-' }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-400">
                        Jumlah
                    </p>

                    <p class="mt-1 font-medium">
                        {{ $transaction->quantity }}
                        {{ $transaction->product->unit ?? '' }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-400">
                        Nomor Referensi
                    </p>

                    <p class="mt-1 font-medium">
                        {{ $transaction->reference_number ?? '-' }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-400">
                        Status
                    </p>

                    <p class="mt-1 font-medium">
                        {{ ucfirst($transaction->status ?? '-') }}
                    </p>

                </div>

            </div>


            <div class="mt-6">

                <a
                    href="{{ route('manager-gudang.stok.keluar') }}"
                    class="
                        inline-block
                        px-5
                        py-3
                        rounded-lg
                        bg-[#252B3A]
                        text-gray-300
                        hover:bg-[#2D3445]
                    "
                >
                    Kembali
                </a>

            </div>

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- DAFTAR TRANSAKSI --}}
    {{-- ===================================================== --}}

    @if(isset($transactions))

        <div
            class="
                bg-[#111B36]
                border
                border-[#252B3A]
                rounded-xl
                overflow-hidden
            "
        >

            <div class="px-6 py-5 border-b border-[#252B3A]">

                <h3 class="text-lg font-semibold text-white">
                    Daftar Barang Keluar
                </h3>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-[#252B3A]">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                                No
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                                Produk
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                                Jumlah
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                                Referensi
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-[#252B3A]">

                        @forelse($transactions as $transaction)

                            <tr class="hover:bg-[#111B36]/70">

                                <td class="px-6 py-4 text-sm text-gray-400">

                                    {{ $transactions->firstItem() + $loop->index }}

                                </td>


                                <td class="px-6 py-4">

                                    <p class="font-medium text-white">
                                        {{ $transaction->product->name ?? '-' }}
                                    </p>

                                </td>


                                <td class="px-6 py-4 text-sm text-gray-300">

                                    {{ $transaction->quantity }}
                                    {{ $transaction->product->unit ?? '' }}

                                </td>


                                <td class="px-6 py-4 text-sm text-gray-400">

                                    {{ $transaction->reference_number ?? '-' }}

                                </td>


                                <td class="px-6 py-4">

                                    <span
                                        class="
                                            inline-flex
                                            px-3
                                            py-1
                                            rounded-full
                                            text-xs
                                            font-medium
                                            bg-green-500/10
                                            text-green-400
                                        "
                                    >
                                        {{ ucfirst($transaction->status ?? 'confirmed') }}
                                    </span>

                                </td>


                                <td class="px-6 py-4">

                                    <a
                                        href="{{ route(
                                            'manager-gudang.stok.keluar.show',
                                            $transaction->id
                                        ) }}"
                                        class="
                                            text-sm
                                            text-gray-300
                                            hover:text-white
                                        "
                                    >
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="
                                        px-6
                                        py-10
                                        text-center
                                        text-gray-400
                                    "
                                >
                                    Belum ada transaksi barang keluar.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if($transactions->hasPages())

                <div class="px-6 py-4 border-t border-[#252B3A]">

                    {{ $transactions->links() }}

                </div>

            @endif

        </div>

    @endif

</div>

@endsection