@extends('layouts.manager-gudang')


@section('title', 'Tambah Produk - Manager Gudang')


@section('page-title', 'Tambah Produk')


@section(
    'page-description',
    'Menambahkan produk baru ke dalam sistem'
)


@section('content')


<!-- ===================================================== -->
<!-- HEADER -->
<!-- ===================================================== -->

<div class="mb-6">

    <a
        href="{{ route('manager-gudang.produk.index') }}"
        class="
            inline-flex
            items-center
            mb-4
            text-sm
            text-gray-400
            hover:text-white
        "
    >

        <svg
            class="w-4 h-4 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 19l-7-7 7-7"
            />

        </svg>

        Kembali ke Produk

    </a>


    <h2
        class="
            text-2xl
            font-bold
            text-white
        "
    >
        Tambah Produk
    </h2>

    <p
        class="
            mt-1
            text-sm
            text-gray-400
        "
    >
        Lengkapi informasi produk baru
    </p>

</div>



<!-- ===================================================== -->
<!-- ERROR -->
<!-- ===================================================== -->

@if($errors->any())

    <div
        class="
            mb-6
            p-4
            bg-red-400/10
            border
            border-red-400/20
            rounded-lg
        "
    >

        <p
            class="
                mb-2
                text-sm
                font-semibold
                text-red-300
            "
        >
            Terdapat kesalahan:
        </p>

        <ul
            class="
                space-y-1
                text-sm
                text-red-200
            "
        >

            @foreach($errors->all() as $error)

                <li>
                    • {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif



<!-- ===================================================== -->
<!-- FORM -->
<!-- ===================================================== -->

<form
    method="POST"
    action="{{ route('manager-gudang.produk.store') }}"
    enctype="multipart/form-data"
>

    @csrf


    <div
        class="
            grid
            grid-cols-1
            lg:grid-cols-3
            gap-5
        "
    >


        <!-- ================================================= -->
        <!-- DATA PRODUK -->
        <!-- ================================================= -->

        <div
            class="
                lg:col-span-2
                bg-[#252B3A]
                border
                border-[#3A4254]
                rounded-lg
                shadow-sm
            "
        >

            <div
                class="
                    p-5
                    border-b
                    border-[#3A4254]
                "
            >

                <h3
                    class="
                        text-lg
                        font-semibold
                        text-white
                    "
                >
                    Informasi Produk
                </h3>

            </div>


            <div class="p-5">


                <!-- NAMA -->

                <div class="mb-5">

                    <label
                        class="
                            block
                            mb-2
                            text-sm
                            font-medium
                            text-gray-300
                        "
                    >
                        Nama Produk
                        <span class="text-red-400">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama produk"
                        class="
                            w-full
                            px-4
                            py-2.5
                            text-sm
                            text-white
                            bg-[#2D3445]
                            border
                            border-[#3A4254]
                            rounded-lg
                            placeholder-gray-500
                            focus:outline-none
                        "
                        required
                    >

                </div>



                <!-- SKU + KATEGORI -->

                <div
                    class="
                        grid
                        grid-cols-1
                        md:grid-cols-2
                        gap-5
                        mb-5
                    "
                >


                    <!-- SKU -->

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
                            SKU
                            <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="text"
                            name="sku"
                            value="{{ old('sku') }}"
                            placeholder="Contoh: PRD-001"
                            class="
                                w-full
                                px-4
                                py-2.5
                                text-sm
                                text-white
                                bg-[#2D3445]
                                border
                                border-[#3A4254]
                                rounded-lg
                                placeholder-gray-500
                                focus:outline-none
                            "
                            required
                        >

                    </div>



                    <!-- KATEGORI -->

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
                            Kategori
                        </label>

                        <select
                            name="category_id"
                            class="
                                w-full
                                px-4
                                py-2.5
                                text-sm
                                text-white
                                bg-[#2D3445]
                                border
                                border-[#3A4254]
                                rounded-lg
                                focus:outline-none
                            "
                        >

                            <option
                                value=""
                                class="bg-[#252B3A]"
                            >
                                Pilih Kategori
                            </option>


                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    class="bg-[#252B3A]"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>



                <!-- DESKRIPSI -->

                <div class="mb-5">

                    <label
                        class="
                            block
                            mb-2
                            text-sm
                            font-medium
                            text-gray-300
                        "
                    >
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        rows="5"
                        placeholder="Masukkan deskripsi produk"
                        class="
                            w-full
                            px-4
                            py-3
                            text-sm
                            text-white
                            bg-[#2D3445]
                            border
                            border-[#3A4254]
                            rounded-lg
                            placeholder-gray-500
                            focus:outline-none
                            resize-none
                        "
                    >{{ old('description') }}</textarea>

                </div>



                <!-- HARGA -->

                <div
                    class="
                        grid
                        grid-cols-1
                        md:grid-cols-2
                        gap-5
                        mb-5
                    "
                >


                    <!-- HARGA BELI -->

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
                            Harga Beli
                            <span class="text-red-400">*</span>
                        </label>

                        <div class="relative">

                            <span
                                class="
                                    absolute
                                    left-4
                                    top-1/2
                                    -translate-y-1/2
                                    text-sm
                                    text-gray-500
                                "
                            >
                                Rp
                            </span>

                            <input
                                type="number"
                                name="purchase_price"
                                value="{{ old('purchase_price', 0) }}"
                                min="0"
                                step="0.01"
                                class="
                                    w-full
                                    pl-11
                                    pr-4
                                    py-2.5
                                    text-sm
                                    text-white
                                    bg-[#2D3445]
                                    border
                                    border-[#3A4254]
                                    rounded-lg
                                    focus:outline-none
                                "
                                required
                            >

                        </div>

                    </div>



                    <!-- HARGA JUAL -->

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
                            Harga Jual
                            <span class="text-red-400">*</span>
                        </label>

                        <div class="relative">

                            <span
                                class="
                                    absolute
                                    left-4
                                    top-1/2
                                    -translate-y-1/2
                                    text-sm
                                    text-gray-500
                                "
                            >
                                Rp
                            </span>

                            <input
                                type="number"
                                name="price"
                                value="{{ old('price', 0) }}"
                                min="0"
                                step="0.01"
                                class="
                                    w-full
                                    pl-11
                                    pr-4
                                    py-2.5
                                    text-sm
                                    text-white
                                    bg-[#2D3445]
                                    border
                                    border-[#3A4254]
                                    rounded-lg
                                    focus:outline-none
                                "
                                required
                            >

                        </div>

                    </div>

                </div>



                <!-- STOK -->

                <div
                    class="
                        grid
                        grid-cols-1
                        md:grid-cols-3
                        gap-5
                    "
                >


                    <!-- STOK AWAL -->

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
                            Stok Awal
                            <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="number"
                            name="stock"
                            value="{{ old('stock', 0) }}"
                            min="0"
                            class="
                                w-full
                                px-4
                                py-2.5
                                text-sm
                                text-white
                                bg-[#2D3445]
                                border
                                border-[#3A4254]
                                rounded-lg
                                focus:outline-none
                            "
                            required
                        >

                    </div>



                    <!-- MINIMUM STOK -->

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
                            Minimum Stok
                            <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="number"
                            name="minimum_stock"
                            value="{{ old('minimum_stock', 0) }}"
                            min="0"
                            class="
                                w-full
                                px-4
                                py-2.5
                                text-sm
                                text-white
                                bg-[#2D3445]
                                border
                                border-[#3A4254]
                                rounded-lg
                                focus:outline-none
                            "
                            required
                        >

                    </div>



                    <!-- SATUAN -->

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
                            Satuan
                            <span class="text-red-400">*</span>
                        </label>

                        <input
                            type="text"
                            name="unit"
                            value="{{ old('unit', 'pcs') }}"
                            placeholder="pcs"
                            class="
                                w-full
                                px-4
                                py-2.5
                                text-sm
                                text-white
                                bg-[#2D3445]
                                border
                                border-[#3A4254]
                                rounded-lg
                                focus:outline-none
                            "
                            required
                        >

                    </div>

                </div>

            </div>

        </div>



        <!-- ================================================= -->
        <!-- GAMBAR + STATUS -->
        <!-- ================================================= -->

        <div class="space-y-5">


            <!-- GAMBAR -->

            <div
                class="
                    bg-[#252B3A]
                    border
                    border-[#3A4254]
                    rounded-lg
                    shadow-sm
                "
            >

                <div
                    class="
                        p-5
                        border-b
                        border-[#3A4254]
                    "
                >

                    <h3
                        class="
                            text-lg
                            font-semibold
                            text-white
                        "
                    >
                        Gambar Produk
                    </h3>

                </div>


                <div class="p-5">

                    <div
                        id="imagePreview"
                        class="
                            flex
                            items-center
                            justify-center
                            w-full
                            h-48
                            mb-4
                            bg-[#2D3445]
                            border
                            border-dashed
                            border-[#3A4254]
                            rounded-lg
                            overflow-hidden
                        "
                    >

                        <div
                            id="previewPlaceholder"
                            class="text-center"
                        >

                            <svg
                                class="
                                    w-10
                                    h-10
                                    mx-auto
                                    mb-2
                                    text-gray-500
                                "
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="
                                        M4 16l4.5-4.5
                                        a2 2 0
                                        012.8 0L16 16
                                        m-2-2
                                        2-2
                                        a2 2
                                        0 012.8 0
                                        L20 12
                                        M14 8h.01
                                        M5 20h14
                                        a1 1
                                        0 001-1V5
                                        a1 1
                                        0 00-1-1H5
                                        a1 1
                                        0 00-1 1v14
                                        a1 1
                                        0 001 1z
                                    "
                                />

                            </svg>

                            <p
                                class="
                                    text-xs
                                    text-gray-500
                                "
                            >
                                Preview gambar
                            </p>

                        </div>

                        <img
                            id="imagePreviewImg"
                            class="
                                hidden
                                w-full
                                h-full
                                object-contain
                            "
                            alt="Preview"
                        >

                    </div>


                    <input
                        type="file"
                        name="image"
                        id="image"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="
                            w-full
                            text-sm
                            text-gray-400
                        "
                    >

                    <p
                        class="
                            mt-2
                            text-xs
                            text-gray-500
                        "
                    >
                        JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                    </p>

                </div>

            </div>



            <!-- STATUS -->

            <div
                class="
                    bg-[#252B3A]
                    border
                    border-[#3A4254]
                    rounded-lg
                    shadow-sm
                "
            >

                <div
                    class="
                        p-5
                        border-b
                        border-[#3A4254]
                    "
                >

                    <h3
                        class="
                            text-lg
                            font-semibold
                            text-white
                        "
                    >
                        Status Produk
                    </h3>

                </div>


                <div class="p-5">

                    <select
                        name="status"
                        class="
                            w-full
                            px-4
                            py-2.5
                            text-sm
                            text-white
                            bg-[#2D3445]
                            border
                            border-[#3A4254]
                            rounded-lg
                            focus:outline-none
                        "
                    >

                        <option
                            value="active"
                            class="bg-[#252B3A]"
                            {{ old('status', 'active') === 'active' ? 'selected' : '' }}
                        >
                            Aktif
                        </option>

                        <option
                            value="inactive"
                            class="bg-[#252B3A]"
                            {{ old('status') === 'inactive' ? 'selected' : '' }}
                        >
                            Tidak Aktif
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>



    <!-- ===================================================== -->
    <!-- BUTTON -->
    <!-- ===================================================== -->

    <div
        class="
            flex
            justify-end
            gap-3
            mt-6
        "
    >

        <a
            href="{{ route('manager-gudang.produk.index') }}"
            class="
                px-5
                py-2.5
                text-sm
                font-medium
                text-gray-300
                bg-[#2D3445]
                border
                border-[#3A4254]
                rounded-lg
                hover:bg-[#343C50]
            "
        >
            Batal
        </a>


        <button
            type="submit"
            class="
                px-5
                py-2.5
                text-sm
                font-medium
                text-white
                bg-[#3A4254]
                rounded-lg
                hover:bg-[#465066]
            "
        >
            Simpan Produk
        </button>

    </div>

</form>



<!-- ===================================================== -->
<!-- IMAGE PREVIEW -->
<!-- ===================================================== -->

<script>

document
    .getElementById('image')
    .addEventListener(
        'change',
        function(event)
        {

            const file =
                event.target.files[0];

            const preview =
                document.getElementById(
                    'imagePreviewImg'
                );

            const placeholder =
                document.getElementById(
                    'previewPlaceholder'
                );


            if (!file) {

                preview.classList.add(
                    'hidden'
                );

                placeholder.classList.remove(
                    'hidden'
                );

                return;

            }


            const reader =
                new FileReader();


            reader.onload =
                function(e)
                {

                    preview.src =
                        e.target.result;

                    preview.classList.remove(
                        'hidden'
                    );

                    placeholder.classList.add(
                        'hidden'
                    );

                };


            reader.readAsDataURL(file);

        }
    );

</script>


@endsection
