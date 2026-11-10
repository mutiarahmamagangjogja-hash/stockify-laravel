@extends('layouts.app')

@section('title', 'Kategori Produk - Stockify')

@section('page-title', 'Kategori Produk')

@section('page-description', 'Kelola kategori produk Stockify')


@section('content')


<!-- ===================================================== -->
<!-- HEADER -->
<!-- ===================================================== -->

<div class="flex items-center justify-between mb-6">

    <div>

        <h2 class="text-2xl font-bold text-white">
            Kategori Produk
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Kelola kategori yang digunakan pada produk Stockify.
        </p>

    </div>


    <div class="flex items-center gap-3">

        <!-- KEMBALI KE PRODUK -->

        <a
            href="{{ route('produk.index') }}"
            class="inline-flex items-center
                   px-4 py-2.5
                   text-sm font-medium
                   text-gray-300
                   bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   hover:bg-[#2D3445]
                   hover:text-white"
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


        <!-- TAMBAH PRODUK -->

        <a
            href="{{ route('produk.create') }}"
            class="inline-flex items-center
                   px-4 py-2.5
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
                    d="M12 4v16
                       M4 12h16"
                />

            </svg>

            Tambah Produk

        </a>

    </div>

</div>



<!-- ===================================================== -->
<!-- SUCCESS MESSAGE -->
<!-- ===================================================== -->

@if(session('success'))

    <div
        class="flex items-center p-4 mb-6
               text-sm
               text-green-300
               bg-green-900/30
               border border-green-800
               rounded-lg"
    >

        <svg
            class="w-5 h-5 mr-3"
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

        {{ session('success') }}

    </div>

@endif



<!-- ===================================================== -->
<!-- ERROR MESSAGE -->
<!-- ===================================================== -->

@if($errors->any())

    <div
        class="p-4 mb-6
               text-sm
               text-red-300
               bg-red-900/30
               border border-red-800
               rounded-lg"
    >

        <div class="font-semibold mb-2">
            Data belum dapat disimpan.
        </div>


        <ul class="ml-5 list-disc">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif



<!-- ===================================================== -->
<!-- CARD KATEGORI -->
<!-- ===================================================== -->

<div
    class="bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           overflow-hidden"
>


    <!-- ================================================= -->
    <!-- CARD HEADER -->
    <!-- ================================================= -->

    <div
        class="flex items-center justify-between
               p-5
               border-b border-[#3A4254]"
    >

        <div>

            <h3
                class="text-lg
                       font-semibold
                       text-white"
            >

                Daftar Kategori

            </h3>


            <p
                class="mt-1
                       text-sm
                       text-gray-400"
            >

                Semua kategori produk yang tersedia.

            </p>

        </div>


        <!-- TOTAL KATEGORI -->

        <div
            class="px-3 py-2
                   text-sm
                   text-gray-300
                   bg-[#2D3445]
                   border border-[#3A4254]
                   rounded-lg"
        >

            Total:

            <span
                class="ml-1
                       font-semibold
                       text-white"
            >

                {{ $categories->count() }}

            </span>

        </div>

    </div>



    <!-- ================================================= -->
    <!-- TABLE -->
    <!-- ================================================= -->

    <div class="overflow-x-auto">

        <table class="w-full text-sm text-left">


            <!-- TABLE HEADER -->

            <thead
                class="text-xs
                       text-gray-400
                       uppercase
                       bg-[#2D3445]"
            >

                <tr>

                    <th
                        scope="col"
                        class="px-6 py-4"
                    >
                        #
                    </th>


                    <th
                        scope="col"
                        class="px-6 py-4"
                    >
                        Nama Kategori
                    </th>


                    <th
                        scope="col"
                        class="px-6 py-4"
                    >
                        Deskripsi
                    </th>


                    <th
                        scope="col"
                        class="px-6 py-4"
                    >
                        Dibuat
                    </th>


                    <th
                        scope="col"
                        class="px-6 py-4 text-right"
                    >
                        Aksi
                    </th>

                </tr>

            </thead>



            <!-- TABLE BODY -->

            <tbody>


                @forelse($categories as $category)


                    <tr
                        class="border-b
                               border-[#3A4254]
                               hover:bg-[#2D3445]
                               transition"
                    >


                        <!-- NOMOR -->

                        <td
                            class="px-6 py-4
                                   text-gray-400"
                        >

                            {{ $loop->iteration }}

                        </td>



                        <!-- NAMA -->

                        <td
                            class="px-6 py-4"
                        >

                            <div
                                class="flex
                                       items-center"
                            >

                                <div
                                    class="flex
                                           items-center
                                           justify-center
                                           w-9 h-9
                                           mr-3
                                           text-sm
                                           font-semibold
                                           text-white
                                           bg-[#2D3445]
                                           border
                                           border-[#3A4254]
                                           rounded-lg"
                                >

                                    {{ strtoupper(substr($category->name, 0, 1)) }}

                                </div>


                                <div>

                                    <p
                                        class="font-medium
                                               text-white"
                                    >

                                        {{ $category->name }}

                                    </p>

                                    <p
                                        class="text-xs
                                               text-gray-500"
                                    >

                                        ID: {{ $category->id }}

                                    </p>

                                </div>

                            </div>

                        </td>



                        <!-- DESKRIPSI -->

                        <td
                            class="px-6 py-4
                                   text-gray-400"
                        >

                            @if($category->description)

                                {{ $category->description }}

                            @else

                                <span
                                    class="text-gray-600"
                                >

                                    Tidak ada deskripsi

                                </span>

                            @endif

                        </td>



                        <!-- TANGGAL -->

                        <td
                            class="px-6 py-4
                                   text-gray-400"
                        >

                            {{ $category->created_at?->format('d/m/Y') ?? '-' }}

                        </td>



                        <!-- AKSI -->

                        <td
                            class="px-6 py-4"
                        >

                            <div
                                class="flex
                                       items-center
                                       justify-end
                                       gap-2"
                            >


                                <!-- EDIT -->

                                <a
                                    href="{{ route('kategori.edit', $category) }}"
                                    class="inline-flex
                                           items-center
                                           px-3 py-2
                                           text-xs
                                           font-medium
                                           text-blue-300
                                           bg-blue-900/30
                                           border
                                           border-blue-800
                                           rounded-lg
                                           hover:bg-blue-900/50
                                           transition"
                                >

                                    <svg
                                        class="w-4 h-4 mr-1.5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11
                                               a2 2 0 002 2h11a2 2 0
                                               002-2v-5
                                               M18.5 2.5a2.121 2.121
                                               0 013 3L12 15l-4 1 1-4
                                               9.5-9.5z"
                                        />

                                    </svg>

                                    Edit

                                </a>



                                <!-- HAPUS -->

                                <form
                                    action="{{ route('kategori.destroy', $category) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->name }}?')"
                                >

                                    @csrf

                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="inline-flex
                                               items-center
                                               px-3 py-2
                                               text-xs
                                               font-medium
                                               text-red-300
                                               bg-red-900/30
                                               border
                                               border-red-800
                                               rounded-lg
                                               hover:bg-red-900/50
                                               transition"
                                    >

                                        <svg
                                            class="w-4 h-4 mr-1.5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142
                                                   A2 2 0 0116.138 21H7.862
                                                   a2 2 0 01-1.995-1.858L5
                                                   7m5 4v6m4-6v6
                                                   M9 7V4a1 1 0 011-1h4
                                                   a1 1 0 011 1v3
                                                   M4 7h16"
                                            />

                                        </svg>

                                        Hapus

                                    </button>

                                </form>


                            </div>

                        </td>


                    </tr>


                @empty


                    <!-- TIDAK ADA DATA -->

                    <tr>

                        <td
                            colspan="5"
                            class="px-6 py-16
                                   text-center"
                        >

                            <div
                                class="flex
                                       flex-col
                                       items-center
                                       justify-center"
                            >

                                <div
                                    class="flex
                                           items-center
                                           justify-center
                                           w-16 h-16
                                           mb-4
                                           text-gray-400
                                           bg-[#2D3445]
                                           border
                                           border-[#3A4254]
                                           rounded-xl"
                                >

                                    <svg
                                        class="w-8 h-8"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M20 7l-8-4-8 4
                                               m16 0l-8 4m8-4v10l-8
                                               4m0-10L4 7m8 4v10
                                               M4 7v10l8 4"
                                        />

                                    </svg>

                                </div>


                                <p
                                    class="text-sm
                                           font-medium
                                           text-white"
                                >

                                    Belum ada kategori

                                </p>


                                <p
                                    class="mt-1
                                           text-sm
                                           text-gray-500"
                                >

                                    Silakan tambahkan kategori produk.

                                </p>


                                <a
                                    href="{{ route('kategori.create') }}"
                                    class="mt-4
                                           px-4 py-2
                                           text-sm
                                           font-medium
                                           text-white
                                           bg-[#111B36]
                                           border
                                           border-[#3A4254]
                                           rounded-lg
                                           hover:bg-[#0B132B]"
                                >

                                    + Tambah Kategori

                                </a>

                            </div>

                        </td>

                    </tr>


                @endforelse


            </tbody>

        </table>

    </div>


    <!-- ================================================= -->
    <!-- FOOTER CARD -->
    <!-- ================================================= -->

    @if($categories->count() > 0)

        <div
            class="flex
                   items-center
                   justify-between
                   px-5 py-4
                   border-t
                   border-[#3A4254]"
        >

            <p
                class="text-sm
                       text-gray-500"
            >

                Menampilkan
                <span class="text-gray-300">
                    {{ $categories->count() }}
                </span>
                kategori.

            </p>


            <a
                href="{{ route('kategori.create') }}"
                class="text-sm
                       text-gray-400
                       hover:text-white"
            >

                + Tambah kategori

            </a>

        </div>

    @endif


</div>


@endsection