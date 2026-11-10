@extends('layouts.app')

@section('title', 'Pengaturan')

@section('page-title', 'Pengaturan')

@section('page-description', 'Kelola informasi aplikasi dan perusahaan')

@section('content')

<div class="max-w-5xl">

    {{-- SUCCESS --}}

    @if(session('success'))

        <div
            class="mb-6 p-4
                   text-sm
                   text-green-300
                   bg-green-900/30
                   border border-green-800
                   rounded-lg"
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- ERROR --}}

    @if($errors->any())

        <div
            class="mb-6 p-4
                   text-sm
                   text-red-300
                   bg-red-900/30
                   border border-red-800
                   rounded-lg"
        >

            <ul class="list-disc pl-5">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


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
                Pengaturan Aplikasi
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                Kelola identitas aplikasi dan informasi perusahaan.
            </p>

        </div>


        {{-- FORM --}}

        <form
            action="{{ route('pengaturan.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="p-6"
        >

            @csrf

            @method('PUT')


            {{-- INFORMASI APLIKASI --}}

            <div>

                <h3 class="text-lg font-semibold text-white mb-5">
                    Informasi Aplikasi
                </h3>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    {{-- NAMA APLIKASI --}}

                    <div>

                        <label
                            for="app_name"
                            class="block mb-2
                                   text-sm
                                   font-medium
                                   text-gray-300"
                        >

                            Nama Aplikasi

                            <span class="text-red-400">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            id="app_name"
                            name="app_name"
                            value="{{ old('app_name', $setting->app_name) }}"
                            required
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

                    </div>


                    {{-- LOGO --}}

                    <div>

                        <label
                            for="app_logo"
                            class="block mb-2
                                   text-sm
                                   font-medium
                                   text-gray-300"
                        >

                            Logo Aplikasi

                        </label>


                        <input
                            type="file"
                            id="app_logo"
                            name="app_logo"
                            accept=".jpg,.jpeg,.png,.webp,.svg"
                            class="w-full
                                   px-4 py-2.5
                                   text-sm
                                   text-gray-300
                                   bg-[#111B36]
                                   border border-[#3A4254]
                                   rounded-lg"
                        >


                        <p class="mt-2 text-xs text-gray-500">
                            JPG, JPEG, PNG, WEBP, atau SVG. Maksimal 2 MB.
                        </p>


                        @if($setting->app_logo)

                            <div class="mt-4">

                                <p class="text-xs text-gray-400 mb-2">
                                    Logo saat ini:
                                </p>

                                <div
                                    class="w-24 h-24
                                           p-3
                                           flex items-center justify-center
                                           bg-[#111B36]
                                           border border-[#3A4254]
                                           rounded-lg"
                                >

                                    <img
                                        src="{{ asset('storage/' . $setting->app_logo) }}"
                                        alt="Logo Aplikasi"
                                        class="max-w-full max-h-full object-contain"
                                    >

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- INFORMASI PERUSAHAAN --}}

            <div
                class="mt-8 pt-8
                       border-t border-[#3A4254]"
            >

                <h3 class="text-lg font-semibold text-white mb-5">
                    Informasi Perusahaan
                </h3>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    {{-- NAMA PERUSAHAAN --}}

                    <div class="md:col-span-2">

                        <label
                            for="company_name"
                            class="block mb-2
                                   text-sm
                                   font-medium
                                   text-gray-300"
                        >

                            Nama Perusahaan

                        </label>


                        <input
                            type="text"
                            id="company_name"
                            name="company_name"
                            value="{{ old('company_name', $setting->company_name) }}"
                            placeholder="Nama perusahaan"
                            class="w-full
                                   px-4 py-3
                                   text-sm
                                   text-white
                                   bg-[#111B36]
                                   border border-[#3A4254]
                                   rounded-lg"
                        >

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
                            value="{{ old('email', $setting->email) }}"
                            placeholder="email@perusahaan.com"
                            class="w-full
                                   px-4 py-3
                                   text-sm
                                   text-white
                                   bg-[#111B36]
                                   border border-[#3A4254]
                                   rounded-lg"
                        >

                    </div>


                    {{-- NOMOR TELEPON --}}

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
                            value="{{ old('phone', $setting->phone) }}"
                            placeholder="08xxxxxxxxxx"
                            class="w-full
                                   px-4 py-3
                                   text-sm
                                   text-white
                                   bg-[#111B36]
                                   border border-[#3A4254]
                                   rounded-lg"
                        >

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
                            rows="4"
                            placeholder="Alamat lengkap perusahaan"
                            class="w-full
                                   px-4 py-3
                                   text-sm
                                   text-white
                                   bg-[#111B36]
                                   border border-[#3A4254]
                                   rounded-lg"
                        >{{ old('address', $setting->address) }}</textarea>

                    </div>

                </div>

            </div>


            {{-- BUTTON --}}

            <div
                class="flex justify-end
                       mt-8 pt-6
                       border-t border-[#3A4254]"
            >

                <button
                    type="submit"
                    class="px-6 py-3
                           text-sm
                           font-medium
                           text-white
                           bg-[#111B36]
                           border border-[#3A4254]
                           rounded-lg
                           hover:bg-[#0B132B]"
                >

                    Simpan Pengaturan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection