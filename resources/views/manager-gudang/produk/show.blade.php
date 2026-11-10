@extends('layouts.manager-gudang')


@section('title', 'Detail Produk - Manager Gudang')


@section('page-title', 'Detail Produk')


@section(
    'page-description',
    'Informasi lengkap produk dan stok barang'
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
            transition
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


    <div
        class="
            flex
            flex-col
            md:flex-row
            md:items-center
            md:justify-between
            gap-4
        "
    >

        <div>

            <h2
                class="
                    text-2xl
                    font-bold
                    text-white
                "
            >
                Detail Produk
            </h2>

            <p
                class="
                    mt-1
                    text-sm
                    text-gray-400
                "
            >
                Informasi lengkap produk
            </p>

        </div>


        <!-- STATUS -->

        @if($product->status === 'active')

            <span
                class="
                    inline-flex
                    items-center
                    w-fit
                    px-3
                    py-1.5
                    text-sm
                    font-medium
                    text-green-300
                    bg-green-400/10
                    border
                    border-green-400/20
                    rounded-lg
                "
            >

                <span
                    class="
                        w-2
                        h-2
                        mr-2
                        bg-green-400
                        rounded-full
                    "
                ></span>

                Aktif

            </span>

        @else

            <span
                class="
                    inline-flex
                    items-center
                    w-fit
                    px-3
                    py-1.5
                    text-sm
                    font-medium
                    text-gray-300
                    bg-gray-400/10
                    border
                    border-gray-400/20
                    rounded-lg
                "
            >

                <span
                    class="
                        w-2
                        h-2
                        mr-2
                        bg-gray-400
                        rounded-full
                    "
                ></span>

                Tidak Aktif

            </span>

        @endif

    </div>

</div>



<!-- ===================================================== -->
<!-- PRODUCT DETAIL -->
<!-- ===================================================== -->

<div
    class="
        grid
        grid-cols-1
        lg:grid-cols-3
        gap-5
    "
>


    <!-- ================================================= -->
    <!-- GAMBAR PRODUK -->
    <!-- ================================================= -->

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
                class="
                    flex
                    items-center
                    justify-center
                    w-full
                    h-72
                    bg-[#2D3445]
                    border
                    border-[#3A4254]
                    rounded-lg
                    overflow-hidden
                "
            >

                @if($product->image)

                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="
                            w-full
                            h-full
                            object-contain
                        "
                    >

                @else

                    <div class="text-center">

                        <svg
                            class="
                                w-16
                                h-16
                                mx-auto
                                mb-3
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
                                    0
                                    001-1V5
                                    a1 1
                                    0
                                    00-1-1H5
                                    a1 1
                                    0
                                    00-1 1v14
                                    a1 1
                                    0
                                    001 1z
                                "
                            />

                        </svg>


                        <p
                            class="
                                text-sm
                                text-gray-500
                            "
                        >
                            Tidak ada gambar
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>



    <!-- ================================================= -->
    <!-- INFORMASI PRODUK -->
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


            <!-- NAMA + SKU -->

            <div
                class="
                    grid
                    grid-cols-1
                    md:grid-cols-2
                    gap-6
                    mb-6
                "
            >

                <!-- NAMA -->

                <div>

                    <p
                        class="
                            mb-1
                            text-xs
                            text-gray-500
                            uppercase
                            tracking-wider
                        "
                    >
                        Nama Produk
                    </p>

                    <p
                        class="
                            text-base
                            font-semibold
                            text-white
                        "
                    >
                        {{ $product->name }}
                    </p>

                </div>


                <!-- SKU -->

                <div>

                    <p
                        class="
                            mb-1
                            text-xs
                            text-gray-500
                            uppercase
                            tracking-wider
                        "
                    >
                        SKU
                    </p>

                    <p
                        class="
                            text-base
                            font-medium
                            text-gray-200
                        "
                    >
                        {{ $product->sku }}
                    </p>

                </div>

            </div>



            <!-- KATEGORI + SATUAN -->

            <div
                class="
                    grid
                    grid-cols-1
                    md:grid-cols-2
                    gap-6
                    mb-6
                "
            >

                <!-- KATEGORI -->

                <div>

                    <p
                        class="
                            mb-1
                            text-xs
                            text-gray-500
                            uppercase
                            tracking-wider
                        "
                    >
                        Kategori
                    </p>

                    <p
                        class="
                            text-sm
                            text-gray-200
                        "
                    >

                        {{ $product->category?->name ?? 'Tidak ada kategori' }}

                    </p>

                </div>


                <!-- SATUAN -->

                <div>

                    <p
                        class="
                            mb-1
                            text-xs
                            text-gray-500
                            uppercase
                            tracking-wider
                        "
                    >
                        Satuan
                    </p>

                    <p
                        class="
                            text-sm
                            text-gray-200
                        "
                    >

                        {{ $product->unit }}

                    </p>

                </div>

            </div>



            <!-- DESKRIPSI -->

            <div class="mb-6">

                <p
                    class="
                        mb-2
                        text-xs
                        text-gray-500
                        uppercase
                        tracking-wider
                    "
                >
                    Deskripsi
                </p>


                @if($product->description)

                    <p
                        class="
                            text-sm
                            leading-6
                            text-gray-300
                        "
                    >
                        {{ $product->description }}
                    </p>

                @else

                    <p
                        class="
                            text-sm
                            italic
                            text-gray-500
                        "
                    >
                        Tidak ada deskripsi produk.
                    </p>

                @endif

            </div>



            <!-- HARGA -->

            <div
                class="
                    grid
                    grid-cols-1
                    md:grid-cols-2
                    gap-5
                    pt-5
                    border-t
                    border-[#3A4254]
                "
            >


                <!-- HARGA BELI -->

                <div
                    class="
                        p-4
                        bg-[#2D3445]
                        border
                        border-[#3A4254]
                        rounded-lg
                    "
                >

                    <p
                        class="
                            mb-2
                            text-xs
                            text-gray-500
                            uppercase
                            tracking-wider
                        "
                    >
                        Harga Beli
                    </p>

                    <p
                        class="
                            text-xl
                            font-bold
                            text-white
                        "
                    >
                        Rp
                        {{ number_format(
                            $product->purchase_price,
                            0,
                            ',',
                            '.'
                        ) }}
                    </p>

                </div>



                <!-- HARGA JUAL -->

                <div
                    class="
                        p-4
                        bg-[#2D3445]
                        border
                        border-[#3A4254]
                        rounded-lg
                    "
                >

                    <p
                        class="
                            mb-2
                            text-xs
                            text-gray-500
                            uppercase
                            tracking-wider
                        "
                    >
                        Harga Jual
                    </p>

                    <p
                        class="
                            text-xl
                            font-bold
                            text-white
                        "
                    >
                        Rp
                        {{ number_format(
                            $product->price,
                            0,
                            ',',
                            '.'
                        ) }}
                    </p>

                </div>

            </div>

        </div>

    </div>



    <!-- ================================================= -->
    <!-- INFORMASI STOK -->
    <!-- ================================================= -->

    <div
        class="
            lg:col-span-3
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
                Informasi Stok
            </h3>

        </div>


        <div
            class="
                grid
                grid-cols-1
                md:grid-cols-3
                gap-5
                p-5
            "
        >


            <!-- STOK SAAT INI -->

            <div
                class="
                    p-5
                    bg-[#2D3445]
                    border
                    border-[#3A4254]
                    rounded-lg
                "
            >

                <p
                    class="
                        mb-2
                        text-sm
                        text-gray-400
                    "
                >
                    Stok Saat Ini
                </p>

                <div
                    class="
                        flex
                        items-end
                        gap-2
                    "
                >

                    <p
                        class="
                            text-3xl
                            font-bold
                            text-white
                        "
                    >
                        {{ number_format($product->stock) }}
                    </p>

                    <p
                        class="
                            pb-1
                            text-sm
                            text-gray-400
                        "
                    >
                        {{ $product->unit }}
                    </p>

                </div>

            </div>



            <!-- MINIMUM STOK -->

            <div
                class="
                    p-5
                    bg-[#2D3445]
                    border
                    border-[#3A4254]
                    rounded-lg
                "
            >

                <p
                    class="
                        mb-2
                        text-sm
                        text-gray-400
                    "
                >
                    Minimum Stok
                </p>

                <div
                    class="
                        flex
                        items-end
                        gap-2
                    "
                >

                    <p
                        class="
                            text-3xl
                            font-bold
                            text-white
                        "
                    >
                        {{ number_format($product->minimum_stock) }}
                    </p>

                    <p
                        class="
                            pb-1
                            text-sm
                            text-gray-400
                        "
                    >
                        {{ $product->unit }}
                    </p>

                </div>

            </div>



            <!-- STATUS STOK -->

            <div
                class="
                    p-5
                    bg-[#2D3445]
                    border
                    border-[#3A4254]
                    rounded-lg
                "
            >

                <p
                    class="
                        mb-2
                        text-sm
                        text-gray-400
                    "
                >
                    Status Stok
                </p>


                @if($product->stock <= $product->minimum_stock)

                    <div
                        class="
                            inline-flex
                            items-center
                            px-3
                            py-2
                            text-sm
                            font-medium
                            text-red-300
                            bg-red-400/10
                            border
                            border-red-400/20
                            rounded-lg
                        "
                    >

                        <span
                            class="
                                w-2
                                h-2
                                mr-2
                                bg-red-400
                                rounded-full
                            "
                        ></span>

                        Stok Menipis

                    </div>

                @else

                    <div
                        class="
                            inline-flex
                            items-center
                            px-3
                            py-2
                            text-sm
                            font-medium
                            text-green-300
                            bg-green-400/10
                            border
                            border-green-400/20
                            rounded-lg
                        "
                    >

                        <span
                            class="
                                w-2
                                h-2
                                mr-2
                                bg-green-400
                                rounded-full
                            "
                        ></span>

                        Stok Aman

                    </div>

                @endif

            </div>

        </div>

    </div>



    <!-- ================================================= -->
    <!-- INFORMASI SISTEM -->
    <!-- ================================================= -->

    <div
        class="
            lg:col-span-3
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
                Informasi Sistem
            </h3>

        </div>


        <div
            class="
                grid
                grid-cols-1
                md:grid-cols-2
                gap-5
                p-5
            "
        >


            <!-- DIBUAT -->

            <div>

                <p
                    class="
                        mb-1
                        text-xs
                        text-gray-500
                        uppercase
                        tracking-wider
                    "
                >
                    Ditambahkan
                </p>

                <p
                    class="
                        text-sm
                        text-gray-300
                    "
                >

                    {{ $product->created_at
                        ? $product->created_at->format('d F Y, H:i')
                        : '-'
                    }}

                </p>

            </div>



            <!-- DIPERBARUI -->

            <div>

                <p
                    class="
                        mb-1
                        text-xs
                        text-gray-500
                        uppercase
                        tracking-wider
                    "
                >
                    Terakhir Diperbarui
                </p>

                <p
                    class="
                        text-sm
                        text-gray-300
                    "
                >

                    {{ $product->updated_at
                        ? $product->updated_at->format('d F Y, H:i')
                        : '-'
                    }}

                </p>

            </div>

        </div>

    </div>

</div>



<!-- ===================================================== -->
<!-- BUTTON KEMBALI -->
<!-- ===================================================== -->

<div
    class="
        flex
        justify-end
        mt-6
    "
>

    <a
        href="{{ route('manager-gudang.produk.index') }}"
        class="
            inline-flex
            items-center
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
            hover:text-white
            transition
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

        Kembali

    </a>

</div>


@endsection
