@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('page-title', 'Tambah Pengguna')

@section('page-description', 'Tambahkan akun pengguna baru ke sistem Stockify')

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
            Tambah Pengguna
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Isi informasi akun pengguna dengan lengkap.
        </p>

    </div>


    {{-- FORM --}}

    <form
        action="{{ route('pengguna.store') }}"
        method="POST"
        class="p-6"
    >

        @csrf


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


            {{-- NAMA --}}

            <div class="md:col-span-2">

                <label
                    for="name"
                    class="block mb-2 text-sm font-medium text-gray-300"
                >
                    Nama Lengkap
                    <span class="text-red-400">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Contoh: Staff Gudang"
                    class="w-full px-4 py-3
                           text-sm text-white
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


            {{-- EMAIL --}}

            <div class="md:col-span-2">

                <label
                    for="email"
                    class="block mb-2 text-sm font-medium text-gray-300"
                >
                    Email
                    <span class="text-red-400">*</span>
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="staff@stockify.test"
                    class="w-full px-4 py-3
                           text-sm text-white
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


            {{-- PASSWORD --}}

            <div>

                <label
                    for="password"
                    class="block mb-2 text-sm font-medium text-gray-300"
                >
                    Password
                    <span class="text-red-400">*</span>
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="Minimal 6 karakter"
                    class="w-full px-4 py-3
                           text-sm text-white
                           bg-[#111B36]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none
                           focus:border-gray-500"
                >

                @error('password')
                    <p class="mt-1 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- KONFIRMASI PASSWORD --}}

            <div>

                <label
                    for="password_confirmation"
                    class="block mb-2 text-sm font-medium text-gray-300"
                >
                    Konfirmasi Password
                    <span class="text-red-400">*</span>
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    placeholder="Ulangi password"
                    class="w-full px-4 py-3
                           text-sm text-white
                           bg-[#111B36]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none
                           focus:border-gray-500"
                >

            </div>


            {{-- ROLE --}}

            <div>

                <label
                    for="role"
                    class="block mb-2 text-sm font-medium text-gray-300"
                >
                    Role
                    <span class="text-red-400">*</span>
                </label>

                <select
                    id="role"
                    name="role"
                    required
                    class="w-full px-4 py-3
                           text-sm text-white
                           bg-[#111B36]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none
                           focus:border-gray-500"
                >

                    {{-- STAFF GUDANG --}}

                    <option
                        value="staff_gudang"
                        {{ old('role', 'staff_gudang') === 'staff_gudang'
                            ? 'selected'
                            : '' }}
                    >
                        Staff Gudang
                    </option>


                    {{-- MANAGER GUDANG --}}

                    <option
                        value="manager_gudang"
                        {{ old('role') === 'manager_gudang'
                            ? 'selected'
                            : '' }}
                    >
                        Manager Gudang
                    </option>


                    {{-- ADMIN --}}

                    <option
                        value="admin"
                        {{ old('role') === 'admin'
                            ? 'selected'
                            : '' }}
                    >
                        Admin
                    </option>

                </select>

                @error('role')
                    <p class="mt-1 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- STATUS --}}

            <div>

                <label
                    class="block mb-2
                           text-sm
                           font-medium
                           text-gray-300"
                >
                    Status
                </label>

                <label
                    class="flex items-center
                           gap-3
                           h-[46px]
                           cursor-pointer"
                >

                    <input
                        type="checkbox"
                        name="status"
                        value="1"
                        {{ old('status', true) ? 'checked' : '' }}
                        class="w-4 h-4"
                    >

                    <span class="text-sm text-gray-300">
                        Pengguna Aktif
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
                href="{{ route('pengguna.index') }}"
                class="px-5 py-2.5
                       text-sm font-medium
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
                       text-sm font-medium
                       text-white
                       bg-[#111B36]
                       border border-[#3A4254]
                       rounded-lg
                       hover:bg-[#0B132B]"
            >
                Simpan Pengguna
            </button>

        </div>

    </form>

</div>

</div>

@endsection
