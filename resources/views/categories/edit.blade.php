@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('page-title', 'Edit Kategori')

@section('page-description', 'Mengubah data kategori produk')

@section('content')

<div class="max-w-3xl mx-auto">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="mb-6">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold text-white">
                    Edit Kategori
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    Perbarui informasi kategori produk
                </p>

            </div>

            <a
                href="{{ route('kategori.index') }}"
                class="
                    inline-flex
                    items-center
                    px-4 py-2
                    text-sm
                    font-medium
                    text-gray-300
                    bg-[#252B3A]
                    border border-[#3A4254]
                    rounded-lg
                    hover:bg-[#2D3445]
                    hover:text-white
                    transition
                "
            >
                Kembali
            </a>

        </div>

    </div>


    <!-- ===================================================== -->
    <!-- ERROR -->
    <!-- ===================================================== -->

    @if ($errors->any())

        <div
            class="
                mb-6
                p-4
                bg-red-500/10
                border border-red-500/30
                rounded-lg
            "
        >

            <div class="flex">

                <svg
                    class="w-5 h-5 text-red-400 mr-3 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="
                            M12 8v4
                            m0 4h.01
                            M21 12a9 9 0
                            11-18 0 9 9
                            0118 0z
                        "
                    />

                </svg>

                <div>

                    <p class="font-medium text-red-400">
                        Terjadi kesalahan
                    </p>

                    <ul class="mt-2 text-sm text-red-300 space-y-1">

                        @foreach ($errors->all() as $error)

                            <li>
                                • {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif



    <!-- ===================================================== -->
    <!-- FORM -->
    <!-- ===================================================== -->

    <div
        class="
            bg-[#252B3A]
            border border-[#3A4254]
            rounded-xl
            shadow-lg
        "
    >

        <div class="p-6">

            <form
                action="{{ route('kategori.update', $category) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <!-- ================================================= -->
                <!-- NAMA KATEGORI -->
                <!-- ================================================= -->

                <div class="mb-6">

                    <label
                        for="name"
                        class="
                            block
                            mb-2
                            text-sm
                            font-medium
                            text-gray-200
                        "
                    >
                        Nama Kategori
                        <span class="text-red-400">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $category->name) }}"
                        required
                        autocomplete="off"
                        class="
                            w-full
                            px-4
                            py-3
                            text-sm
                            text-white
                            bg-[#111B36]
                            border border-[#3A4254]
                            rounded-lg
                            outline-none
                            placeholder-gray-500
                            focus:border-blue-500
                            focus:ring-1
                            focus:ring-blue-500
                        "
                        placeholder="Masukkan nama kategori"
                    >

                    @error('name')

                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                <!-- ================================================= -->
                <!-- DESKRIPSI -->
                <!-- ================================================= -->

                <div class="mb-6">

                    <label
                        for="description"
                        class="
                            block
                            mb-2
                            text-sm
                            font-medium
                            text-gray-200
                        "
                    >
                        Deskripsi
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        class="
                            w-full
                            px-4
                            py-3
                            text-sm
                            text-white
                            bg-[#111B36]
                            border border-[#3A4254]
                            rounded-lg
                            outline-none
                            placeholder-gray-500
                            resize-none
                            focus:border-blue-500
                            focus:ring-1
                            focus:ring-blue-500
                        "
                        placeholder="Masukkan deskripsi kategori (opsional)"
                    >{{ old('description', $category->description) }}</textarea>

                    @error('description')

                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                <!-- ================================================= -->
                <!-- BUTTON -->
                <!-- ================================================= -->

                <div
                    class="
                        flex
                        items-center
                        justify-end
                        gap-3
                        pt-4
                        border-t border-[#3A4254]
                    "
                >

                    <a
                        href="{{ route('kategori.index') }}"
                        class="
                            px-5
                            py-2.5
                            text-sm
                            font-medium
                            text-gray-300
                            bg-[#111B36]
                            border border-[#3A4254]
                            rounded-lg
                            hover:bg-[#2D3445]
                            hover:text-white
                            transition
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
                            bg-blue-600
                            rounded-lg
                            hover:bg-blue-700
                            focus:ring-4
                            focus:ring-blue-500/30
                            transition
                        "
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection