<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Staff Gudang - Stockify')
    </title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>

        tailwind.config = {

            theme: {

                extend: {

                    colors: {

                        navy: '#0B132B',
                        navy2: '#111B36',
                        card: '#252B3A',
                        card2: '#2D3445',
                        borderdark: '#3A4254'

                    }

                }

            }

        }

    </script>

    @yield('head')

</head>


<body class="bg-[#0B132B] text-white">


@php

    /*
    |--------------------------------------------------------------------------
    | PENGATURAN APLIKASI
    |--------------------------------------------------------------------------
    */

    $appSetting = \App\Models\Setting::first();

@endphp


<!-- ===================================================== -->
<!-- SIDEBAR STAFF GUDANG -->
<!-- ===================================================== -->

<aside
    class="fixed top-0 left-0 z-40
           w-64 h-screen
           bg-[#0B132B]
           border-r border-[#252B3A]"
>


    <!-- ================================================= -->
    <!-- LOGO -->
    <!-- ================================================= -->

    <div
        class="flex items-center h-20 px-6
               border-b border-[#252B3A]"
    >

        <a
            href="{{ route('staff-gudang.dashboard') }}"
            class="flex items-center"
        >

            <!-- LOGO -->

            <div
                class="flex items-center justify-center
                       w-10 h-10 mr-3
                       bg-[#252B3A]
                       rounded-lg"
            >

                @if($appSetting && $appSetting->app_logo)

                    <img
                        src="{{ asset('storage/' . $appSetting->app_logo) }}"
                        alt="{{ $appSetting->app_name ?? 'Logo' }}"
                        class="w-8 h-8 object-contain"
                    >

                @else

                    <svg
                        class="w-6 h-6 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 7l8-4 8 4-8 4-8-4z
                               M4 7v10l8 4 8-4V7
                               M12 11v10"
                        />

                    </svg>

                @endif

            </div>


            <!-- NAMA APLIKASI -->

            <div>

                <h1
                    class="text-xl font-bold
                           tracking-wide text-white"
                >
                    {{ $appSetting->app_name ?? 'STOCKIFY' }}
                </h1>

                <p
                    class="text-[9px]
                           tracking-[0.2em]
                           text-gray-400"
                >
                    STAFF GUDANG
                </p>

            </div>

        </a>

    </div>


    <!-- ================================================= -->
    <!-- MENU SIDEBAR -->
    <!-- ================================================= -->

    <div
        class="h-[calc(100vh-80px)]
               px-3 py-5
               overflow-y-auto"
    >


        <!-- ================================================= -->
        <!-- LABEL MENU -->
        <!-- ================================================= -->

        <p
            class="px-3 mb-3
                   text-xs font-semibold
                   tracking-wider
                   text-gray-500
                   uppercase"
        >
            Menu Utama
        </p>


        <!-- ================================================= -->
        <!-- DASHBOARD -->
        <!-- ================================================= -->

        <a
            href="{{ route('staff-gudang.dashboard') }}"
            class="flex items-center
                   px-3 py-3 mb-2
                   rounded-lg

                   {{ request()->routeIs('staff-gudang.dashboard')
                        ? 'text-white bg-[#252B3A]'
                        : 'text-gray-300 hover:bg-[#252B3A] hover:text-white' }}"
        >

            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 12l9-9 9 9
                       M5 10v10h14V10
                       M9 20v-6h6v6"
                />

            </svg>


            <span class="ml-3 font-medium">
                Dashboard
            </span>

        </a>


        <!-- ================================================= -->
        <!-- STOK -->
        <!-- ================================================= -->

        <div class="mb-2">


            <button
                type="button"
                onclick="toggleMenu('stokMenu','stokArrow')"
                class="flex items-center w-full
                       px-3 py-3
                       text-gray-300
                       rounded-lg
                       hover:bg-[#252B3A]
                       hover:text-white"
            >


                <!-- ICON STOK -->

                <svg
                    class="w-5 h-5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M20 7l-8-4-8 4
                           m16 0l-8 4m8-4v10l-8 4
                           m0-10L4 7m8 4v10M4 7v10l8 4"
                    />

                </svg>


                <span class="flex-1 ml-3 text-left">
                    Stok
                </span>


                <!-- ARROW -->

                <svg
                    id="stokArrow"
                    class="w-4 h-4 transition-transform

                        {{ request()->routeIs('staff-gudang.stok.*')
                            ? 'rotate-180'
                            : '' }}"

                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 9l6 6 6-6"
                    />

                </svg>

            </button>


            <!-- ================================================= -->
            <!-- SUBMENU STOK -->
            <!-- ================================================= -->

            <div
                id="stokMenu"

                class="{{
                    request()->routeIs('staff-gudang.stok.*')
                        ? ''
                        : 'hidden'
                }}

                mt-1 ml-5 space-y-1"
            >


                <!-- BARANG MASUK -->

                <a
                    href="{{ route('staff-gudang.stok.masuk') }}"
                    class="block px-4 py-2
                           text-sm rounded-lg

                           {{ request()->routeIs('staff-gudang.stok.masuk*')
                                ? 'text-white bg-[#252B3A]'
                                : 'text-gray-400 hover:bg-[#252B3A] hover:text-white' }}"
                >

                    Barang Masuk

                </a>


                <!-- BARANG KELUAR -->

                <a
                    href="{{ route('staff-gudang.stok.keluar') }}"
                    class="block px-4 py-2
                           text-sm rounded-lg

                           {{ request()->routeIs('staff-gudang.stok.keluar*')
                                ? 'text-white bg-[#252B3A]'
                                : 'text-gray-400 hover:bg-[#252B3A] hover:text-white' }}"
                >

                    Barang Keluar

                </a>


                <!-- STOCK OPNAME -->

                <a
                    href="{{ route('staff-gudang.stok.opname') }}"
                    class="block px-4 py-2
                           text-sm rounded-lg

                           {{ request()->routeIs('staff-gudang.stok.opname')
                                ? 'text-white bg-[#252B3A]'
                                : 'text-gray-400 hover:bg-[#252B3A] hover:text-white' }}"
                >

                    Stock Opname

                </a>


                <!-- RIWAYAT -->

                <a
                    href="{{ route('staff-gudang.stok.riwayat') }}"
                    class="block px-4 py-2
                           text-sm rounded-lg

                           {{ request()->routeIs('staff-gudang.stok.riwayat')
                                ? 'text-white bg-[#252B3A]'
                                : 'text-gray-400 hover:bg-[#252B3A] hover:text-white' }}"
                >

                    Riwayat Transaksi

                </a>


            </div>

        </div>


    </div>

</aside>



<!-- ===================================================== -->
<!-- MAIN CONTENT -->
<!-- ===================================================== -->

<div class="ml-64 min-h-screen bg-[#0B132B]">


    <!-- ================================================= -->
    <!-- TOP NAVBAR -->
    <!-- ================================================= -->

    <nav
        class="sticky top-0 z-30
               bg-[#111B36]
               border-b border-[#252B3A]"
    >

        <div
            class="flex items-center
                   justify-between
                   px-6 py-4"
        >


            <!-- PAGE TITLE -->

            <div>

                <h1
                    class="text-xl font-semibold text-white"
                >
                    @yield(
                        'page-title',
                        'Dashboard'
                    )
                </h1>


                <p
                    class="text-sm text-gray-400"
                >
                    @yield(
                        'page-description',
                        'Sistem manajemen persediaan Stockify'
                    )
                </p>

            </div>


            <!-- USER -->

            <div class="flex items-center">


                <div class="mr-3 text-right">

                    <p
                        class="text-sm
                               font-semibold
                               text-white"
                    >

                        {{ auth()->user()->name ?? 'Staff Gudang' }}

                    </p>


                    <p
                        class="text-xs
                               text-gray-400"
                    >
                        Staff Gudang
                    </p>

                </div>


                <!-- AVATAR -->

                <div
                    class="flex items-center
                           justify-center
                           w-10 h-10
                           font-semibold
                           text-white
                           bg-[#252B3A]
                           rounded-full"
                >

                    {{
                        strtoupper(
                            substr(
                                auth()->user()->name ?? 'S',
                                0,
                                1
                            )
                        )
                    }}

                </div>

            </div>

        </div>

    </nav>



    <!-- ================================================= -->
    <!-- PAGE CONTENT -->
    <!-- ================================================= -->

    <main class="p-6">

        @yield('content')

    </main>

</div>



<!-- ===================================================== -->
<!-- JAVASCRIPT -->
<!-- ===================================================== -->

<script>

function toggleMenu(menuId, arrowId)
{

    const menu =
        document.getElementById(menuId);

    const arrow =
        document.getElementById(arrowId);


    if (!menu || !arrow) {

        return;

    }


    menu.classList.toggle('hidden');

    arrow.classList.toggle(
        'rotate-180'
    );

}

</script>


@yield('scripts')


</body>

</html>