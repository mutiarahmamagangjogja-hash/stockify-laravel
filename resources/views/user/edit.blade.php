@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('page-title', 'Edit Pengguna')

@section(
    'page-description',
    'Perbarui informasi pengguna Stockify'
)


@section('content')

<div class="max-w-4xl mx-auto">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="mb-6">

        <a
            href="{{ route('pengguna.index') }}"
            class="inline-flex items-center
                   text-sm
                   text-gray-400
                   hover:text-white
                   transition"
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

            Kembali ke Pengguna

        </a>

    </div>


    <!-- ===================================================== -->
    <!-- FORM CARD -->
    <!-- ===================================================== -->

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-xl
               overflow-hidden"
    >

        <!-- HEADER CARD -->

        <div
            class="px-6 py-5
                   border-b border-[#3A4254]"
        >

            <h2
                class="text-lg
                       font-semibold
                       text-white"
            >
                Edit Pengguna
            </h2>

            <p
                class="mt-1
                       text-sm
                       text-gray-400"
            >
                Ubah informasi akun pengguna.
            </p>

        </div>


        <!-- ================================================= -->
        <!-- ERROR -->
        <!-- ================================================= -->

        @if ($errors->any())

            <div
                class="mx-6 mt-6
                       px-4 py-3
                       rounded-lg
                       bg-red-500/10
                       border border-red-500/30
                       text-red-400"
            >

                <ul class="list-disc list-inside text-sm">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <!-- ================================================= -->
        <!-- FORM -->
        <!-- ================================================= -->

        <form
            action="{{ route(
                'pengguna.update',
                $pengguna->id
            ) }}"
            method="POST"
            class="p-6"
        >

            @csrf

            @method('PUT')


            <!-- ================================================= -->
            <!-- NAMA -->
            <!-- ================================================= -->

            <div class="mb-5">

                <label
                    for="name"
                    class="block
                           mb-2
                           text-sm
                           font-medium
                           text-gray-300"
                >
                    Nama Lengkap
                </label>


                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old(
                        'name',
                        $pengguna->name
                    ) }}"
                    required

                    class="w-full
                           px-4 py-3
                           rounded-lg
                           bg-[#111B36]
                           border border-[#3A4254]
                           text-white
                           placeholder-gray-500
                           focus:outline-none
                           focus:border-blue-500"
                >

            </div>


            <!-- ================================================= -->
            <!-- EMAIL -->
            <!-- ================================================= -->

            <div class="mb-5">

                <label
                    for="email"
                    class="block
                           mb-2
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
                    value="{{ old(
                        'email',
                        $pengguna->email
                    ) }}"
                    required

                    class="w-full
                           px-4 py-3
                           rounded-lg
                           bg-[#111B36]
                           border border-[#3A4254]
                           text-white
                           placeholder-gray-500
                           focus:outline-none
                           focus:border-blue-500"
                >

            </div>


            <!-- ================================================= -->
            <!-- ROLE -->
            <!-- ================================================= -->

            <div class="mb-5">

                <label
                    for="role"
                    class="block
                           mb-2
                           text-sm
                           font-medium
                           text-gray-300"
                >
                    Role
                </label>


                <select
                    id="role"
                    name="role"
                    required

                    class="w-full
                           px-4 py-3
                           rounded-lg
                           bg-[#111B36]
                           border border-[#3A4254]
                           text-white
                           focus:outline-none
                           focus:border-blue-500"
                >

                    <option
                        value="admin"
                        {{ old(
                            'role',
                            $pengguna->role
                        ) === 'admin'
                            ? 'selected'
                            : ''
                        }}
                    >
                        Admin
                    </option>


                    <option
                        value="manager_gudang"
                        {{ old(
                            'role',
                            $pengguna->role
                        ) === 'manager_gudang'
                            ? 'selected'
                            : ''
                        }}
                    >
                        Manager Gudang
                    </option>


                    <option
                        value="staff_gudang"
                        {{ old(
                            'role',
                            $pengguna->role
                        ) === 'staff_gudang'
                            ? 'selected'
                            : ''
                        }}
                    >
                        Staff Gudang
                    </option>

                </select>

            </div>


            <!-- ================================================= -->
            <!-- STATUS -->
            <!-- ================================================= -->

            <div class="mb-5">

                <label
                    for="status"
                    class="block
                           mb-2
                           text-sm
                           font-medium
                           text-gray-300"
                >
                    Status
                </label>


                <select
                    id="status"
                    name="status"
                    required

                    class="w-full
                           px-4 py-3
                           rounded-lg
                           bg-[#111B36]
                           border border-[#3A4254]
                           text-white
                           focus:outline-none
                           focus:border-blue-500"
                >

                    <option
                        value="1"
                        {{ old(
                            'status',
                            $pengguna->status
                        ) == 1
                            ? 'selected'
                            : ''
                        }}
                    >
                        Aktif
                    </option>


                    <option
                        value="0"
                        {{ old(
                            'status',
                            $pengguna->status
                        ) == 0
                            ? 'selected'
                            : ''
                        }}
                    >
                        Tidak Aktif
                    </option>

                </select>

            </div>


            <!-- ================================================= -->
            <!-- PASSWORD -->
            <!-- ================================================= -->

            <div
                class="pt-5
                       mb-5
                       border-t border-[#3A4254]"
            >

                <h3
                    class="mb-1
                           text-sm
                           font-semibold
                           text-white"
                >
                    Ubah Password
                </h3>

                <p
                    class="mb-4
                           text-xs
                           text-gray-400"
                >
                    Kosongkan jika password tidak ingin diubah.
                </p>


                <!-- PASSWORD -->

                <div class="mb-5">

                    <label
                        for="password"
                        class="block
                               mb-2
                               text-sm
                               font-medium
                               text-gray-300"
                    >
                        Password Baru
                    </label>


                    <input
                        type="password"
                        id="password"
                        name="password"

                        class="w-full
                               px-4 py-3
                               rounded-lg
                               bg-[#111B36]
                               border border-[#3A4254]
                               text-white
                               focus:outline-none
                               focus:border-blue-500"
                    >

                </div>


                <!-- KONFIRMASI PASSWORD -->

                <div>

                    <label
                        for="password_confirmation"
                        class="block
                               mb-2
                               text-sm
                               font-medium
                               text-gray-300"
                    >
                        Konfirmasi Password Baru
                    </label>


                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"

                        class="w-full
                               px-4 py-3
                               rounded-lg
                               bg-[#111B36]
                               border border-[#3A4254]
                               text-white
                               focus:outline-none
                               focus:border-blue-500"
                    >

                </div>

            </div>


            <!-- ================================================= -->
            <!-- BUTTON -->
            <!-- ================================================= -->

            <div
                class="flex
                       items-center
                       justify-end
                       gap-3
                       pt-5
                       border-t border-[#3A4254]"
            >

                <a
                    href="{{ route('pengguna.index') }}"
                    class="px-5 py-3
                           rounded-lg
                           text-sm
                           font-medium
                           text-gray-300
                           bg-[#111B36]
                           border border-[#3A4254]
                           hover:bg-[#2D3445]
                           transition"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="px-5 py-3
                           rounded-lg
                           text-sm
                           font-medium
                           text-white
                           bg-blue-600
                           hover:bg-blue-700
                           transition"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection