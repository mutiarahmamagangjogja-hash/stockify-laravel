@extends('layouts.manager-gudang')

@section('title', 'Supplier - Stockify')

@section('page-title', 'Supplier')

@section(
    'page-description',
    'Daftar supplier barang Stockify'
)

@section('content')

<div class="bg-[#252B3A]
            border border-[#3A4254]
            rounded-lg
            shadow-sm">

    <!-- HEADER -->

    <div class="flex items-center justify-between
                p-5
                border-b border-[#3A4254]">

        <div>

            <h2 class="text-lg font-semibold text-white">
                Daftar Supplier
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                Informasi supplier yang terdaftar
            </p>

        </div>

    </div>


    <!-- TABLE -->

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-[#2D3445]">

                <tr>

                    <th
                        class="px-5 py-4
                               text-left
                               font-semibold
                               text-gray-300"
                    >
                        No
                    </th>

                    <th
                        class="px-5 py-4
                               text-left
                               font-semibold
                               text-gray-300"
                    >
                        Nama Supplier
                    </th>

                    <th
                        class="px-5 py-4
                               text-left
                               font-semibold
                               text-gray-300"
                    >
                        Telepon
                    </th>

                    <th
                        class="px-5 py-4
                               text-left
                               font-semibold
                               text-gray-300"
                    >
                        Email
                    </th>

                    <th
                        class="px-5 py-4
                               text-left
                               font-semibold
                               text-gray-300"
                    >
                        Alamat
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-[#3A4254]">

                @forelse($suppliers as $supplier)

                    <tr class="hover:bg-[#2D3445]">

                        <td class="px-5 py-4 text-gray-400">
                            {{ $loop->iteration }}
                        </td>


                        <td class="px-5 py-4">

                            <span class="font-medium text-white">
                                {{ $supplier->name }}
                            </span>

                        </td>


                        <td class="px-5 py-4 text-gray-400">
                            {{ $supplier->phone ?? '-' }}
                        </td>


                        <td class="px-5 py-4 text-gray-400">
                            {{ $supplier->email ?? '-' }}
                        </td>


                        <td class="px-5 py-4 text-gray-400">
                            {{ $supplier->address ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="px-5 py-12
                                   text-center
                                   text-gray-400"
                        >
                            Belum ada supplier.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
