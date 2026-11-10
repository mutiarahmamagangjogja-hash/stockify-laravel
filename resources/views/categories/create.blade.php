@extends('layouts.app')

@section('title', 'Tambah Kategori - Stockify')

@section('page-title', 'Tambah Kategori')

@section('page-description', 'Tambahkan kategori produk baru')

@section('content')

<div class="max-w-3xl">

    <!-- HEADER -->

    <div class="mb-6">

        <h2 class="text-2xl font-bold text-white">
            Tambah Kategori
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Tambahkan kategori baru yang akan digunakan pada produk.
        </p>

    </div>


    <!-- ERROR -->

    @if($errors->any())

        <div
            class="p-4 mb-6
                   text-sm
                   text-red-300
                   bg-red-900/30
                   border border-red-800
                   rounded-lg"
        >

            <p class="mb-2 font-semibold">
                Data belum dapat disimpan.
            </p>

            <ul class="ml-5 list-disc">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- FORM -->

    <form
        action="{{ route('kategori.store') }}"
        method="POST"
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        @csrf


        <div class="p-6">

            <!-- NAMA KATEGORI -->

            <div class="mb-6">

                <label
                    for="name"
                    class="block mb-2
                           text-sm
                           font-medium
                           text-white"
                >
                    Nama Kategori
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    placeholder="Contoh: Elektronik"
                    class="w-full
                           px-4 py-3
                           text-sm
                           text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           placeholder-gray-500
                           focus:ring-2
                           focus:ring-gray-500
                           focus:border-gray-500
                           outline-none"
                >

            </div>


            <!-- DESKRIPSI -->

            <div>

                <label
                    for="description"
                    class="block mb-2
                           text-sm
                           font-medium
                           text-white"
                >
                    Deskripsi
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Contoh: Kategori untuk produk elektronik."
                    class="w-full
                           px-4 py-3
                           text-sm
                           text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           placeholder-gray-500
                           focus:ring-2
                           focus:border-gray-500
                           outline-none"
                >{{ old('description') }}</textarea>

            </div>

        </div>


        <!-- FOOTER -->

        <div
            class="flex items-center
                   justify-end
                   gap-3
                   px-6 py-4
                   border-t border-[#3A4254]"
        >

            <!-- BATAL -->

            <a
                href="{{ route('kategori.index') }}"
                class="px-5 py-2.5
                       text-sm
                       font-medium
                       text-gray-300
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg
                       hover:bg-[#111B36]"
            >
                Batal
            </a>


            <!-- SIMPAN -->

            <button
                type="submit"
                class="px-5 py-2.5
                       text-sm
                       font-medium
                       text-white
                       bg-[#111B36]
                       border border-[#3A4254]
                       rounded-lg
                       hover:bg-[#0B132B]"
            >
                Simpan Kategori
            </button>

        </div>

    </form>

</div>

@endsection