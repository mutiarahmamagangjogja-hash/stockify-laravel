<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Stockify Admin')
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

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

    $appSetting = \App\Models\Setting::first();

@endphp


<!-- ===================================================== -->
<!-- SIDEBAR -->
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
            href="{{ route('dashboard') }}"
            class="flex items-center"
        >

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
                            d="
                                M4 7l8-4 8 4-8 4-8-4z
                                M4 7v10l8 4 8-4V7
                                M12 11v10
                            "
                        />

                    </svg>

                @endif

            </div>


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
                    ADMIN SYSTEM
                </p>

            </div>

        </a>

    </div>



    <!-- ================================================= -->
    <!-- MENU -->
    <!-- ================================================= -->

    <div
        class="h-[calc(100vh-80px)]
               px-3 py-5
               overflow-y-auto"
    >

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
            href="{{ route('dashboard') }}"
            class="flex items-center
                   px-3 py-3 mb-2
                   rounded-lg

                   {{ request()->routeIs('dashboard')
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
                    d="
                        M3 12l9-9 9 9
                        M5 10v10h14V10
                        M9 20v-6h6v6
                    "
                />

            </svg>


            <span class="ml-3 font-medium">
                Dashboard
            </span>

        </a>



        <!-- ================================================= -->
        <!-- PRODUK -->
        <!-- ================================================= -->

        <div class="mb-2">

            <button
                type="button"
                onclick="toggleMenu('produkMenu','produkArrow')"
                class="flex items-center w-full
                       px-3 py-3
                       text-gray-300
                       rounded-lg
                       hover:bg-[#252B3A]
                       hover:text-white"
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
                        d="
                            M20 7l-8-4-8 4
                            m16 0l-8 4m8-4v10l-8 4
                            m0-10L4 7m8 4v10M4 7v10l8 4
                        "
                    />

                </svg>


                <span class="flex-1 ml-3 text-left">
                    Produk
                </span>


                <svg
                    id="produkArrow"
                    class="w-4 h-4 transition-transform
                           {{
                               request()->routeIs('produk.*')
                               || request()->routeIs('atribut.*')
                                   ? 'rotate-180'
                                   : ''
                           }}"
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


            <div
                id="produkMenu"
                class="
                    {{
                        request()->routeIs('produk.*')
                        || request()->routeIs('atribut.*')
                            ? ''
                            : 'hidden'
                    }}
                    mt-1 ml-5 space-y-1
                "
            >

                <a
                    href="{{ route('produk.index') }}"
                    class="
                        block px-4 py-2
                        text-sm rounded-lg

                        {{
                            request()->routeIs('produk.index')
                                ? 'text-white bg-[#252B3A]'
                                : 'text-gray-400 hover:bg-[#252B3A] hover:text-white'
                        }}
                    "
                >
                    Data Produk
                </a>


                <a
                    href="{{ route('atribut.index') }}"
                    class="
                        block px-4 py-2
                        text-sm rounded-lg

                        {{
                            request()->routeIs('atribut.*')
                                ? 'text-white bg-[#252B3A]'
                                : 'text-gray-400 hover:bg-[#252B3A] hover:text-white'
                        }}
                    "
                >
                    Atribut Produk
                </a>


                <a
                    href="{{ route('produk.import-export') }}"
                    class="
                        block px-4 py-2
                        text-sm rounded-lg

                        {{
                            request()->routeIs('produk.import-export')
                                ? 'text-white bg-[#252B3A]'
                                : 'text-gray-400 hover:bg-[#252B3A] hover:text-white'
                        }}
                    "
                >
                    Import / Export
                </a>

            </div>

        </div>



       <!-- ================================================= -->
<!-- STOK -->
<!-- ================================================= -->

<div class="mb-2">

    <button
        type="button"
        onclick="toggleMenu('stokMenu','stokArrow')"
        class="
            flex items-center w-full
            px-3 py-3
            text-gray-300
            rounded-lg
            hover:bg-[#252B3A]
            hover:text-white
        "
    >

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
                d="
                    M9 5H7a2 2 0 00-2 2v12
                    a2 2 0 002 2h10a2 2 0
                    002-2V7a2 2 0
                    00-2-2h-2
                    M9 5a3 3 0 006 0
                    M9 5h6
                "
            />

        </svg>


        <span class="flex-1 ml-3 text-left">
            Stok
        </span>


        <svg
            id="stokArrow"
            class="
                w-4 h-4 transition-transform

                {{
                    request()->is('stok/*')
                        ? 'rotate-180'
                        : ''
                }}
            "
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


    <div
        id="stokMenu"
        class="
            {{
                request()->is('stok/*')
                    ? ''
                    : 'hidden'
            }}
            mt-1 ml-5 space-y-1
        "
    >

        <!-- STOK MASUK -->

        <a
            href="{{ url('/stok/masuk') }}"
            class="
                block px-4 py-2
                text-sm rounded-lg

                {{
                    request()->is('stok/masuk')
                        ? 'text-white bg-[#252B3A]'
                        : 'text-gray-400 hover:bg-[#252B3A] hover:text-white'
                }}
            "
        >
            Stok Masuk
        </a>


        <!-- STOK KELUAR -->

        <a
            href="{{ url('/stok/keluar') }}"
            class="
                block px-4 py-2
                text-sm rounded-lg

                {{
                    request()->is('stok/keluar')
                        ? 'text-white bg-[#252B3A]'
                        : 'text-gray-400 hover:bg-[#252B3A] hover:text-white'
                }}
            "
        >
            Stok Keluar
        </a>


        <!-- RIWAYAT TRANSAKSI -->

        <a
            href="{{ url('/stok/riwayat') }}"
            class="
                block px-4 py-2
                text-sm rounded-lg

                {{
                    request()->is('stok/riwayat')
                        ? 'text-white bg-[#252B3A]'
                        : 'text-gray-400 hover:bg-[#252B3A] hover:text-white'
                }}
            "
        >
            Riwayat Transaksi
        </a>


        <!-- STOCK OPNAME -->

        <a
            href="{{ url('/stok/opname') }}"
            class="
                block px-4 py-2
                text-sm rounded-lg

                {{
                    request()->is('stok/opname')
                        ? 'text-white bg-[#252B3A]'
                        : 'text-gray-400 hover:bg-[#252B3A] hover:text-white'
                }}
            "
        >
            Stock Opname
        </a>


        <!-- STOK MINIMUM -->

        <a
            href="{{ url('/stok/minimum') }}"
            class="
                block px-4 py-2
                text-sm rounded-lg

                {{
                    request()->is('stok/minimum')
                        ? 'text-white bg-[#252B3A]'
                        : 'text-gray-400 hover:bg-[#252B3A] hover:text-white'
                }}
            "
        >
            Stok Minimum
        </a>

    </div>

</div>


        <!-- ================================================= -->
        <!-- SUPPLIER -->
        <!-- ================================================= -->

        <a
            href="{{ route('supplier.index') }}"
            class="
                flex items-center
                px-3 py-3 mb-2
                rounded-lg

                {{
                    request()->routeIs('supplier.*')
                        ? 'text-white bg-[#252B3A]'
                        : 'text-gray-300 hover:bg-[#252B3A] hover:text-white'
                }}
            "
        >

            <span class="w-5 text-center">
                🏢
            </span>

            <span class="ml-3">
                Supplier
            </span>

        </a>



        <!-- ================================================= -->
        <!-- PENGGUNA -->
        <!-- ================================================= -->

        <a
            href="{{ route('pengguna.index') }}"
            class="
                flex items-center
                px-3 py-3 mb-2
                rounded-lg

                {{
                    request()->routeIs('pengguna.*')
                        ? 'text-white bg-[#252B3A]'
                        : 'text-gray-300 hover:bg-[#252B3A] hover:text-white'
                }}
            "
        >

            <span class="w-5 text-center">
                👥
            </span>

            <span class="ml-3">
                Pengguna
            </span>

        </a>



        <!-- ================================================= -->
        <!-- LAPORAN -->
        <!-- ================================================= -->

        <a
            href="{{ route('laporan.index') }}"
            class="
                flex items-center
                px-3 py-3 mb-2
                text-gray-300
                rounded-lg
                hover:bg-[#252B3A]
                hover:text-white
            "
        >

            <span class="w-5 text-center">
                📊
            </span>

            <span class="ml-3">
                Laporan
            </span>

        </a>



        <!-- ================================================= -->
        <!-- SISTEM -->
        <!-- ================================================= -->

        <div
            class="
                pt-5 mt-5
                border-t border-[#252B3A]
            "
        >

            <p
                class="
                    px-3 mb-3
                    text-xs font-semibold
                    tracking-wider
                    text-gray-500
                    uppercase
                "
            >
                Sistem
            </p>


            <a
                href="{{ route('pengaturan.index') }}"
                class="
                    flex items-center
                    px-3 py-3
                    text-gray-300
                    rounded-lg
                    hover:bg-[#252B3A]
                    hover:text-white
                "
            >

                <span class="w-5 text-center">
                    ⚙
                </span>

                <span class="ml-3">
                    Pengaturan
                </span>

            </a>

        </div>

    </div>

</aside>



<!-- ===================================================== -->
<!-- MAIN -->
<!-- ===================================================== -->

<div
    class="
        ml-64
        min-h-screen
        bg-[#0B132B]
    "
>


    <!-- ================================================= -->
    <!-- TOP NAVBAR -->
    <!-- ================================================= -->

    <nav
        class="
            sticky top-0 z-30
            bg-[#111B36]
            border-b border-[#252B3A]
        "
    >

        <div
            class="
                flex items-center
                justify-between
                px-6 py-4
            "
        >

            <!-- PAGE TITLE -->

            <div>

                <h1
                    class="
                        text-xl
                        font-semibold
                        text-white
                    "
                >
                    @yield(
                        'page-title',
                        'Dashboard'
                    )
                </h1>


                <p
                    class="
                        text-sm
                        text-gray-400
                    "
                >
                    @yield(
                        'page-description',
                        'Sistem manajemen persediaan Stockify'
                    )
                </p>

            </div>



            <!-- ================================================= -->
            <!-- USER DROPDOWN -->
            <!-- ================================================= -->

            <div class="relative">

                <button
                    type="button"
                    onclick="toggleUserMenu()"
                    class="
                        flex
                        items-center
                        focus:outline-none
                    "
                >

                    <div
                        class="
                            mr-3
                            text-right
                        "
                    >

                        <p
                            class="
                                text-sm
                                font-semibold
                                text-white
                            "
                        >
                            Administrator
                        </p>


                        <p
                            class="
                                text-xs
                                text-gray-400
                            "
                        >
                            Admin
                        </p>

                    </div>


                    <div
                        class="
                            flex items-center
                            justify-center
                            w-10 h-10
                            font-semibold
                            text-white
                            bg-[#252B3A]
                            rounded-full
                            hover:bg-[#2D3445]
                            transition
                        "
                    >
                        A
                    </div>

                </button>


                <!-- DROPDOWN -->

                <div
                    id="userMenu"
                    class="
                        hidden
                        absolute
                        right-0
                        mt-3
                        w-44
                        bg-[#252B3A]
                        border
                        border-[#3A4254]
                        rounded-lg
                        shadow-xl
                        overflow-hidden
                    "
                >

                    <div
                        class="
                            px-4 py-3
                            border-b
                            border-[#3A4254]
                        "
                    >

                        <p
                            class="
                                text-sm
                                font-semibold
                                text-white
                            "
                        >
                            Administrator
                        </p>

                        <p
                            class="
                                text-xs
                                text-gray-400
                                mt-1
                            "
                        >
                            Admin
                        </p>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="
                                flex
                                items-center
                                w-full
                                px-4
                                py-3
                                text-sm
                                text-gray-300
                                hover:bg-[#2D3445]
                                hover:text-white
                                transition
                            "
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
                                    d="
                                        M17 16l4-4m0 0l-4-4m4 4H7
                                        M7 4H5a2 2 0 00-2 2v12
                                        a2 2 0 002 2h2
                                    "
                                />

                            </svg>

                            Logout

                        </button>

                    </form>

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

    arrow.classList.toggle('rotate-180');
}



function toggleUserMenu()
{
    const menu =
        document.getElementById('userMenu');

    if (!menu) {
        return;
    }

    menu.classList.toggle('hidden');
}



document.addEventListener(
    'click',
    function(event)
    {

        const menu =
            document.getElementById('userMenu');

        const button =
            event.target.closest(
                'button[onclick="toggleUserMenu()"]'
            );


        if (
            menu &&
            !menu.contains(event.target) &&
            !button
        ) {

            menu.classList.add('hidden');

        }

    }
);

</script>


@yield('scripts')


</body>

</html>