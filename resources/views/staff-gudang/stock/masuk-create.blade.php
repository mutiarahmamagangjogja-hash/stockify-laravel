@extends('layouts.staff-gudang')

@section('title', 'Catat Barang Masuk - Stockify')

@section('page-title', 'Catat Barang Masuk')

@section(
    'page-description',
    'Catat transaksi penerimaan barang yang datang ke gudang'
)

@section('content')

<div class="max-w-5xl">

    <div class="mb-6">

        <h2 class="text-2xl font-bold text-white">
            Catat Barang Masuk
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Catat barang yang baru diterima sebelum dilakukan pemeriksaan.
        </p>

    </div>


    @if($errors->any())

        <div class="p-4 mb-6 bg-red-900/20 border border-red-800 rounded-lg">

            <p class="font-medium text-red-300 mb-2">
                Terdapat kesalahan:
            </p>

            <ul class="list-disc ml-5 text-sm text-red-400">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('staff-gudang.stok.masuk.store') }}"
        method="POST"
        class="bg-[#252B3A] border border-[#3A4254] rounded-lg"
    >

        @csrf


        <div class="p-6 space-y-6">


            <!-- JENIS PRODUK -->

            <div>

                <label class="block mb-3 text-sm font-medium text-white">
                    Produk
                </label>

                <div class="grid grid-cols-2 gap-4">

                    <label
                        class="flex items-center gap-3 p-4 bg-[#2D3445] border border-[#3A4254] rounded-lg cursor-pointer"
                    >

                        <input
                            type="radio"
                            name="product_type"
                            value="existing"
                            checked
                            onchange="toggleProductType()"
                        >

                        <div>

                            <p class="text-sm font-medium text-white">
                                Produk Sudah Ada
                            </p>

                            <p class="text-xs text-gray-400">
                                Pilih produk yang sudah terdaftar.
                            </p>

                        </div>

                    </label>


                    <label
                        class="flex items-center gap-3 p-4 bg-[#2D3445] border border-[#3A4254] rounded-lg cursor-pointer"
                    >

                        <input
                            type="radio"
                            name="product_type"
                            value="new"
                            onchange="toggleProductType()"
                        >

                        <div>

                            <p class="text-sm font-medium text-white">
                                Tambah Produk Baru
                            </p>

                            <p class="text-xs text-gray-400">
                                Buat data produk jika belum terdaftar.
                            </p>

                        </div>

                    </label>

                </div>

            </div>


            <!-- PRODUK LAMA -->

            <div id="existingProduct">

                <label
                    class="block mb-2 text-sm font-medium text-white"
                >
                    Pilih Produk
                </label>

                <select
                    name="product_id"
                    class="w-full p-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
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
                            - {{ $product->sku }}

                        </option>

                    @endforeach

                </select>

            </div>


            <!-- PRODUK BARU -->

            <div
                id="newProduct"
                class="hidden space-y-4"
            >

                <div>

                    <label class="block mb-2 text-sm text-white">
                        Nama Produk
                    </label>

                    <input
                        type="text"
                        name="product_name"
                        value="{{ old('product_name') }}"
                        class="w-full p-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                        placeholder="Nama produk"
                    >

                </div>


                <div class="grid grid-cols-2 gap-4">

                    <div>

                        <label class="block mb-2 text-sm text-white">
                            SKU
                        </label>

                        <input
                            type="text"
                            name="sku"
                            value="{{ old('sku') }}"
                            class="w-full p-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                            placeholder="SKU produk"
                        >

                    </div>


                    <div>

                        <label class="block mb-2 text-sm text-white">
                            Satuan
                        </label>

                        <input
                            type="text"
                            name="unit"
                            value="{{ old('unit', 'pcs') }}"
                            class="w-full p-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                            placeholder="pcs"
                        >

                    </div>

                </div>


                <div class="grid grid-cols-2 gap-4">

                    <div>

                        <label class="block mb-2 text-sm text-white">
                            Harga Beli
                        </label>

                        <input
                            type="number"
                            name="purchase_price"
                            value="{{ old('purchase_price') }}"
                            min="0"
                            class="w-full p-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                        >

                    </div>


                    <div>

                        <label class="block mb-2 text-sm text-white">
                            Harga Jual
                        </label>

                        <input
                            type="number"
                            name="price"
                            value="{{ old('price') }}"
                            min="0"
                            class="w-full p-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                        >

                    </div>

                </div>

            </div>


            <!-- SUPPLIER -->

            <div>

                <label class="block mb-2 text-sm font-medium text-white">
                    Supplier
                </label>

                <select
                    name="supplier_id"
                    class="w-full p-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                >

                    <option value="">
                        -- Pilih Supplier --
                    </option>

                    @foreach($suppliers as $supplier)

                        <option
                            value="{{ $supplier->id }}"
                            {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}
                        >

                            {{ $supplier->name }}

                        </option>

                    @endforeach

                </select>

            </div>


            <!-- JUMLAH -->

            <div>

                <label class="block mb-2 text-sm font-medium text-white">
                    Jumlah
                </label>

                <input
                    type="number"
                    name="quantity"
                    value="{{ old('quantity') }}"
                    min="1"
                    required
                    class="w-full p-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                    placeholder="Jumlah barang"
                >

            </div>


            <!-- TANGGAL -->

            <div>

                <label class="block mb-2 text-sm font-medium text-white">
                    Tanggal Penerimaan
                </label>

                <input
                    type="date"
                    name="received_at"
                    value="{{ old('received_at', date('Y-m-d')) }}"
                    required
                    class="w-full p-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                >

            </div>


            <!-- REFERENSI -->

            <div>

                <label class="block mb-2 text-sm font-medium text-white">
                    Nomor Referensi
                </label>

                <input
                    type="text"
                    name="reference_number"
                    value="{{ old('reference_number') }}"
                    class="w-full p-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                    placeholder="Contoh: PO-001"
                >

            </div>


            <!-- KETERANGAN -->

            <div>

                <label class="block mb-2 text-sm font-medium text-white">
                    Keterangan
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full p-3 bg-[#2D3445] border border-[#3A4254] rounded-lg text-white"
                    placeholder="Keterangan penerimaan barang"
                >{{ old('description') }}</textarea>

            </div>

        </div>


        <!-- FOOTER -->

        <div class="flex justify-end gap-3 p-6 border-t border-[#3A4254]">

            <a
                href="{{ route('staff-gudang.stok.masuk') }}"
                class="px-5 py-2.5 text-sm text-gray-300 bg-[#2D3445] border border-[#3A4254] rounded-lg"
            >
                Batal
            </a>

            <button
                type="submit"
                class="px-5 py-2.5 text-sm font-medium text-white bg-[#111B36] border border-[#3A4254] rounded-lg"
            >
                Simpan Pencatatan
            </button>

        </div>

    </form>

</div>


@endsection


@section('scripts')

<script>

function toggleProductType()
{
    const type =
        document.querySelector(
            'input[name="product_type"]:checked'
        ).value;


    const existing =
        document.getElementById(
            'existingProduct'
        );


    const newProduct =
        document.getElementById(
            'newProduct'
        );


    if (type === 'existing') {

        existing.classList.remove('hidden');

        newProduct.classList.add('hidden');

    } else {

        existing.classList.add('hidden');

        newProduct.classList.remove('hidden');

    }
}

</script>

@endsection