```blade
@extends('layouts.staff-gudang')


@section('title', 'Dashboard - Staff Gudang')


@section('page-title', 'Dashboard')


@section(
    'page-description',
    'Pantau tugas dan aktivitas stok gudang'
)


@section('content')


<!-- ===================================================== -->
<!-- 4 CARDS -->
<!-- ===================================================== -->

<div
    class="grid gap-4 mb-6 w-full"
    style="grid-template-columns: repeat(4, minmax(0, 1fr));"
>


    <!-- ================================================= -->
    <!-- BARANG MASUK -->
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
                    Barang Masuk
                </p>

                <h3
                    class="mt-2
                           text-3xl
                           font-bold
                           text-white"
                >
                    {{ $incomingPending }}
                </h3>

            </div>


            <div
                class="flex items-center
                       justify-center
                       w-12 h-12
                       text-xl
                       bg-[#2D3445]
                       rounded-lg"
            >
                ↓
            </div>

        </div>


        <p
            class="mt-3
                   text-xs
                   text-yellow-400"
        >
            Perlu diperiksa
        </p>

    </div>



    <!-- ================================================= -->
    <!-- BARANG KELUAR -->
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
                    Barang Keluar
                </p>

                <h3
                    class="mt-2
                           text-3xl
                           font-bold
                           text-white"
                >
                    {{ $outgoingPending }}
                </h3>

            </div>


            <div
                class="flex items-center
                       justify-center
                       w-12 h-12
                       text-xl
                       bg-[#2D3445]
                       rounded-lg"
            >
                ↑
            </div>

        </div>


        <p
            class="mt-3
                   text-xs
                   text-yellow-400"
        >
            Perlu disiapkan
        </p>

    </div>



    <!-- ================================================= -->
    <!-- TOTAL STOK -->
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
                    Total Stok
                </p>

                <h3
                    class="mt-2
                           text-3xl
                           font-bold
                           text-white"
                >
                    {{ number_format($totalStock) }}
                </h3>

            </div>


            <div
                class="flex items-center
                       justify-center
                       w-12 h-12
                       text-xl
                       bg-[#2D3445]
                       rounded-lg"
            >
                📦
            </div>

        </div>


        <p class="mt-3 text-xs text-gray-400">
            Seluruh stok tersedia
        </p>

    </div>



    <!-- ================================================= -->
    <!-- STOCK OPNAME -->
    <!-- ================================================= -->

    <a
        href="{{ route('staff-gudang.stok.opname') }}"
        class="block"
    >

        <div
            class="p-5
                   bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   shadow-sm
                   hover:bg-[#2D3445]
                   hover:border-blue-500
                   transition
                   cursor-pointer"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-400">
                        Stock Opname
                    </p>


                    <h3
                        class="mt-2
                               text-3xl
                               font-bold
                               text-white"
                    >
                        {{ \App\Models\StockOpname::count() }}
                    </h3>


                    <p
                        class="mt-3
                               text-xs
                               text-gray-400"
                    >
                        Total pemeriksaan stok
                    </p>

                </div>


                <div
                    class="flex items-center
                           justify-center
                           w-12 h-12
                           bg-blue-500/10
                           rounded-lg"
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
                            d="M9 5H7a2 2 0 00-2 2v12
                               a2 2 0 002 2h10a2 2 0
                               002-2V7a2 2 0 00-2-2h-2
                               M9 5a3 3 0 006 0
                               M9 5h6"
                        />

                    </svg>

                </div>

            </div>

        </div>

    </a>

</div>



<!-- ===================================================== -->
<!-- TUGAS + AKTIVITAS -->
<!-- ===================================================== -->

<div
    class="grid grid-cols-1
           lg:grid-cols-2
           gap-6
           mb-6"
>


    <!-- ================================================= -->
    <!-- TUGAS -->
    <!-- ================================================= -->

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               shadow-sm"
    >

        <div
            class="p-5
                   border-b
                   border-[#3A4254]"
        >

            <h3
                class="text-lg
                       font-semibold
                       text-white"
            >
                Tugas yang Perlu Diselesaikan
            </h3>

            <p class="text-sm text-gray-400">
                Pekerjaan gudang yang menunggu tindakan
            </p>

        </div>


        <div class="p-5">

            @forelse($tasks as $task)

                <a
                    href="{{ $task['route'] }}"
                    class="flex items-center
                           gap-4
                           p-3 mb-3
                           last:mb-0
                           rounded-lg
                           bg-[#2D3445]
                           hover:bg-[#3A4254]
                           transition"
                >

                    <div
                        class="flex items-center
                               justify-center
                               flex-shrink-0
                               w-10 h-10
                               bg-[#252B3A]
                               rounded-lg"
                    >

                        @if($task['type'] === 'incoming')

                            <span class="text-lg">
                                ↓
                            </span>

                        @else

                            <span class="text-lg">
                                ↑
                            </span>

                        @endif

                    </div>


                    <div class="flex-1 min-w-0">

                        <p
                            class="text-sm
                                   font-semibold
                                   text-white"
                        >
                            {{ $task['title'] }}
                        </p>


                        <p
                            class="mt-1
                                   text-xs
                                   text-gray-400"
                        >
                            {{ $task['description'] }}
                        </p>

                    </div>


                    <div
                        class="text-gray-500
                               text-lg"
                    >
                        →
                    </div>

                </a>

            @empty

                <div
                    class="py-10
                           text-center"
                >

                    <div
                        class="flex items-center
                               justify-center
                               w-12 h-12
                               mx-auto mb-3
                               bg-[#2D3445]
                               rounded-full"
                    >
                        ✓
                    </div>


                    <p
                        class="text-sm
                               text-gray-400"
                    >
                        Tidak ada tugas yang perlu
                        diselesaikan.
                    </p>

                </div>

            @endforelse

        </div>

    </div>



    <!-- ================================================= -->
    <!-- AKTIVITAS STOK -->
    <!-- ================================================= -->

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               shadow-sm"
    >

        <div
            class="p-5
                   border-b
                   border-[#3A4254]"
        >

            <h3
                class="text-lg
                       font-semibold
                       text-white"
            >
                Aktivitas Stok Terakhir
            </h3>


            <p class="text-sm text-gray-400">
                Perubahan stok terbaru
            </p>

        </div>


        <div class="p-5">

            @forelse($activities as $activity)

                <div
                    class="flex gap-3
                           mb-5
                           last:mb-0"
                >

                    <div
                        class="flex items-center
                               justify-center
                               flex-shrink-0
                               w-9 h-9
                               text-sm
                               font-semibold
                               text-white
                               bg-[#2D3445]
                               rounded-full"
                    >

                        {{
                            strtoupper(
                                substr(
                                    $activity['name'] ?? 'S',
                                    0,
                                    1
                                )
                            )
                        }}

                    </div>


                    <div class="min-w-0 flex-1">

                        <p
                            class="text-sm
                                   font-medium
                                   text-white"
                        >

                            <span class="font-semibold">
                                {{ $activity['name'] ?? 'Staff Gudang' }}
                            </span>

                            {{ $activity['action'] }}

                        </p>


                        @if(!empty($activity['description']))

                            <p
                                class="mt-1
                                       text-xs
                                       text-gray-400"
                            >
                                {{ $activity['description'] }}
                            </p>

                        @endif


                        <p
                            class="mt-1
                                   text-xs
                                   text-gray-500"
                        >
                            {{ $activity['created_at']->diffForHumans() }}
                        </p>

                    </div>

                </div>

            @empty

                <div
                    class="py-10
                           text-center"
                >

                    <div
                        class="flex items-center
                               justify-center
                               w-12 h-12
                               mx-auto mb-3
                               bg-[#2D3445]
                               rounded-full"
                    >
                        ⓘ
                    </div>


                    <p
                        class="text-sm
                               text-gray-500"
                    >
                        Belum ada aktivitas stok.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>



<!-- ===================================================== -->
<!-- RINGKASAN STOK HARI INI -->
<!-- ===================================================== -->

<div
    class="w-full
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           shadow-sm"
>


    <div
        class="p-5
               border-b
               border-[#3A4254]"
    >

        <h3
            class="text-lg
                   font-semibold
                   text-white"
        >
            Ringkasan Stok Hari Ini
        </h3>


        <p class="text-sm text-gray-400">
            Aktivitas penerimaan dan pengeluaran
            barang hari ini
        </p>

    </div>


    <div
        class="grid grid-cols-1
               md:grid-cols-3
               gap-4
               p-5"
    >


        <!-- BARANG MASUK -->

        <div
            class="p-4
                   bg-[#2D3445]
                   rounded-lg"
        >

            <div
                class="flex items-center
                       justify-between"
            >

                <div>

                    <p class="text-sm text-gray-400">
                        Barang Masuk
                    </p>


                    <p
                        class="mt-2
                               text-2xl
                               font-bold
                               text-white"
                    >
                        {{ number_format($todayIncoming) }}
                    </p>

                </div>


                <div
                    class="flex items-center
                           justify-center
                           w-10 h-10
                           bg-[#252B3A]
                           rounded-lg"
                >
                    ↓
                </div>

            </div>


            <p
                class="mt-3
                       text-xs
                       text-gray-400"
            >
                {{ $todayIncomingTransactions }}
                transaksi hari ini
            </p>

        </div>



        <!-- BARANG KELUAR -->

        <div
            class="p-4
                   bg-[#2D3445]
                   rounded-lg"
        >

            <div
                class="flex items-center
                       justify-between"
            >

                <div>

                    <p class="text-sm text-gray-400">
                        Barang Keluar
                    </p>


                    <p
                        class="mt-2
                               text-2xl
                               font-bold
                               text-white"
                    >
                        {{ number_format($todayOutgoing) }}
                    </p>

                </div>


                <div
                    class="flex items-center
                           justify-center
                           w-10 h-10
                           bg-[#252B3A]
                           rounded-lg"
                >
                    ↑
                </div>

            </div>


            <p
                class="mt-3
                       text-xs
                       text-gray-400"
            >
                {{ $todayOutgoingTransactions }}
                transaksi hari ini
            </p>

        </div>



        <!-- PERUBAHAN STOK -->

        <div
            class="p-4
                   bg-[#2D3445]
                   rounded-lg"
        >

            <div
                class="flex items-center
                       justify-between"
            >

                <div>

                    <p class="text-sm text-gray-400">
                        Perubahan Stok
                    </p>


                    <p
                        class="mt-2
                               text-2xl
                               font-bold
                               text-white"
                    >
                        {{
                            number_format(
                                $todayIncoming - $todayOutgoing
                            )
                        }}
                    </p>

                </div>


                <div
                    class="flex items-center
                           justify-center
                           w-10 h-10
                           bg-[#252B3A]
                           rounded-lg"
                >
                    📊
                </div>

            </div>


            <p
                class="mt-3
                       text-xs
                       text-gray-400"
            >
                Selisih stok hari ini
            </p>

        </div>

    </div>

</div>


@endsection
```
