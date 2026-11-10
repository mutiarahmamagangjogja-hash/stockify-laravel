@extends('layouts.app')

@section('title', 'Detail Stock Opname')

@section('page-title', 'Detail Stock Opname')

@section('page-description', 'Detail hasil pemeriksaan dan penyesuaian stok')

@section('content')

<div class="space-y-6">

```
{{-- ===================================================== --}}
{{-- HEADER --}}
{{-- ===================================================== --}}

<div class="flex items-center justify-between">

    <div>

        <h2 class="text-2xl font-bold text-white">
            Detail Stock Opname
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Informasi lengkap hasil pemeriksaan stok.
        </p>

    </div>


    {{-- KEMBALI KE DAFTAR ADMIN --}}

    <a
        href="{{ route('stok.opname') }}"
        class="inline-flex
               items-center
               px-4 py-2
               rounded-lg
               text-sm
               font-medium
               text-gray-300
               bg-[#252B3A]
               border border-[#3A4254]
               hover:bg-[#2D3445]
               hover:text-white
               transition"
    >
        Kembali
    </a>

</div>


{{-- ===================================================== --}}
{{-- DETAIL --}}
{{-- ===================================================== --}}

<div
    class="bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           overflow-hidden"
>

    <div
        class="p-5
               border-b border-[#3A4254]"
    >

        <h3 class="text-lg font-semibold text-white">
            Informasi Stock Opname
        </h3>

    </div>


    <div class="p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


            {{-- ================================================= --}}
            {{-- PRODUK --}}
            {{-- ================================================= --}}

            <div>

                <p class="text-sm text-gray-400">
                    Produk
                </p>

                <p
                    class="mt-1
                           text-base
                           font-semibold
                           text-white"
                >
                    {{ $opname->product->name ?? '-' }}
                </p>

            </div>


            {{-- ================================================= --}}
            {{-- PEMERIKSA --}}
            {{-- ================================================= --}}

            <div>

                <p class="text-sm text-gray-400">
                    Pemeriksa
                </p>

                <p
                    class="mt-1
                           text-base
                           font-semibold
                           text-white"
                >
                    {{ $opname->user->name ?? '-' }}
                </p>

            </div>


            {{-- ================================================= --}}
            {{-- STOK SISTEM --}}
            {{-- ================================================= --}}

            <div>

                <p class="text-sm text-gray-400">
                    Stok Sistem
                </p>

                <p
                    class="mt-1
                           text-base
                           font-semibold
                           text-white"
                >

                    {{ $opname->system_stock }}

                    @if(
                        $opname->product &&
                        $opname->product->unit
                    )
                        {{ $opname->product->unit }}
                    @endif

                </p>

            </div>


            {{-- ================================================= --}}
            {{-- STOK FISIK --}}
            {{-- ================================================= --}}

            <div>

                <p class="text-sm text-gray-400">
                    Stok Fisik
                </p>

                <p
                    class="mt-1
                           text-base
                           font-semibold
                           text-white"
                >

                    {{ $opname->physical_stock }}

                    @if(
                        $opname->product &&
                        $opname->product->unit
                    )
                        {{ $opname->product->unit }}
                    @endif

                </p>

            </div>


            {{-- ================================================= --}}
            {{-- SELISIH --}}
            {{-- ================================================= --}}

            <div>

                <p class="text-sm text-gray-400">
                    Selisih
                </p>

                <div class="mt-2">

                    @if($opname->difference > 0)

                        <span
                            class="inline-flex
                                   px-3 py-1.5
                                   rounded-md
                                   text-sm
                                   font-medium
                                   text-green-300
                                   bg-green-900/30
                                   border border-green-800"
                        >
                            +{{ $opname->difference }}
                        </span>

                    @elseif($opname->difference < 0)

                        <span
                            class="inline-flex
                                   px-3 py-1.5
                                   rounded-md
                                   text-sm
                                   font-medium
                                   text-red-300
                                   bg-red-900/30
                                   border border-red-800"
                        >
                            {{ $opname->difference }}
                        </span>

                    @else

                        <span
                            class="inline-flex
                                   px-3 py-1.5
                                   rounded-md
                                   text-sm
                                   font-medium
                                   text-gray-300
                                   bg-[#111B36]
                                   border border-[#3A4254]"
                        >
                            0
                        </span>

                    @endif

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- TANGGAL --}}
            {{-- ================================================= --}}

            <div>

                <p class="text-sm text-gray-400">
                    Tanggal Pemeriksaan
                </p>

                <p
                    class="mt-1
                           text-base
                           font-semibold
                           text-white"
                >

                    @if($opname->created_at)

                        {{ $opname->created_at->format('d/m/Y H:i') }}

                    @else

                        -

                    @endif

                </p>

            </div>


            {{-- ================================================= --}}
            {{-- KETERANGAN --}}
            {{-- ================================================= --}}

            @if(isset($opname->description))

                <div class="md:col-span-2">

                    <p class="text-sm text-gray-400">
                        Keterangan
                    </p>

                    <div
                        class="mt-2
                               p-4
                               rounded-lg
                               bg-[#111B36]
                               border border-[#3A4254]"
                    >

                        <p class="text-sm text-gray-300">
                            {{ $opname->description ?: '-' }}
                        </p>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>
```

</div>

@endsection
