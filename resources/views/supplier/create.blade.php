```blade
@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('page-title', 'Tambah Supplier')

@section('page-description', 'Tambahkan supplier baru ke dalam sistem')

@section('content')

<div class="max-w-4xl">

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        {{-- HEADER --}}

        <div
            class="px-6 py-5
                   border-b border-[#3A4254]"
        >

            <h2 class="text-xl font-semibold text-white">
                Tambah Supplier
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                Isi informasi supplier dengan lengkap.
            </p>

        </div>


        {{-- FORM --}}

        <form
            action="{{ route('supplier.store') }}"
            method="POST"
            class="p-6"
        >

            @csrf


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                {{-- NAMA --}}

                <div class="md:col-span-2">

                    <label
                        for="name"
                        class="block mb-2
                               text-sm
                               font-medium
                               text-gray-300"
                    >
                        Nama Supplier
                        <span class="text-red-400">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="Contoh: PT Sumber Jaya"
                        class="w-full
                               px-4 py-3
                               text-sm
                               text-white
                               bg-[#111B36]
                               border border-[#3A4254]
                               rounded-lg
                               focus:outline-none
                               focus:border-gray-500"
                    >

                    @error('name')

                        <p class="mt-1 text-xs text-red-400">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- TELEPON --}}

                <div>

                    <label
                        for="phone"
                        class="block mb-2
                               text-sm
                               font-medium
                               text-gray-300"
                    >
                        Nomor Telepon
                    </label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="Contoh: 081234567890"
                        class="w-full
                               px-4 py-3
                               text-sm
                               text-white
                               bg-[#111B36]
                               border border-[#3A4254]
                               rounded-lg
                               focus:outline-none
                               focus:border-gray-500"
                    >

                    @error('phone')

                        <p class="mt-1 text-xs text-red-400">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- EMAIL --}}

                <div>

                    <label
                        for="email"
                        class="block mb-2
                               text-sm
                               font-medium
                               text-gray-300"
                    >
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="supplier@email.com"
                        class="w-full
                               px-4 py-3
                               text-sm
                               text-white
                               bg-[#111B36]
                               border border-[#3A4254]
                               rounded-lg
                               focus:outline-none
                               focus:border-gray-500"
                    >

                    @error('email')

                        <p class="mt-1 text-xs text-red-400">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- ALAMAT --}}

                <div class="md:col-span-2">

                    <label
                        for="address"
                        class="block mb-2
                               text-sm
                               font-medium
                               text-gray-300"
                    >
                        Alamat
                    </label>

                    <textarea
                        id="address"
                        name="address"
                        rows="3"
                        placeholder="Masukkan alamat supplier"
                        class="w-full
                               px-4 py-3
                               text-sm
                               text-white
                               bg-[#111B36]
                               border border-[#3A4254]
                               rounded-lg
                               focus:outline-none
                               focus:border-gray-500"
                    >{{ old('address') }}</textarea>

                    @error('address')

                        <p class="mt-1 text-xs text-red-400">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- DESKRIPSI --}}

                <div class="md:col-span-2">

                    <label
                        for="description"
                        class="block mb-2
                               text-sm
                               font-medium
                               text-gray-300"
                    >
                        Deskripsi
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        placeholder="Catatan tambahan mengenai supplier"
                        class="w-full
                               px-4 py-3
                               text-sm
                               text-white
                               bg-[#111B36]
                               border border-[#3A4254]
                               rounded-lg
                               focus:outline-none
                               focus:border-gray-500"
                    >{{ old('description') }}</textarea>

                    @error('description')

                        <p class="mt-1 text-xs text-red-400">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- STATUS --}}

                <div class="md:col-span-2">

                    <label
                        class="flex items-center gap-3 cursor-pointer"
                    >

                        <input
                            type="checkbox"
                            name="status"
                            value="1"
                            checked
                            class="w-4 h-4"
                        >

                        <span class="text-sm text-gray-300">
                            Supplier aktif
                        </span>

                    </label>

                </div>

            </div>


            {{-- BUTTON --}}

            <div
                class="flex items-center
                       justify-end
                       gap-3
                       mt-8
                       pt-6
                       border-t border-[#3A4254]"
            >

                <a
                    href="{{ route('supplier.index') }}"
                    class="px-5 py-2.5
                           text-sm
                           font-medium
                           text-gray-300
                           bg-[#111B36]
                           border border-[#3A4254]
                           rounded-lg
                           hover:bg-[#0B132B]"
                >
                    Batal
                </a>


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
                    Simpan Supplier
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
```
