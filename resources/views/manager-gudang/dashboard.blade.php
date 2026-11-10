@extends('layouts.manager-gudang')

@section('title', 'Dashboard Manager Gudang - Stockify')

@section('page-title', 'Dashboard')

@section('page-description', 'Sistem manajemen persediaan Stockify')


@section('content')

<!-- ===================================================== -->
<!-- 4 CARD STATISTIK -->
<!-- ===================================================== -->

<div class="grid grid-cols-4 gap-5 mb-6">


    <!-- ================================================= -->
    <!-- CARD 1 - STOK MENIPIS -->
    <!-- ================================================= -->

    <div
        class="
            bg-[#252B3A]
            border border-[#3A4254]
            rounded-lg
            shadow-sm
            p-5
        "
    >

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-400">
                    Stok Menipis
                </p>

                <h3
                    class="
                        mt-2
                        text-3xl
                        font-bold
                        text-white
                    "
                >
                    {{ $stokMenipis ?? 0 }}
                </h3>

                <p class="mt-1 text-xs text-gray-500">
                    Produk perlu diperiksa
                </p>

            </div>


            <div
                class="
                    flex
                    items-center
                    justify-center
                    w-11
                    h-11
                    rounded-lg
                    bg-[#2D3445]
                "
            >

                <svg
                    class="w-6 h-6 text-yellow-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="
                            M12 9v4
                            m0 4h.01
                            M10.29 3.86l-7.82 14
                            a2 2 0 001.74 3h15.58
                            a2 2 0 001.74-3l-7.82-14
                            a2 2 0 00-3.42 0z
                        "
                    />

                </svg>

            </div>

        </div>

    </div>



    <!-- ================================================= -->
    <!-- CARD 2 - BARANG MASUK -->
    <!-- ================================================= -->

    <div
        class="
            bg-[#252B3A]
            border border-[#3A4254]
            rounded-lg
            shadow-sm
            p-5
        "
    >

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-400">
                    Barang Masuk Hari Ini
                </p>

                <h3
                    class="
                        mt-2
                        text-3xl
                        font-bold
                        text-white
                    "
                >
                    {{ $barangMasukHariIni ?? 0 }}
                </h3>

                <p class="mt-1 text-xs text-gray-500">
                    Barang diterima hari ini
                </p>

            </div>


            <div
                class="
                    flex
                    items-center
                    justify-center
                    w-11
                    h-11
                    rounded-lg
                    bg-[#2D3445]
                "
            >

                <svg
                    class="w-6 h-6 text-blue-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="
                            M12 19V5
                            m0 0l-5 5
                            m5-5l5 5
                        "
                    />

                </svg>

            </div>

        </div>

    </div>



    <!-- ================================================= -->
    <!-- CARD 3 - BARANG KELUAR -->
    <!-- ================================================= -->

    <div
        class="
            bg-[#252B3A]
            border border-[#3A4254]
            rounded-lg
            shadow-sm
            p-5
        "
    >

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-400">
                    Barang Keluar Hari Ini
                </p>

                <h3
                    class="
                        mt-2
                        text-3xl
                        font-bold
                        text-white
                    "
                >
                    {{ $barangKeluarHariIni ?? 0 }}
                </h3>

                <p class="mt-1 text-xs text-gray-500">
                    Barang keluar hari ini
                </p>

            </div>


            <div
                class="
                    flex
                    items-center
                    justify-center
                    w-11
                    h-11
                    rounded-lg
                    bg-[#2D3445]
                "
            >

                <svg
                    class="w-6 h-6 text-green-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="
                            M12 5v14
                            m0 0l-5-5
                            m5 5l5-5
                        "
                    />

                </svg>

            </div>

        </div>

    </div>



    <!-- ================================================= -->
    <!-- CARD 4 - TOTAL STOK -->
    <!-- ================================================= -->

    <div
        class="
            bg-[#252B3A]
            border border-[#3A4254]
            rounded-lg
            shadow-sm
            p-5
        "
    >

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-400">
                    Total Stok Barang
                </p>

                <h3
                    class="
                        mt-2
                        text-3xl
                        font-bold
                        text-white
                    "
                >
                    {{ $totalStok ?? 0 }}
                </h3>

                <p class="mt-1 text-xs text-gray-500">
                    Total seluruh stok
                </p>

            </div>


            <div
                class="
                    flex
                    items-center
                    justify-center
                    w-11
                    h-11
                    rounded-lg
                    bg-[#2D3445]
                "
            >

                <svg
                    class="w-6 h-6 text-purple-400"
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
                            m16 0l-8 4
                            m8-4v10l-8 4
                            m0-10L4 7
                            m8 4v10
                            M4 7v10l8 4
                        "
                    />

                </svg>

            </div>

        </div>

    </div>

</div>



<!-- ===================================================== -->
<!-- GRAFIK PERGERAKAN STOK -->
<!-- ===================================================== -->

<div
    class="
        bg-[#252B3A]
        border border-[#3A4254]
        rounded-lg
        shadow-sm
    "
>


    <!-- HEADER GRAFIK -->

    <div
        class="
            flex
            items-center
            justify-between
            p-5
            border-b
            border-[#3A4254]
        "
    >

        <div>

            <h3
                class="
                    text-lg
                    font-semibold
                    text-white
                "
            >
                Pergerakan Stok
            </h3>

            <p class="text-sm text-gray-400">
                Statistik barang masuk dan keluar
            </p>

        </div>


        <!-- FILTER GRAFIK -->

        <select
            id="chartPeriod"
            onchange="changeChartPeriod(this.value)"
            class="
                px-3
                py-2
                text-sm
                text-white
                bg-[#2D3445]
                border
                border-[#3A4254]
                rounded-lg
                focus:outline-none
            "
        >

            <option
                value="7"
                class="bg-[#252B3A]"
                {{ ($period ?? '7') === '7' ? 'selected' : '' }}
            >
                7 Hari
            </option>

            <option
                value="30"
                class="bg-[#252B3A]"
                {{ ($period ?? '7') === '30' ? 'selected' : '' }}
            >
                30 Hari
            </option>

            <option
                value="12"
                class="bg-[#252B3A]"
                {{ ($period ?? '7') === '12' ? 'selected' : '' }}
            >
                12 Bulan
            </option>

        </select>

    </div>


    <!-- AREA GRAFIK -->

    <div class="p-5">

        <div
            id="stockChart"
            class="w-full h-80"
        ></div>

    </div>

</div>


@endsection



<!-- ===================================================== -->
<!-- APEXCHART SCRIPT -->
<!-- ===================================================== -->

@section('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const chartElement =
            document.getElementById(
                'stockChart'
            );


        if (!chartElement) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | DATA DARI CONTROLLER
        |--------------------------------------------------------------------------
        */

        const chartLabels =
            @json($chartLabels ?? []);


        const chartMasuk =
            @json($chartMasuk ?? []);


        const chartKeluar =
            @json($chartKeluar ?? []);


        /*
        |--------------------------------------------------------------------------
        | APEXCHART
        |--------------------------------------------------------------------------
        */

        const options = {

            chart: {

                type: 'area',

                height: 320,

                toolbar: {
                    show: false
                },

                background: 'transparent'

            },


            series: [

                {
                    name: 'Barang Masuk',

                    data: chartMasuk

                },

                {
                    name: 'Barang Keluar',

                    data: chartKeluar

                }

            ],


            xaxis: {

                categories: chartLabels,

                labels: {

                    style: {

                        colors: '#9CA3AF'

                    }

                },

                axisBorder: {

                    color: '#3A4254'

                },

                axisTicks: {

                    color: '#3A4254'

                }

            },


            yaxis: {

                min: 0,

                labels: {

                    style: {

                        colors: '#9CA3AF'

                    }

                }

            },


            grid: {

                borderColor: '#3A4254',

                strokeDashArray: 5

            },


            colors: [

                '#2196F3',
                '#10B981'

            ],


            stroke: {

                curve: 'smooth',

                width: 2

            },


            fill: {

                type: 'gradient',

                gradient: {

                    opacityFrom: 0.25,

                    opacityTo: 0.03,

                    stops: [
                        0,
                        100
                    ]

                }

            },


            markers: {

                size: 4,

                hover: {

                    size: 6

                }

            },


            legend: {

                position: 'top',

                horizontalAlign: 'right',

                labels: {

                    colors: '#E5E7EB'

                }

            },


            dataLabels: {

                enabled: false

            },


            tooltip: {

                theme: 'dark'

            },


            noData: {

                text: 'Belum ada data'

            }

        };


        const stockChart =
            new ApexCharts(
                chartElement,
                options
            );


        stockChart.render();

    }

);


/*
|--------------------------------------------------------------------------
| GANTI PERIODE GRAFIK
|--------------------------------------------------------------------------
*/

function changeChartPeriod(period)
{
    const url =
        new URL(
            window.location.href
        );


    url.searchParams.set(
        'period',
        period
    );


    window.location.href =
        url.toString();
}


</script>

@endsection
