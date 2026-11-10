@extends('layouts.staff-gudang')

@section('title', 'Detail Stock Opname')

@section('page-title', 'Detail Stock Opname')

@section(
    'page-description',
    'Detail hasil pemeriksaan stok fisik'
)

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-[#252B3A] border border-[#3A4254] rounded-xl p-6">

        <h2 class="text-xl font-semibold text-white mb-6">
            Detail Stock Opname
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <p class="text-sm text-gray-400">
                    Produk
                </p>

                <p class="mt-1 text-white font-semibold">
                    {{ $opname->product->name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-400">
                    Staff
                </p>

                <p class="mt-1 text-white font-semibold">
                    {{ $opname->inspector_name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-400">
                    Stok Sistem
                </p>

                <p class="mt-1 text-white font-semibold">
                    {{ number_format($opname->system_stock) }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-400">
                    Stok Fisik
                </p>

                <p class="mt-1 text-white font-semibold">
                    {{ number_format($opname->physical_stock) }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-400">
                    Selisih
                </p>

                <p class="mt-1 font-semibold
                    {{ $opname->difference > 0
                        ? 'text-green-400'
                        : ($opname->difference < 0
                            ? 'text-red-400'
                            : 'text-gray-300') }}"
                >
                    {{ $opname->difference > 0 ? '+' : '' }}
                    {{ number_format($opname->difference) }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-400">
                    Tanggal
                </p>

                <p class="mt-1 text-white font-semibold">
                    {{ $opname->created_at->format('d/m/Y H:i') }}
                </p>
            </div>

        </div>

        <div class="mt-6">

            <p class="text-sm text-gray-400">
                Keterangan
            </p>

            <p class="mt-1 text-gray-300">
                {{ $opname->description ?? '-' }}
            </p>

        </div>

        <div class="mt-6">

            <a
                href="{{ route('staff-gudang.stok.opname') }}"
                class="inline-flex items-center
                       px-4 py-2
                       bg-[#2D3445]
                       hover:bg-[#3A4254]
                       rounded-lg
                       text-sm
                       text-white"
            >
                ← Kembali
            </a>

        </div>

    </div>

</div>

@endsection