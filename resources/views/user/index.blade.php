@extends('layouts.app')

@section('title', 'Pengguna')

@section('page-title', 'Pengguna')

@section(
    'page-description',
    'Kelola pengguna dan hak akses Stockify'
)


@section('content')

<div class="space-y-6">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div
        class="flex flex-col
               gap-4
               md:flex-row
               md:items-center
               md:justify-between"
    >

        <div>

            <h2
                class="text-2xl
                       font-bold
                       text-white"
            >
                Pengguna
            </h2>

            <p
                class="mt-1
                       text-sm
                       text-gray-400"
            >
                Kelola akun pengguna dan hak akses sistem.
            </p>

        </div>


        <a
            href="{{ route('pengguna.create') }}"
            class="inline-flex
                   items-center
                   justify-center
                   px-4 py-2.5
                   rounded-lg
                   bg-blue-600
                   hover:bg-blue-700
                   text-white
                   text-sm
                   font-medium
                   transition"
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

            Tambah Pengguna

        </a>

    </div>


    <!-- ===================================================== -->
    <!-- SUCCESS MESSAGE -->
    <!-- ===================================================== -->

    @if(session('success'))

        <div
            class="flex items-center
                   px-4 py-3
                   rounded-lg
                   bg-green-500/10
                   border border-green-500/30
                   text-green-400"
        >

            <svg
                class="w-5 h-5 mr-3 flex-shrink-0"
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

            <span class="text-sm">
                {{ session('success') }}
            </span>

        </div>

    @endif


    <!-- ===================================================== -->
    <!-- ERROR MESSAGE -->
    <!-- ===================================================== -->

    @if(session('error'))

        <div
            class="flex items-center
                   px-4 py-3
                   rounded-lg
                   bg-red-500/10
                   border border-red-500/30
                   text-red-400"
        >

            <svg
                class="w-5 h-5 mr-3 flex-shrink-0"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6
                       M6 6l12 12"
                />

            </svg>

            <span class="text-sm">
                {{ session('error') }}
            </span>

        </div>

    @endif


    <!-- ===================================================== -->
    <!-- TABLE -->
    <!-- ===================================================== -->

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-xl
               overflow-hidden"
    >

        <!-- TABLE HEADER -->

        <div
            class="px-6 py-5
                   border-b border-[#3A4254]"
        >

            <h3
                class="text-lg
                       font-semibold
                       text-white"
            >
                Daftar Pengguna
            </h3>

            <p
                class="mt-1
                       text-sm
                       text-gray-400"
            >
                Daftar seluruh akun yang terdaftar dalam sistem.
            </p>

        </div>


        <!-- ================================================= -->
        <!-- TABLE -->
        <!-- ================================================= -->

        <div class="overflow-x-auto">

            <table
                class="w-full
                       text-sm
                       text-left"
            >

                <thead
                    class="bg-[#111B36]
                           text-gray-400
                           uppercase
                           text-xs"
                >

                    <tr>

                        <th
                            class="px-6 py-4
                                   font-semibold"
                        >
                            No
                        </th>

                        <th
                            class="px-6 py-4
                                   font-semibold"
                        >
                            Nama
                        </th>

                        <th
                            class="px-6 py-4
                                   font-semibold"
                        >
                            Email
                        </th>

                        <th
                            class="px-6 py-4
                                   font-semibold"
                        >
                            Role
                        </th>

                        <th
                            class="px-6 py-4
                                   font-semibold"
                        >
                            Status
                        </th>

                        <th
                            class="px-6 py-4
                                   font-semibold
                                   text-center"
                        >
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody
                    class="divide-y
                           divide-[#3A4254]"
                >

                    @forelse($users as $user)

                        <tr
                            class="hover:bg-[#2D3445]
                                   transition"
                        >

                            <!-- NO -->

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
                                               rounded-full
                                               bg-[#111B36]
                                               text-white
                                               font-semibold"
                                    >

                                        {{ strtoupper(
                                            substr(
                                                $user->name,
                                                0,
                                                1
                                            )
                                        ) }}

                                    </div>


                                    <div>

                                        <p
                                            class="font-medium
                                                   text-white"
                                        >
                                            {{ $user->name }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            <!-- EMAIL -->

                            <td
                                class="px-6 py-4
                                       text-gray-300"
                            >

                                {{ $user->email }}

                            </td>


                            <!-- ROLE -->

                            <td
                                class="px-6 py-4"
                            >

                                @if($user->role === 'admin')

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               text-xs
                                               font-medium
                                               bg-purple-500/10
                                               text-purple-400
                                               border
                                               border-purple-500/20"
                                    >
                                        Admin
                                    </span>

                                @elseif(
                                    $user->role ===
                                    'manager_gudang'
                                )

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               text-xs
                                               font-medium
                                               bg-blue-500/10
                                               text-blue-400
                                               border
                                               border-blue-500/20"
                                    >
                                        Manager Gudang
                                    </span>

                                @elseif(
                                    $user->role ===
                                    'staff_gudang'
                                )

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               text-xs
                                               font-medium
                                               bg-cyan-500/10
                                               text-cyan-400
                                               border
                                               border-cyan-500/20"
                                    >
                                        Staff Gudang
                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               text-xs
                                               font-medium
                                               bg-gray-500/10
                                               text-gray-400"
                                    >
                                        {{ $user->role }}
                                    </span>

                                @endif

                            </td>


                            <!-- STATUS -->

                            <td
                                class="px-6 py-4"
                            >

                                @if($user->status)

                                    <span
                                        class="inline-flex
                                               items-center
                                               px-3 py-1
                                               rounded-full
                                               text-xs
                                               font-medium
                                               bg-green-500/10
                                               text-green-400
                                               border
                                               border-green-500/20"
                                    >

                                        <span
                                            class="w-1.5
                                                   h-1.5
                                                   mr-2
                                                   rounded-full
                                                   bg-green-400"
                                        ></span>

                                        Aktif

                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               items-center
                                               px-3 py-1
                                               rounded-full
                                               text-xs
                                               font-medium
                                               bg-red-500/10
                                               text-red-400
                                               border
                                               border-red-500/20"
                                    >

                                        <span
                                            class="w-1.5
                                                   h-1.5
                                                   mr-2
                                                   rounded-full
                                                   bg-red-400"
                                        ></span>

                                        Tidak Aktif

                                    </span>

                                @endif

                            </td>


                            <!-- AKSI -->

                            <td
                                class="px-6 py-4"
                            >

                                <div
                                    class="flex
                                           items-center
                                           justify-center
                                           gap-2"
                                >

                                    <!-- EDIT -->

                                    <a
                                        href="{{ route(
                                            'pengguna.edit',
                                            $user->id
                                        ) }}"
                                        class="inline-flex
                                               items-center
                                               px-3 py-2
                                               rounded-lg
                                               text-xs
                                               font-medium
                                               text-blue-400
                                               bg-blue-500/10
                                               hover:bg-blue-500/20
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
                                                d="M11 5H6a2 2 0
                                                   00-2 2v11a2 2 0
                                                   002 2h11a2 2 0
                                                   002-2v-5
                                                   M18.5 2.5a2.121
                                                   2.121 0 013 3L12
                                                   15l-4 1 1-4 9.5-9.5z"
                                            />

                                        </svg>

                                        Edit

                                    </a>


                                    <!-- DELETE -->

                                    @if(
                                        auth()->id() !==
                                        $user->id
                                    )

                                        <form
                                            action="{{ route(
                                                'pengguna.destroy',
                                                $user->id
                                            ) }}"
                                            method="POST"
                                            onsubmit="return confirm(
                                                'Yakin ingin menghapus pengguna ini?'
                                            )"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="inline-flex
                                                       items-center
                                                       px-3 py-2
                                                       rounded-lg
                                                       text-xs
                                                       font-medium
                                                       text-red-400
                                                       bg-red-500/10
                                                       hover:bg-red-500/20
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
                                                           A2 2 0
                                                           0116.138 21H7.862
                                                           a2 2 0
                                                           01-1.995-1.858L5
                                                           7m5 4v6m4-6v6
                                                           M9 7V4a1 1 0
                                                           011-1h4a1 1 0
                                                           011 1v3
                                                           M4 7h16"
                                                    />

                                                </svg>

                                                Hapus

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-12
                                       text-center"
                            >

                                <div
                                    class="flex
                                           flex-col
                                           items-center"
                                >

                                    <div
                                        class="flex
                                               items-center
                                               justify-center
                                               w-14 h-14
                                               mb-4
                                               rounded-full
                                               bg-[#111B36]"
                                    >

                                        <svg
                                            class="w-7 h-7
                                                   text-gray-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17 20h5v-2a4 4 0
                                                   00-4-4h-1
                                                   M9 20H4v-2a4 4 0
                                                   014-4h1
                                                   M12 12a4 4 0
                                                   100-8 4 4 0
                                                   000 8
                                                   M16 3.13a4 4 0
                                                   010 7.75
                                                   M8 3.13a4 4 0
                                                   000 7.75"
                                            />

                                        </svg>

                                    </div>


                                    <p
                                        class="text-gray-300
                                               font-medium"
                                    >
                                        Belum ada pengguna
                                    </p>


                                    <p
                                        class="mt-1
                                               text-sm
                                               text-gray-500"
                                    >
                                        Silakan tambahkan pengguna baru.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection