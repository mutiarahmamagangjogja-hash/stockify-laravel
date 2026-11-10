@extends('layouts.staff-gudang')

@section('title', 'Catat Barang Masuk - Stockify')

@section('page-title', 'Catat Barang Masuk')

@section(
'page-description',
'Catat transaksi penerimaan barang yang datang ke gudang'
)

@section('content')

<div class="max-w-5xl">

```
<!-- HEADER -->

<div class="mb-6">

    <a
        href="{{ route('staff-gudang.stok.masuk') }}"
        class="inline-flex items-center text-sm text-gray-400 hover:text-white"
    >
        ← Kembali ke Konfirmasi Penerimaan
    </a>

    <h2 class="mt-4 text-2xl font-bold text-white">
        Catat Barang Masuk
    </h2>

    <p class="mt-1 text-sm text-gray-400">
        Catat barang yang baru diterima sebelum dilakukan pemeriksaan fisik.
    </p>

</div>


{{-- ERROR --}}

@if($errors->any())

    <div
        class="p-4 mb-6 text-sm text-red-300
               bg-red-900/20 border border-red-800 rounded-lg"
    >

        <p class="font-semibold mb-2">
            Terdapat kesalahan:
        </p>

        <ul class="list-disc ml-5">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif


<form
    action="{{ route('staff-gudang.stok.masuk.simpan') }}"
    method="POST"
>

    @csrf


    <!-- ===================================================== -->
    <!-- PRODUK -->
    <!-- ===================================================== -->

    <div
        class="p-6 mb-6 bg-[#252B3A]
               border border-[#3A4254] rounded-lg"
    >

        <h3 class="text-lg font-semibold text-white">
            Produk
        </h3>

        <p class="mt-1 mb-5 text-sm text-gray-400">
            Pilih apakah barang yang diterima sudah terdaftar
            atau merupakan produk baru.
        </p>


        <div class="grid grid-cols-2 gap-4">

            <!-- PRODUK LAMA -->

            <label class="cursor-pointer">

                <input
                    type="radio"
                    name="product_option"
                    value="existing"
                    class="peer hidden"
                    {{ old('product_option', 'existing') === 'existing' ? 'checked' : '' }}
                    onchange="toggleProductType()"
                >

                <div
                    class="p-5 bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           peer-checked:border-white
                           peer-checked:bg-[#111B36]"
                >

                    <p class="font-semibold text-white">
                        Produk Sudah Terdaftar
                    </p>

                    <p class="mt-1 text-sm text-gray-400">
                        Pilih produk yang sudah ada di sistem.
                    </p>

                </div>

            </label>


            <!-- PRODUK BARU -->

            <label class="cursor-pointer">

                <input
                    type="radio"
                    name="product_option"
                    value="new"
                    class="peer hidden"
                    {{ old('product_option') === 'new' ? 'checked' : '' }}
                    onchange="toggleProductType()"
                >

                <div
                    class="p-5 bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           peer-checked:border-white
                           peer-checked:bg-[#111B36]"
                >

                    <p class="font-semibold text-white">
                        Tambah Produk Baru
                    </p>

                    <p class="mt-1 text-sm text-gray-400">
                        Buat data produk jika belum terdaftar.
                    </p>

                </div>

            </label>

        </div>


        <!-- ================================================= -->
        <!-- PRODUK SUDAH ADA -->
        <!-- ================================================= -->

        <div
            id="existingProduct"
            class="mt-6"
        >

            <label
                for="product_id"
                class="block mb-2 text-sm font-medium text-white"
            >
                Produk
            </label>

            <select
                id="product_id"
                name="product_id"
                class="w-full p-3 text-sm text-white
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg"
            >

                <option value="">
                    Pilih Produk
                </option>

                @foreach($products as $product)

                    <option
                        value="{{ $product->id }}"
                        {{ old('product_id') == $product->id ? 'selected' : '' }}
                    >

                        {{ $product->name }}
                        @if($product->sku)
                            - {{ $product->sku }}
                        @endif

                    </option>

                @endforeach

            </select>

        </div>


        <!-- ================================================= -->
        <!-- PRODUK BARU -->
        <!-- ================================================= -->

        <div
            id="newProduct"
            class="hidden mt-6 space-y-5"
        >

            <div class="grid grid-cols-2 gap-5">

                <!-- NAMA -->

                <div>

                    <label
                        for="product_name"
                        class="block mb-2 text-sm font-medium text-white"
                    >
                        Nama Produk
                    </label>

                    <input
                        type="text"
                        id="product_name"
                        name="product_name"
                        value="{{ old('product_name') }}"
                        class="w-full p-3 text-sm text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg"
                        placeholder="Contoh: Laptop Lenovo"
                    >

                </div>


                <!-- SKU -->

                <div>

                    <label
                        for="sku"
                        class="block mb-2 text-sm font-medium text-white"
                    >
                        SKU
                    </label>

                    <input
                        type="text"
                        id="sku"
                        name="sku"
                        value="{{ old('sku') }}"
                        class="w-full p-3 text-sm text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg"
                        placeholder="Contoh: LNV-001"
                    >

                </div>

            </div>


            <div class="grid grid-cols-2 gap-5">

                <!-- SATUAN -->

                <div>

                    <label
                        for="unit"
                        class="block mb-2 text-sm font-medium text-white"
                    >
                        Satuan
                    </label>

                    <input
                        type="text"
                        id="unit"
                        name="unit"
                        value="{{ old('unit', 'pcs') }}"
                        class="w-full p-3 text-sm text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg"
                    >

                </div>


                <!-- KATEGORI -->

                <div>

                    <label
                        for="category_id"
                        class="block mb-2 text-sm font-medium text-white"
                    >
                        Kategori
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        class="w-full p-3 text-sm text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg"
                    >

                        <option value="">
                            Pilih Kategori
                        </option>

                        @if(isset($categories))

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        @endif

                    </select>

                </div>

            </div>


            <!-- HARGA BELI -->

            <div>

                <label
                    for="purchase_price"
                    class="block mb-2 text-sm font-medium text-white"
                >
                    Harga Beli
                </label>

                <input
                    type="number"
                    id="purchase_price"
                    name="purchase_price"
                    value="{{ old('purchase_price', 0) }}"
                    min="0"
                    class="w-full p-3 text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg"
                    placeholder="0"
                >

            </div>

        </div>

    </div>


    <!-- ===================================================== -->
    <!-- INFORMASI PENERIMAAN -->
    <!-- ===================================================== -->

    <div
        class="p-6 mb-6 bg-[#252B3A]
               border border-[#3A4254] rounded-lg"
    >

        <h3 class="text-lg font-semibold text-white">
            Informasi Penerimaan
        </h3>

        <p class="mt-1 mb-5 text-sm text-gray-400">
            Isi informasi transaksi barang yang diterima.
        </p>


        <div class="grid grid-cols-2 gap-5">


            <!-- SUPPLIER -->

            <div>

                <label
                    for="supplier_id"
                    class="block mb-2 text-sm font-medium text-white"
                >
                    Supplier
                </label>

                <select
                    id="supplier_id"
                    name="supplier_id"
                    class="w-full p-3 text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg"
                >

                    <option value="">
                        Pilih Supplier
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

                <label
                    for="quantity"
                    class="block mb-2 text-sm font-medium text-white"
                >
                    Jumlah Barang
                </label>

                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    min="1"
                    value="{{ old('quantity') }}"
                    required
                    class="w-full p-3 text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg"
                    placeholder="Masukkan jumlah"
                >

            </div>


            <!-- TANGGAL PENERIMAAN -->

            <div>

                <label
                    for="received_at"
                    class="block mb-2 text-sm font-medium text-white"
                >
                    Tanggal Penerimaan
                </label>

                <input
                    type="datetime-local"
                    id="received_at"
                    name="received_at"
                    value="{{ old('received_at', now()->format('Y-m-d\TH:i')) }}"
                    required
                    class="w-full p-3 text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg"
                >

            </div>


            <!-- REFERENSI -->

            <div>

                <label
                    for="reference_number"
                    class="block mb-2 text-sm font-medium text-white"
                >
                    Nomor Referensi
                </label>

                <input
                    type="text"
                    id="reference_number"
                    name="reference_number"
                    value="{{ old('reference_number') }}"
                    class="w-full p-3 text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg"
                    placeholder="Contoh: PO-001"
                >

            </div>

        </div>


        <!-- KETERANGAN -->

        <div class="mt-5">

            <label
                for="description"
                class="block mb-2 text-sm font-medium text-white"
            >
                Keterangan
            </label>

            <textarea
                id="description"
                name="description"
                rows="4"
                class="w-full p-3 text-sm text-white
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg"
                placeholder="Contoh: Penerimaan barang dari supplier..."
            >{{ old('description') }}</textarea>

        </div>

    </div>


    <!-- ===================================================== -->
    <!-- BUTTON -->
    <!-- ===================================================== -->

    <div class="flex items-center justify-end gap-3">

        <a
            href="{{ route('staff-gudang.stok.masuk') }}"
            class="px-5 py-2.5 text-sm text-gray-300
                   bg-[#2D3445]
                   border border-[#3A4254]
                   rounded-lg
                   hover:bg-[#111B36]"
        >
            Batal
        </a>


        <button
            type="submit"
            class="px-5 py-2.5 text-sm font-medium text-white
                   bg-[#111B36]
                   border border-[#3A4254]
                   rounded-lg
                   hover:bg-[#0B132B]"
        >
            Simpan Catatan Barang Masuk
        </button>

    </div>

</form>
```

</div>

@endsection

@section('scripts')

<script>

function toggleProductType()
{
    const selected =
        document.querySelector(
            'input[name="product_option"]:checked'
        );

    if (!selected) {
        return;
    }


    const type = selected.value;


    const existing =
        document.getElementById('existingProduct');

    const newProduct =
        document.getElementById('newProduct');


    const productSelect =
        document.getElementById('product_id');


    const productName =
        document.getElementById('product_name');

    const sku =
        document.getElementById('sku');


    if (type === 'existing') {

        existing.classList.remove('hidden');

        newProduct.classList.add('hidden');

        productSelect.required = true;

        productName.required = false;

        sku.required = false;

    } else {

        existing.classList.add('hidden');

        newProduct.classList.remove('hidden');

        productSelect.required = false;

        productName.required = true;

        sku.required = true;

    }
}


document.addEventListener(
    'DOMContentLoaded',
    function () {

        toggleProductType();

    }
);

</script>

@endsection
