@extends('layouts.staff-gudang')

@section('title', 'Tambah Stock Opname')

@section('page-title', 'Tambah Stock Opname')

@section('page-description', 'Input hasil pemeriksaan stok fisik')

@section('content')

<div class="max-w-4xl">

    {{-- HEADER --}}
    <div class="mb-6">

        <a
            href="{{ route('staff-gudang.stok.opname') }}"
            class="mb-4 inline-flex items-center gap-2 text-sm text-slate-400 transition hover:text-white"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                />
            </svg>

            Kembali ke Stock Opname

        </a>


        <h2 class="text-2xl font-bold text-white">
            Tambah Stock Opname
        </h2>

        <p class="mt-1 text-sm text-slate-400">
            Masukkan jumlah stok fisik berdasarkan hasil pengecekan gudang.
        </p>

    </div>


    {{-- ERROR --}}
    @if($errors->any())

        <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-5">

            <p class="font-semibold text-red-400">
                Terdapat kesalahan:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-300">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORM --}}
    <form
        action="{{ route('staff-gudang.stok.opname.store') }}"
        method="POST"
        class="space-y-6"
    >

        @csrf


        {{-- CARD PRODUK --}}
        <div class="rounded-2xl border border-slate-700 bg-slate-900 p-6 shadow-xl">

            <h3 class="text-lg font-semibold text-white">
                Informasi Barang
            </h3>

            <p class="mt-1 text-sm text-slate-400">
                Pilih barang yang akan dilakukan pemeriksaan.
            </p>


            <div class="mt-6">

                <label
                    for="product_id"
                    class="mb-2 block text-sm font-medium text-slate-300"
                >
                    Produk
                    <span class="text-red-400">*</span>
                </label>


                <select
                    id="product_id"
                    name="product_id"
                    required
                    class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                >

                    <option value="">
                        -- Pilih Produk --
                    </option>


                    @foreach($products as $product)

                        <option
                            value="{{ $product->id }}"
                            data-stock="{{ $product->stock }}"
                            data-unit="{{ $product->unit }}"
                            {{ old('product_id') == $product->id ? 'selected' : '' }}
                        >
                            {{ $product->name }}
                            — {{ $product->sku }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


      {{-- PETUGAS PEMERIKSA --}}
<div class="mt-6">

    <label
        for="inspector_name"
        class="mb-2 block text-sm font-medium text-slate-300"
    >
        Petugas Pemeriksa
        <span class="text-red-400">*</span>
    </label>

    <input
        type="text"
        id="inspector_name"
        name="inspector_name"
        value="{{ old('inspector_name') }}"
        required
        maxlength="100"
        placeholder="Masukkan nama petugas pemeriksa"
        class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
    >

    <p class="mt-2 text-xs text-slate-500">
        Masukkan nama petugas yang melakukan pemeriksaan stok fisik.
    </p>

</div>

        {{-- CARD STOK --}}
        <div class="rounded-2xl border border-slate-700 bg-slate-900 p-6 shadow-xl">

            <h3 class="text-lg font-semibold text-white">
                Hasil Pemeriksaan
            </h3>

            <p class="mt-1 text-sm text-slate-400">
                Bandingkan stok sistem dengan stok fisik yang ditemukan.
            </p>


            <div class="mt-6 grid gap-5 md:grid-cols-2">

                {{-- STOK SISTEM --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-slate-300">
                        Stok Sistem
                    </label>

                    <div class="flex items-center rounded-xl border border-slate-700 bg-slate-800">

                        <input
                            type="text"
                            id="system_stock"
                            value="0"
                            readonly
                            class="w-full border-0 bg-transparent px-4 py-3 text-sm font-semibold text-slate-300 outline-none"
                        >

                        <span
                            id="system_unit"
                            class="px-4 text-sm text-slate-500"
                        >
                            pcs
                        </span>

                    </div>

                </div>


                {{-- STOK FISIK --}}
                <div>

                    <label
                        for="physical_stock"
                        class="mb-2 block text-sm font-medium text-slate-300"
                    >
                        Stok Fisik
                        <span class="text-red-400">*</span>
                    </label>


                    <div class="flex items-center rounded-xl border border-slate-700 bg-slate-800">

                        <input
                            type="number"
                            id="physical_stock"
                            name="physical_stock"
                            min="0"
                            value="{{ old('physical_stock') }}"
                            required
                            placeholder="Masukkan stok fisik"
                            class="w-full border-0 bg-transparent px-4 py-3 text-sm text-white outline-none"
                        >

                        <span
                            id="physical_unit"
                            class="px-4 text-sm text-slate-500"
                        >
                            pcs
                        </span>

                    </div>

                </div>

            </div>


            {{-- SELISIH --}}
            <div class="mt-6 rounded-xl border border-slate-700 bg-slate-800/50 p-5">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-400">
                            Selisih Stok
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Stok fisik - stok sistem
                        </p>

                    </div>


                    <div
                        id="difference"
                        class="text-2xl font-bold text-slate-300"
                    >
                        0
                    </div>

                </div>

            </div>

        </div>
        


        {{-- CARD KETERANGAN --}}
        <div class="rounded-2xl border border-slate-700 bg-slate-900 p-6 shadow-xl">

            <label
                for="description"
                class="mb-2 block text-sm font-medium text-slate-300"
            >
                Keterangan
            </label>


            <textarea
                id="description"
                name="description"
                rows="4"
                placeholder="Contoh: Ditemukan 2 barang rusak atau terdapat selisih saat pemeriksaan."
                class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
            >{{ old('description') }}</textarea>

        </div>


        {{-- BUTTON --}}
        <div class="flex items-center justify-end gap-3">

            <a
                href="{{ route('staff-gudang.stok.opname') }}"
                class="rounded-xl border border-slate-700 px-5 py-3 text-sm font-semibold text-slate-300 transition hover:bg-slate-800"
            >
                Batal
            </a>


            <button
                type="submit"
                class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-500"
            >
                Simpan Stock Opname
            </button>

        </div>

    </form>

</div>


{{-- JAVASCRIPT --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const productSelect =
        document.getElementById('product_id');

    const systemStock =
        document.getElementById('system_stock');

    const physicalStock =
        document.getElementById('physical_stock');

    const difference =
        document.getElementById('difference');

    const systemUnit =
        document.getElementById('system_unit');

    const physicalUnit =
        document.getElementById('physical_unit');


    function updateStockInformation() {

        const selected =
            productSelect.options[
                productSelect.selectedIndex
            ];


        if (!selected || !selected.value) {

            systemStock.value = 0;

            systemUnit.textContent = 'pcs';

            physicalUnit.textContent = 'pcs';

            difference.textContent = 0;

            difference.className =
                'text-2xl font-bold text-slate-300';

            return;
        }


        const stock =
            parseInt(
                selected.dataset.stock || 0
            );


        const unit =
            selected.dataset.unit || 'pcs';


        systemStock.value =
            stock;


        systemUnit.textContent =
            unit;


        physicalUnit.textContent =
            unit;


        calculateDifference();

    }


    function calculateDifference() {

        const system =
            parseInt(
                systemStock.value || 0
            );


        const physical =
            parseInt(
                physicalStock.value || 0
            );


        const result =
            physical - system;


        difference.textContent =
            result > 0
                ? '+' + result
                : result;


        if (result > 0) {

            difference.className =
                'text-2xl font-bold text-green-400';

        }
        else if (result < 0) {

            difference.className =
                'text-2xl font-bold text-red-400';

        }
        else {

            difference.className =
                'text-2xl font-bold text-blue-400';

        }

    }


    productSelect.addEventListener(
        'change',
        updateStockInformation
    );


    physicalStock.addEventListener(
        'input',
        calculateDifference
    );


    updateStockInformation();

});

</script>

@endsection