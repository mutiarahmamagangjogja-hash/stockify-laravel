@extends('layouts.manager-gudang')


@section('title', 'Produk - Manager Gudang')


@section('page-title', 'Produk')


@section(
    'page-description',
    'Daftar produk dan informasi persediaan'
)


@section('content')


<!-- ===================================================== -->
<!-- HEADER -->
<!-- ===================================================== -->

<div
    class="
        flex
        items-center
        justify-between
        mb-6
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
            Daftar Produk
        </h2>

        <p
            class="
                mt-1
                text-sm
                text-gray-400
            "
        >
            Melihat dan mengelola data produk
        </p>

    </div>


    <a
        href="{{ route('manager-gudang.produk.create') }}"
        class="
            inline-flex
            items-center
            px-4
            py-2.5
            text-sm
            font-medium
            text-white
            bg-[#3A4254]
            rounded-lg
            hover:bg-[#465066]
            transition
        "
    >

        <svg
            class="w-5 h-5 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 4v16m8-8H4"
            />

        </svg>

        Tambah Produk

    </a>

</div>

<!-- ===================================================== -->
<!-- FILTER -->
<!-- ===================================================== -->

<div
    class="
        bg-[#252B3A]
        border
        border-[#3A4254]
        rounded-lg
        shadow-sm
        p-5
        mb-6
    "
>

    <form
        method="GET"
        action="{{ route('manager-gudang.produk.index') }}"
    >

        <div
            class="
                grid
                grid-cols-1
                md:grid-cols-4
                gap-4
                items-end
            "
        >


            <!-- SEARCH -->

            <div class="md:col-span-2">

                <label
                    class="
                        block
                        mb-2
                        text-sm
                        font-medium
                        text-gray-300
                    "
                >
                    Cari Produk
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama produk atau SKU..."
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
                        focus:border-gray-500
                    "
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
                    name="category"
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
                        Semua Kategori
                    </option>


                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            class="bg-[#252B3A]"
                            {{ request('category') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>



            <!-- STATUS -->

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
                    Status
                </label>

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
                        value=""
                        class="bg-[#252B3A]"
                    >
                        Semua Status
                    </option>

                    <option
                        value="active"
                        class="bg-[#252B3A]"
                        {{ request('status') === 'active' ? 'selected' : '' }}
                    >
                        Aktif
                    </option>

                    <option
                        value="inactive"
                        class="bg-[#252B3A]"
                        {{ request('status') === 'inactive' ? 'selected' : '' }}
                    >
                        Tidak Aktif
                    </option>

                </select>

            </div>

        </div>



        <!-- BUTTON -->

        <div
            class="
                flex
                items-center
                justify-end
                gap-3
                mt-4
            "
        >

            <a
                href="{{ route('manager-gudang.produk.index') }}"
                class="
                    px-4
                    py-2
                    text-sm
                    text-gray-300
                    bg-[#2D3445]
                    border
                    border-[#3A4254]
                    rounded-lg
                    hover:bg-[#343C50]
                "
            >
                Reset
            </a>


            <button
                type="submit"
                class="
                    px-4
                    py-2
                    text-sm
                    font-medium
                    text-white
                    bg-[#3A4254]
                    rounded-lg
                    hover:bg-[#465066]
                "
            >
                Cari
            </button>

        </div>

    </form>

</div>



<!-- ===================================================== -->
<!-- TABLE PRODUK -->
<!-- ===================================================== -->

<div
    class="
        bg-[#252B3A]
        border
        border-[#3A4254]
        rounded-lg
        shadow-sm
        overflow-hidden
    "
>


    <!-- TABLE HEADER -->

    <div
        class="
            flex
            items-center
            justify-between
            p-5
            border-b
            border-[#3A4254]
        "
    >

        <div>

            <h3
                class="
                    text-lg
                    font-semibold
                    text-white
                "
            >
                Data Produk
            </h3>

            <p
                class="
                    mt-1
                    text-sm
                    text-gray-400
                "
            >
                Total {{ $products->total() }} produk
            </p>

        </div>

    </div>



    <!-- TABLE -->

    <div class="overflow-x-auto">

        <table class="w-full text-sm text-left">


            <!-- HEAD -->

            <thead
                class="
                    text-xs
                    text-gray-400
                    uppercase
                    bg-[#2D3445]
                "
            >

                <tr>

                    <th
                        class="
                            px-6
                            py-4
                            font-semibold
                        "
                    >
                        No
                    </th>

                    <th
                        class="
                            px-6
                            py-4
                            font-semibold
                        "
                    >
                        Produk
                    </th>

                    <th
                        class="
                            px-6
                            py-4
                            font-semibold
                        "
                    >
                        SKU
                    </th>

                    <th
                        class="
                            px-6
                            py-4
                            font-semibold
                        "
                    >
                        Kategori
                    </th>

                    <th
                        class="
                            px-6
                            py-4
                            font-semibold
                        "
                    >
                        Stok
                    </th>

                    <th
                        class="
                            px-6
                            py-4
                            font-semibold
                        "
                    >
                        Satuan
                    </th>

                    <th
                        class="
                            px-6
                            py-4
                            font-semibold
                        "
                    >
                        Status
                    </th>

                    <th
                        class="
                            px-6
                            py-4
                            font-semibold
                            text-right
                        "
                    >
                        Aksi
                    </th>

                </tr>

            </thead>



            <!-- BODY -->

            <tbody
                class="
                    divide-y
                    divide-[#3A4254]
                "
            >

                @forelse($products as $index => $product)

                    <tr
                        class="
                            hover:bg-[#2D3445]
                            transition
                        "
                    >


                        <!-- NO -->

                        <td
                            class="
                                px-6
                                py-4
                                text-gray-400
                            "
                        >
                            {{ $products->firstItem() + $index }}
                        </td>



                        <!-- PRODUK -->

                        <td class="px-6 py-4">

                            <div>

                                <p
                                    class="
                                        font-medium
                                        text-white
                                    "
                                >
                                    {{ $product->name }}
                                </p>

                                @if($product->description)

                                    <p
                                        class="
                                            mt-1
                                            text-xs
                                            text-gray-500
                                            max-w-xs
                                            truncate
                                        "
                                    >
                                        {{ $product->description }}
                                    </p>

                                @endif

                            </div>

                        </td>



                        <!-- SKU -->

                        <td
                            class="
                                px-6
                                py-4
                                text-gray-300
                            "
                        >
                            {{ $product->sku }}
                        </td>



                        <!-- KATEGORI -->

                        <td
                            class="
                                px-6
                                py-4
                                text-gray-300
                            "
                        >

                            {{ $product->category->name ?? '-' }}

                        </td>



                        <!-- STOK -->

                        <td class="px-6 py-4">

                            @if(
                                $product->stock
                                <=
                                $product->minimum_stock
                            )

                                <span
                                    class="
                                        inline-flex
                                        items-center
                                        px-3
                                        py-1
                                        text-xs
                                        font-semibold
                                        text-yellow-300
                                        bg-yellow-400/10
                                        rounded-full
                                    "
                                >
                                    {{ $product->stock }}
                                </span>

                            @else

                                <span
                                    class="
                                        inline-flex
                                        items-center
                                        px-3
                                        py-1
                                        text-xs
                                        font-semibold
                                        text-green-300
                                        bg-green-400/10
                                        rounded-full
                                    "
                                >
                                    {{ $product->stock }}
                                </span>

                            @endif

                        </td>



                        <!-- SATUAN -->

                        <td
                            class="
                                px-6
                                py-4
                                text-gray-300
                            "
                        >
                            {{ $product->unit }}
                        </td>



                        <!-- STATUS -->

                        <td class="px-6 py-4">

                            @if($product->status === 'active')

                                <span
                                    class="
                                        inline-flex
                                        px-3
                                        py-1
                                        text-xs
                                        font-semibold
                                        text-green-300
                                        bg-green-400/10
                                        rounded-full
                                    "
                                >
                                    Aktif
                                </span>

                            @else

                                <span
                                    class="
                                        inline-flex
                                        px-3
                                        py-1
                                        text-xs
                                        font-semibold
                                        text-gray-300
                                        bg-gray-400/10
                                        rounded-full
                                    "
                                >
                                    Tidak Aktif
                                </span>

                            @endif

                        </td>



                        <!-- AKSI -->

                        <td
                            class="
                                px-6
                                py-4
                                text-right
                            "
                        >

                            <a
                                href="{{ route(
                                    'manager-gudang.produk.show',
                                    $product
                                ) }}"
                                class="
                                    inline-flex
                                    items-center
                                    px-3
                                    py-2
                                    text-xs
                                    font-medium
                                    text-blue-300
                                    bg-blue-400/10
                                    rounded-lg
                                    hover:bg-blue-400/20
                                "
                            >

                                Lihat Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="
                                px-6
                                py-12
                                text-center
                            "
                        >

                            <div
                                class="
                                    text-gray-500
                                "
                            >

                                <svg
                                    class="
                                        w-12
                                        h-12
                                        mx-auto
                                        mb-3
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
                                            M20 13V6
                                            a2 2 0
                                            00-2-2H6
                                            a2 2 0
                                            00-2 2v7
                                            m16 0v5
                                            a2 2 0
                                            01-2 2H6
                                            a2 2 0
                                            01-2-2v-5
                                            m16 0H4
                                        "
                                    />

                                </svg>

                                <p
                                    class="
                                        text-sm
                                    "
                                >
                                    Tidak ada produk
                                    ditemukan.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>



    <!-- ================================================= -->
    <!-- PAGINATION -->
    <!-- ================================================= -->

    @if($products->hasPages())

        <div
            class="
                flex
                items-center
                justify-between
                px-6
                py-4
                border-t
                border-[#3A4254]
            "
        >

            <p
                class="
                    text-sm
                    text-gray-400
                "
            >

                Menampilkan

                <span class="text-white">
                    {{ $products->firstItem() }}
                </span>

                sampai

                <span class="text-white">
                    {{ $products->lastItem() }}
                </span>

                dari

                <span class="text-white">
                    {{ $products->total() }}
                </span>

                produk

            </p>


            <div>

                {{ $products->links() }}

            </div>

        </div>

    @endif

</div>


@endsection
