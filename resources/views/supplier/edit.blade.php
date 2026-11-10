@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('page-title', 'Edit Supplier')

@section(
    'page-description',
    'Perbarui informasi supplier'
)

@section('content')

<div class="max-w-4xl mx-auto">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="mb-6">

        <h2 class="text-2xl font-bold text-white">
            Edit Supplier
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Perbarui informasi supplier di bawah ini.
        </p>

    </div>


    <!-- ===================================================== -->
    <!-- ERROR -->
    <!-- ===================================================== -->

    @if ($errors->any())

        <div
            class="
                mb-6
                p-4
                rounded-lg
                bg-red-500/10
                border border-red-500/30
            "
        >

            <div class="flex items-start">

                <svg
                    class="w-5 h-5 mr-3 mt-0.5 text-red-400 flex-shrink-0"
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
                            11-18 0 9 9 0
                            0118 0z
                        "
                    />

                </svg>

                <div>

                    <p class="font-semibold text-red-400">
                        Terdapat kesalahan:
                    </p>

                    <ul
                        class="
                            mt-2
                            text-sm
                            text-red-300
                            list-disc
                            list-inside
                        "
                    >

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
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
            p-6
        "
    >

        <form
            action="{{ route('supplier.update', $supplier->id) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <!-- ================================================= -->
            <!-- NAMA SUPPLIER -->
            <!-- ================================================= -->

            <div class="mb-5">

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
                    Nama Supplier
                    <span class="text-red-400">*</span>
                </label>


                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $supplier->name) }}"
                    required
                    placeholder="Masukkan nama supplier"
                    class="
                        w-full
                        px-4
                        py-3
                        rounded-lg
                        bg-[#111B36]
                        border border-[#3A4254]
                        text-white
                        placeholder-gray-500
                        focus:outline-none
                        focus:ring-2
                        focus:ring-blue-500
                        focus:border-transparent
                    "
                >

            </div>


            <!-- ================================================= -->
            <!-- KONTAK -->
            <!-- ================================================= -->

            <div class="mb-5">

                <label
                    for="contact"
                    class="
                        block
                        mb-2
                        text-sm
                        font-medium
                        text-gray-200
                    "
                >
                    Kontak
                </label>


                <input
                    type="text"
                    id="contact"
                    name="contact"
                    value="{{ old('contact', $supplier->contact) }}"
                    placeholder="Contoh: 081234567890"
                    class="
                        w-full
                        px-4
                        py-3
                        rounded-lg
                        bg-[#111B36]
                        border border-[#3A4254]
                        text-white
                        placeholder-gray-500
                        focus:outline-none
                        focus:ring-2
                        focus:ring-blue-500
                        focus:border-transparent
                    "
                >

            </div>


            <!-- ================================================= -->
            <!-- EMAIL -->
            <!-- ================================================= -->

            <div class="mb-5">

                <label
                    for="email"
                    class="
                        block
                        mb-2
                        text-sm
                        font-medium
                        text-gray-200
                    "
                >
                    Email
                </label>


                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $supplier->email) }}"
                    placeholder="Contoh: supplier@email.com"
                    class="
                        w-full
                        px-4
                        py-3
                        rounded-lg
                        bg-[#111B36]
                        border border-[#3A4254]
                        text-white
                        placeholder-gray-500
                        focus:outline-none
                        focus:ring-2
                        focus:ring-blue-500
                        focus:border-transparent
                    "
                >

            </div>


            <!-- ================================================= -->
            <!-- ALAMAT -->
            <!-- ================================================= -->

            <div class="mb-6">

                <label
                    for="address"
                    class="
                        block
                        mb-2
                        text-sm
                        font-medium
                        text-gray-200
                    "
                >
                    Alamat
                </label>


                <textarea
                    id="address"
                    name="address"
                    rows="4"
                    placeholder="Masukkan alamat supplier"
                    class="
                        w-full
                        px-4
                        py-3
                        rounded-lg
                        bg-[#111B36]
                        border border-[#3A4254]
                        text-white
                        placeholder-gray-500
                        focus:outline-none
                        focus:ring-2
                        focus:ring-blue-500
                        focus:border-transparent
                        resize-none
                    "
                >{{ old('address', $supplier->address) }}</textarea>

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
                    pt-5
                    border-t
                    border-[#3A4254]
                "
            >

                <!-- BATAL -->

                <a
                    href="{{ route('supplier.index') }}"
                    class="
                        px-5
                        py-2.5
                        rounded-lg
                        bg-[#111B36]
                        border border-[#3A4254]
                        text-gray-300
                        font-medium
                        hover:bg-[#2D3445]
                        hover:text-white
                        transition
                    "
                >
                    Batal
                </a>


                <!-- SIMPAN -->

                <button
                    type="submit"
                    class="
                        px-5
                        py-2.5
                        rounded-lg
                        bg-blue-600
                        text-white
                        font-medium
                        hover:bg-blue-700
                        transition
                    "
                >

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection