@extends('layouts.app')

@section('title', 'Dashboard - Stockify')

@section('page-title', 'Dashboard')

@section('page-description', 'Ringkasan persediaan Stockify')


@section('content')


<!-- ===================================================== -->
<!-- HEADER DASHBOARD -->
<!-- ===================================================== -->

<div class="mb-6">

    <h2 class="text-2xl font-bold text-white">
        Dashboard
    </h2>

    <p class="mt-1 text-sm text-gray-400">
        Pantau persediaan dan aktivitas Stockify.
    </p>

</div>


<!-- ===================================================== -->
<!-- 4 CARDS -->
<!-- ===================================================== -->

<div class="grid grid-cols-4 gap-4 mb-6">


    <!-- ================================================= -->
    <!-- TOTAL PRODUK -->
    <!-- ================================================= -->

    <div
        class="p-5
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               shadow-sm"
    >

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-400">
                    Total Produk
                </p>

                <h3
                    id="totalProduk"
                    class="mt-2 text-3xl font-bold text-white"
                >
                    {{ $totalProduk }}
                </h3>

            </div>


            <div
                class="flex items-center justify-center
                       w-12 h-12
                       text-xl
                       bg-[#2D3445]
                       rounded-lg"
            >
                📦
            </div>

        </div>


        <p class="mt-3 text-xs text-gray-400">
            Produk terdaftar
        </p>

    </div>


    <!-- ================================================= -->
    <!-- STOK MASUK -->
    <!-- ================================================= -->

    <div
        class="p-5
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               shadow-sm"
    >

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-400">
                    Stok Masuk
                </p>

                <h3
                    id="totalStokMasuk"
                    class="mt-2 text-3xl font-bold text-white"
                >
                    {{ $totalStokMasuk }}
                </h3>

            </div>


            <div
                class="flex items-center justify-center
                       w-12 h-12
                       text-xl
                       bg-[#2D3445]
                       rounded-lg"
            >
                ↓
            </div>

        </div>


        <p class="mt-3 text-xs text-green-400">
            Total transaksi stok masuk
        </p>

    </div>


    <!-- ================================================= -->
    <!-- STOK KELUAR -->
    <!-- ================================================= -->

    <div
        class="p-5
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               shadow-sm"
    >

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-400">
                    Stok Keluar
                </p>

                <h3
                    id="totalStokKeluar"
                    class="mt-2 text-3xl font-bold text-white"
                >
                    {{ $totalStokKeluar }}
                </h3>

            </div>


            <div
                class="flex items-center justify-center
                       w-12 h-12
                       text-xl
                       bg-[#2D3445]
                       rounded-lg"
            >
                ↑
            </div>

        </div>


        <p class="mt-3 text-xs text-red-400">
            Total transaksi stok keluar
        </p>

    </div>


    <!-- ================================================= -->
    <!-- STOK MINIMUM -->
    <!-- ================================================= -->

    <div
        class="p-5
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               shadow-sm"
    >

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-400">
                    Produk Stok Minimum
                </p>

                <h3
                    id="stokMenipis"
                    class="mt-2 text-3xl font-bold text-white"
                >
                    {{ $stokMenipis }}
                </h3>

            </div>


            <div
                class="flex items-center justify-center
                       w-12 h-12
                       text-xl
                       bg-[#2D3445]
                       rounded-lg"
            >
                ⚠
            </div>

        </div>


        <p class="mt-3 text-xs text-red-400">
            Perlu diperhatikan
        </p>

    </div>

</div>


<!-- ===================================================== -->
<!-- CHART + AKTIVITAS -->
<!-- ===================================================== -->

<div class="grid grid-cols-3 gap-6 mb-6">


    <!-- ================================================= -->
    <!-- CHART -->
    <!-- ================================================= -->

    <div
        class="col-span-2
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               shadow-sm"
    >

        <div
            class="flex items-center justify-between
                   p-5
                   border-b border-[#3A4254]"
        >

            <div>

                <h3 class="text-lg font-semibold text-white">
                    Pergerakan Stok
                </h3>

                <p class="text-sm text-gray-400">
                    Statistik stok masuk dan keluar
                </p>

            </div>


            <!-- FILTER GRAFIK -->

            <select
                id="chartPeriod"
                class="px-3 py-2
                       text-sm
                       text-white
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg
                       focus:outline-none"
            >

                <option
                    value="7"
                    class="bg-[#252B3A]"
                >
                    7 Hari
                </option>

                <option
                    value="30"
                    class="bg-[#252B3A]"
                >
                    30 Hari
                </option>

                <option
                    value="12"
                    class="bg-[#252B3A]"
                >
                    12 Bulan
                </option>

            </select>

        </div>


        <div class="p-5">

            <div id="stockChart"></div>

        </div>

    </div>


    <!-- ================================================= -->
    <!-- AKTIVITAS PENGGUNA -->
    <!-- ================================================= -->

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               shadow-sm"
    >

        <div
            class="p-5
                   border-b border-[#3A4254]"
        >

            <h3 class="text-lg font-semibold text-white">
                Aktivitas Pengguna
            </h3>

            <p class="text-sm text-gray-400">
                Aktivitas terbaru
            </p>

        </div>


        <div class="p-5">

            @forelse($activities as $activity)

                <div
                    class="flex gap-3 mb-6
                           last:mb-0"
                >

                    <!-- AVATAR -->

                    <div
                        class="flex items-center justify-center
                               flex-shrink-0
                               w-9 h-9
                               text-sm font-semibold
                               text-white
                               bg-[#2D3445]
                               rounded-full"
                    >

                        {{
                            strtoupper(
                                substr(
                                    $activity->user->name ?? 'A',
                                    0,
                                    1
                                )
                            )
                        }}

                    </div>


                    <!-- DETAIL AKTIVITAS -->

                    <div class="min-w-0">

                        <p
                            class="text-sm
                                   font-medium
                                   text-white"
                        >

                            <span class="font-semibold">

                                {{ $activity->user->name ?? 'Administrator' }}

                            </span>

                            {{ $activity->action }}

                        </p>


                        @if($activity->description)

                            <p
                                class="text-xs
                                       text-gray-400"
                            >

                                {{ $activity->description }}

                            </p>

                        @endif


                        <p
                            class="mt-1
                                   text-xs
                                   text-gray-500"
                        >

                            {{ $activity->created_at->diffForHumans() }}

                        </p>

                    </div>

                </div>

            @empty

                <div
                    class="py-8
                           text-center"
                >

                    <div
                        class="flex items-center
                               justify-center
                               w-10 h-10
                               mx-auto mb-3
                               text-gray-400
                               bg-[#2D3445]
                               rounded-full"
                    >
                        ⓘ
                    </div>

                    <p
                        class="text-sm
                               text-gray-500"
                    >
                        Belum ada aktivitas pengguna.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>


<!-- ===================================================== -->
<!-- PRODUK STOK RENDAH -->
<!-- ===================================================== -->

<div
    class="w-full
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           shadow-sm
           mb-6"
>


    <!-- HEADER -->

    <div
        class="flex items-center justify-between
               p-5
               border-b border-[#3A4254]"
    >

        <div>

            <h3 class="text-lg font-semibold text-white">
                Produk dengan Stok Rendah
            </h3>

            <p class="text-sm text-gray-400">
                Produk yang membutuhkan pengisian stok
            </p>

        </div>


        <a
            href="{{ route('produk.index') }}"
            class="px-4 py-2
                   text-sm font-medium
                   text-white
                   bg-[#111B36]
                   border border-[#3A4254]
                   rounded-lg
                   hover:bg-[#0B132B]"
        >
            Lihat Semua
        </a>

    </div>


    <!-- TABLE -->

    <div class="w-full overflow-x-auto">

        <table class="w-full text-sm text-left">

            <thead
                class="text-xs
                       text-gray-400
                       uppercase
                       bg-[#2D3445]"
            >

                <tr>

                    <th class="px-6 py-3">
                        Produk
                    </th>

                    <th class="px-6 py-3">
                        Kategori
                    </th>

                    <th class="px-6 py-3">
                        Stok
                    </th>

                    <th class="px-6 py-3">
                        Minimum
                    </th>

                    <th class="px-6 py-3">
                        Status
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($lowStockProducts as $product)

                    <tr
                        class="border-b
                               border-[#3A4254]
                               hover:bg-[#2D3445]"
                    >

                        <td
                            class="px-6 py-4
                                   font-medium
                                   text-white"
                        >
                            {{ $product->name }}
                        </td>


                        <td class="px-6 py-4 text-gray-400">
                            {{ $product->category->name ?? '-' }}
                        </td>


                        <td
                            class="px-6 py-4
                                   font-semibold
                                   text-red-400"
                        >
                            {{ $product->stock }}
                        </td>


                        <td class="px-6 py-4 text-gray-300">
                            {{ $product->minimum_stock }}
                        </td>


                        <td class="px-6 py-4">

                            @if($product->stock < $product->minimum_stock)

                                <span
                                    class="px-2.5 py-1
                                           text-xs font-medium
                                           text-red-300
                                           bg-red-900/40
                                           rounded-full"
                                >
                                    Stok Rendah
                                </span>

                            @else

                                <span
                                    class="px-2.5 py-1
                                           text-xs font-medium
                                           text-yellow-300
                                           bg-yellow-900/40
                                           rounded-full"
                                >
                                    Hampir Habis
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="px-6 py-10
                                   text-center
                                   text-gray-400"
                        >
                            Belum ada produk dengan stok minimum.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


@endsection


<!-- ===================================================== -->
<!-- JAVASCRIPT DASHBOARD -->
<!-- ===================================================== -->

@section('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | DATA GRAFIK DARI DATABASE
        |--------------------------------------------------------------------------
        */

        const chartData = {

            seven: {
                labels: @json($chart7Labels),
                masuk: @json($chart7Masuk),
                keluar: @json($chart7Keluar)
            },

            thirty: {
                labels: @json($chart30Labels),
                masuk: @json($chart30Masuk),
                keluar: @json($chart30Keluar)
            },

            twelve: {
                labels: @json($chart12Labels),
                masuk: @json($chart12Masuk),
                keluar: @json($chart12Keluar)
            }

        };


        /*
        |--------------------------------------------------------------------------
        | ELEMENT GRAFIK
        |--------------------------------------------------------------------------
        */

        const stockChartElement =
            document.querySelector(
                '#stockChart'
            );


        const chartPeriod =
            document.querySelector(
                '#chartPeriod'
            );


        /*
        |--------------------------------------------------------------------------
        | CEK APEXCHARTS
        |--------------------------------------------------------------------------
        */

        if (
            !stockChartElement ||
            typeof ApexCharts === 'undefined'
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | DATA AWAL
        |--------------------------------------------------------------------------
        */

        let currentData =
            chartData.seven;


        /*
        |--------------------------------------------------------------------------
        | OPTIONS APEXCHARTS
        |--------------------------------------------------------------------------
        */

        const stockChartOptions = {

            chart: {

                type: 'line',

                height: 330,

                toolbar: {
                    show: false
                },

                background: 'transparent'

            },


            series: [

                {
                    name: 'Stok Masuk',

                    data: currentData.masuk
                },

                {
                    name: 'Stok Keluar',

                    data: currentData.keluar
                }

            ],


            xaxis: {

                categories:
                    currentData.labels,

                labels: {

                    style: {

                        colors:
                            '#9CA3AF'

                    }

                }

            },


            yaxis: {

                labels: {

                    style: {

                        colors:
                            '#9CA3AF'

                    }

                }

            },


            stroke: {

                curve: 'smooth',

                width: 3

            },


            dataLabels: {

                enabled: false

            },


            grid: {

                borderColor:
                    '#3A4254',

                strokeDashArray: 4

            },


            legend: {

                position: 'top',

                horizontalAlign:
                    'right',

                labels: {

                    colors:
                        '#D1D5DB'

                }

            },


            tooltip: {

                theme: 'dark',

                shared: true,

                intersect: false

            },


            markers: {

                size: 4

            },


            noData: {

                text:
                    'Belum ada data'

            }

        };


        /*
        |--------------------------------------------------------------------------
        | BUAT GRAFIK
        |--------------------------------------------------------------------------
        */

        const stockChart =
            new ApexCharts(
                stockChartElement,
                stockChartOptions
            );


        stockChart.render();

        /*
        |--------------------------------------------------------------------------
        | GANTI PERIODE GRAFIK
        |--------------------------------------------------------------------------
        */

        if (chartPeriod) {

            chartPeriod.addEventListener(
                'change',
                function () {

                    const value =
                        this.value;


                    let selectedData;


                    /*
                    |--------------------------------------------------------------
                    | 7 HARI
                    |--------------------------------------------------------------
                    */

                    if (value === '7') {

                        selectedData =
                            chartData.seven;

                    }


                    /*
                    |--------------------------------------------------------------
                    | 30 HARI
                    |--------------------------------------------------------------
                    */

                    else if (value === '30') {

                        selectedData =
                            chartData.thirty;

                    }


                    /*
                    |--------------------------------------------------------------
                    | 12 BULAN
                    |--------------------------------------------------------------
                    */

                    else {

                        selectedData =
                            chartData.twelve;

                    }


                    /*
                    |--------------------------------------------------------------
                    | UPDATE GRAFIK
                    |--------------------------------------------------------------
                    */

                    stockChart.updateOptions({

                        xaxis: {

                            categories:
                                selectedData.labels

                        }

                    });


                    stockChart.updateSeries([

                        {
                            name: 'Stok Masuk',

                            data:
                                selectedData.masuk
                        },

                        {
                            name: 'Stok Keluar',

                            data:
                                selectedData.keluar
                        }

                    ]);

                }
            );

        }

    }

);

</script>

@endsection