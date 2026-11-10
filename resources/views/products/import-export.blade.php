@extends('layouts.app')

@section('title', 'Import / Export Produk - Stockify')

@section('page-title', 'Import / Export Produk')

@section(
    'page-description',
    'Import dan export data produk Stockify'
)

@section('content')


<!-- ===================================================== -->
<!-- HEADER -->
<!-- ===================================================== -->

<div class="flex items-center justify-between mb-6">

    <div>

        <h2 class="text-2xl font-bold text-white">
            Import / Export Produk
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Kelola data produk melalui file CSV.
        </p>

    </div>


    <a
        href="{{ route('produk.index') }}"
        class="inline-flex items-center
               px-4 py-2.5
               text-sm font-medium
               text-gray-300
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               hover:bg-[#2D3445]"
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
                d="M10 19l-7-7
                   m0 0l7-7
                   m-7 7h18"
            />

        </svg>

        Kembali ke Produk

    </a>

</div>


<!-- ===================================================== -->
<!-- SUCCESS -->
<!-- ===================================================== -->

@if(session('success'))

    <div
        class="p-4 mb-6
               text-sm text-green-300
               bg-green-900/30
               border border-green-800
               rounded-lg"
    >

        <div class="flex items-start">

            <svg
                class="w-5 h-5 mr-3 mt-0.5
                       flex-shrink-0"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                />

            </svg>

            <span>
                {{ session('success') }}
            </span>

        </div>

    </div>

@endif


<!-- ===================================================== -->
<!-- ERROR -->
<!-- ===================================================== -->

@if(session('error'))

    <div
        class="p-4 mb-6
               text-sm text-red-300
               bg-red-900/30
               border border-red-800
               rounded-lg"
    >

        <div class="flex items-start">

            <svg
                class="w-5 h-5 mr-3 mt-0.5
                       flex-shrink-0"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 8v4m0 4h.01
                       M10.29 3.86L1.82 18
                       a2 2 0 001.71 3h16.94
                       a2 2 0 001.71-3L13.71
                       3.86a2 2 0 00-3.42 0z"
                />

            </svg>

            <span>
                {{ session('error') }}
            </span>

        </div>

    </div>

@endif


<!-- ===================================================== -->
<!-- VALIDATION ERROR -->
<!-- ===================================================== -->

@if($errors->any())

    <div
        class="p-4 mb-6
               text-sm text-red-300
               bg-red-900/30
               border border-red-800
               rounded-lg"
    >

        <p class="mb-2 font-semibold">
            Terjadi kesalahan:
        </p>


        <ul class="pl-5 list-disc">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


<!-- ===================================================== -->
<!-- EXPORT -->
<!-- ===================================================== -->

<div
    class="mb-6
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           overflow-hidden"
>

    <div
        class="p-5
               border-b border-[#3A4254]"
    >

        <div class="flex items-center">

            <div
                class="flex items-center justify-center
                       w-11 h-11 mr-4
                       bg-green-900/30
                       border border-green-800
                       rounded-lg"
            >

                <svg
                    class="w-6 h-6 text-green-300"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 3v12
                           m0 0l-4-4
                           m4 4l4-4
                           M5 21h14"
                    />

                </svg>

            </div>


            <div>

                <h3
                    class="text-lg
                           font-semibold
                           text-white"
                >
                    Export Produk
                </h3>

                <p class="mt-1 text-sm text-gray-400">
                    Download seluruh data produk dalam format CSV.
                </p>

            </div>

        </div>

    </div>


    <div class="p-5">

        <div
            class="flex items-center
                   justify-between"
        >

            <div>

                <p class="text-sm text-gray-300">
                    Data yang akan diexport:
                </p>

                <p class="mt-1 text-xs text-gray-500">
                    Nama produk, SKU, kategori, deskripsi,
                    harga, stok, stok minimum, satuan, dan status.
                </p>

            </div>


            <a
                href="{{ route('produk.export') }}"
                class="inline-flex items-center
                       px-5 py-2.5
                       text-sm font-medium
                       text-white
                       bg-green-700
                       border border-green-600
                       rounded-lg
                       hover:bg-green-600"
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
                        d="M12 3v12
                           m0 0l-4-4
                           m4 4l4-4
                           M5 21h14"
                    />

                </svg>

                Export Produk

            </a>

        </div>

    </div>

</div>


<!-- ===================================================== -->
<!-- IMPORT -->
<!-- ===================================================== -->

<div
    class="mb-6
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           overflow-hidden"
>

    <div
        class="p-5
               border-b border-[#3A4254]"
    >

        <div class="flex items-center">

            <div
                class="flex items-center justify-center
                       w-11 h-11 mr-4
                       bg-blue-900/30
                       border border-blue-800
                       rounded-lg"
            >

                <svg
                    class="w-6 h-6 text-blue-300"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 21V9
                           m0 0l-4 4
                           m4-4l4 4
                           M5 3h14"
                    />

                </svg>

            </div>


            <div>

                <h3
                    class="text-lg
                           font-semibold
                           text-white"
                >
                    Import Produk
                </h3>

                <p class="mt-1 text-sm text-gray-400">
                    Tambahkan atau perbarui produk menggunakan file CSV.
                </p>

            </div>

        </div>

    </div>


    <div class="p-5">


        <!-- INFO -->

        <div
            class="p-4 mb-5
                   bg-[#2D3445]
                   border border-[#3A4254]
                   rounded-lg"
        >

            <p
                class="mb-2
                       text-sm
                       font-semibold
                       text-white"
            >
                Format file
            </p>

            <p class="text-sm text-gray-400">
                File harus menggunakan format CSV dengan kolom:
            </p>

            <p
                class="mt-2
                       text-xs
                       leading-6
                       text-gray-500"
            >
                Nama Produk · SKU · Kategori · Deskripsi ·
                Harga · Stok · Stok Minimum · Satuan · Status
            </p>

        </div>


        <!-- FORM -->

        <form
            action="{{ route('produk.import') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="mb-5">

                <label
                    for="file"
                    class="block mb-2
                           text-sm font-medium
                           text-gray-300"
                >

                    File CSV

                    <span class="text-red-400">
                        *
                    </span>

                </label>


                <input
                    type="file"
                    id="file"
                    name="file"
                    accept=".csv,.txt"
                    required
                    class="block w-full
                           text-sm text-gray-300
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           cursor-pointer

                           file:mr-4
                           file:py-2.5
                           file:px-4
                           file:border-0
                           file:text-sm
                           file:font-medium
                           file:text-white
                           file:bg-[#111B36]
                           hover:file:bg-[#0B132B]"
                >

                <p class="mt-2 text-xs text-gray-500">
                    Format CSV, maksimal 5 MB.
                </p>

            </div>


            <div class="flex items-center justify-between">


                <a
                    href="{{ route('produk.import.template') }}"
                    class="inline-flex items-center
                           px-4 py-2.5
                           text-sm font-medium
                           text-gray-300
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           hover:bg-[#111B36]"
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
                            d="M12 3v12
                               m0 0l-4-4
                               m4 4l4-4
                               M5 21h14"
                        />

                    </svg>

                    Download Template CSV

                </a>


                <button
                    type="submit"
                    class="inline-flex items-center
                           px-5 py-2.5
                           text-sm font-medium
                           text-white
                           bg-[#111B36]
                           border border-[#3A4254]
                           rounded-lg
                           hover:bg-[#0B132B]"
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
                            d="M12 21V9
                               m0 0l-4 4
                               m4-4l4 4
                               M5 3h14"
                        />

                    </svg>

                    Import Produk

                </button>

            </div>

        </form>

    </div>

</div>


<!-- ===================================================== -->
<!-- PETUNJUK -->
<!-- ===================================================== -->

<div
    class="bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg"
>

    <div class="p-5">

        <h3
            class="mb-4
                   text-lg
                   font-semibold
                   text-white"
        >
            Petunjuk Import
        </h3>


        <div class="space-y-3">


            <div class="flex items-start">

                <span
                    class="flex items-center
                           justify-center
                           w-6 h-6 mr-3
                           text-xs
                           font-semibold
                           text-gray-300
                           bg-[#2D3445]
                           rounded-full"
                >
                    1
                </span>

                <p class="text-sm text-gray-400">
                    Download template CSV terlebih dahulu.
                </p>

            </div>


            <div class="flex items-start">

                <span
                    class="flex items-center
                           justify-center
                           w-6 h-6 mr-3
                           text-xs
                           font-semibold
                           text-gray-300
                           bg-[#2D3445]
                           rounded-full"
                >
                    2
                </span>

                <p class="text-sm text-gray-400">
                    Isi data produk sesuai kolom yang tersedia.
                </p>

            </div>


            <div class="flex items-start">

                <span
                    class="flex items-center
                           justify-center
                           w-6 h-6 mr-3
                           text-xs
                           font-semibold
                           text-gray-300
                           bg-[#2D3445]
                           rounded-full"
                >
                    3
                </span>

                <p class="text-sm text-gray-400">
                    Upload file CSV yang sudah diisi.
                </p>

            </div>


            <div class="flex items-start">

                <span
                    class="flex items-center
                           justify-center
                           w-6 h-6 mr-3
                           text-xs
                           font-semibold
                           text-gray-300
                           bg-[#2D3445]
                           rounded-full"
                >
                    4
                </span>

                <p class="text-sm text-gray-400">
                    Jika SKU sudah ada, data produk tersebut akan diperbarui.
                </p>

            </div>


        </div>

    </div>

</div>


@endsection