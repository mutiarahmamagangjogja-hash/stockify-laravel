@extends('layouts.staff-gudang')

@section('title', 'Stock Opname')

@section('page-title', 'Stock Opname')

@section('page-description', 'Pemeriksaan dan penyesuaian stok barang')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div>
            <h2 class="text-2xl font-bold text-white">
                Stock Opname
            </h2>

            <p class="mt-1 text-sm text-slate-400">
                Catat hasil pemeriksaan stok fisik dan sesuaikan dengan stok sistem.
            </p>
        </div>

        <a
            href="{{ route('staff-gudang.stok.opname.tambah') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-500"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Tambah Stock Opname
        </a>

    </div>


    {{-- FLASH MESSAGE --}}
    @if(session('success'))

        <div class="rounded-xl border border-green-500/30 bg-green-500/10 px-5 py-4 text-sm text-green-300">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="rounded-xl border border-red-500/30 bg-red-500/10 px-5 py-4 text-sm text-red-300">
            {{ session('error') }}
        </div>

    @endif


    {{-- TABLE --}}
    <div class="overflow-hidden rounded-2xl border border-slate-700 bg-slate-900 shadow-xl">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="border-b border-slate-700 bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Produk
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Stok Sistem
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Stok Fisik
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Selisih
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Petugas
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-800">

                    @forelse($opnames as $opname)

                        <tr class="transition hover:bg-slate-800/50">

                            <td class="px-6 py-4 text-sm text-slate-400">
                                {{ $loop->iteration }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="font-semibold text-white">
                                    {{ $opname->product->name ?? '-' }}
                                </div>

                                <div class="mt-1 text-xs text-slate-500">
                                    {{ $opname->product->sku ?? '-' }}
                                </div>

                            </td>


                            <td class="px-6 py-4 text-center text-sm text-slate-300">
                                {{ number_format($opname->system_stock) }}
                            </td>


                            <td class="px-6 py-4 text-center text-sm font-semibold text-white">
                                {{ number_format($opname->physical_stock) }}
                            </td>


                            <td class="px-6 py-4 text-center">

                                @if($opname->difference > 0)

                                    <span class="inline-flex rounded-full bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-400">
                                        +{{ number_format($opname->difference) }}
                                    </span>

                                @elseif($opname->difference < 0)

                                    <span class="inline-flex rounded-full bg-red-500/10 px-3 py-1 text-xs font-semibold text-red-400">
                                        {{ number_format($opname->difference) }}
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-blue-500/10 px-3 py-1 text-xs font-semibold text-blue-400">
                                        Sesuai
                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4 text-sm text-slate-300">
                                {{ $opname->inspector_name ?? 'Tidak diketahui' }}
                            </td>


                            <td class="px-6 py-4 text-sm text-slate-400">
                                {{ $opname->created_at->format('d M Y H:i') }}
                            </td>


                            <td class="px-6 py-4 text-center">

                                <a
                                    href="{{ route('staff-gudang.stok.opname.detail', $opname->id) }}"
                                    class="inline-flex items-center rounded-lg bg-slate-800 px-3 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white"
                                >
                                    Detail
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="px-6 py-12 text-center"
                            >

                                <div class="text-slate-500">

                                    <p class="text-lg font-semibold text-slate-400">
                                        Belum ada Stock Opname
                                    </p>

                                    <p class="mt-1 text-sm">
                                        Silakan tambahkan stock opname pertama.
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