```blade
@extends('layouts.app')

@section('title', 'Supplier')

@section('page-title', 'Supplier')

@section('page-description', 'Kelola data supplier Stockify')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}

    <div class="flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-white">
                Data Supplier
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                Kelola informasi supplier yang bekerja sama dengan perusahaan.
            </p>
        </div>

        <a
            href="{{ route('supplier.create') }}"
            class="px-4 py-2.5
                   text-sm font-medium
                   text-white
                   bg-[#252B3A]
                   border border-[#3A4254]
                   rounded-lg
                   hover:bg-[#2D3445]"
        >
            + Tambah Supplier
        </a>

    </div>


    {{-- SUCCESS --}}

    @if(session('success'))

        <div
            class="p-4
                   text-sm
                   text-green-300
                   bg-green-900/30
                   border border-green-800
                   rounded-lg"
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- ERROR --}}

    @if($errors->any())

        <div
            class="p-4
                   text-sm
                   text-red-300
                   bg-red-900/30
                   border border-red-800
                   rounded-lg"
        >

            <ul class="list-disc pl-5 space-y-1">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- TABLE CARD --}}

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               overflow-hidden"
    >

        <div
            class="px-6 py-4
                   border-b border-[#3A4254]"
        >

            <h3 class="font-semibold text-white">
                Daftar Supplier
            </h3>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead
                    class="text-xs
                           text-gray-400
                           uppercase
                           bg-[#2D3445]"
                >

                    <tr>

                        <th class="px-6 py-4">
                            No
                        </th>

                        <th class="px-6 py-4">
                            Nama Supplier
                        </th>

                        <th class="px-6 py-4">
                            Telepon
                        </th>

                        <th class="px-6 py-4">
                            Email
                        </th>

                        <th class="px-6 py-4">
                            Alamat
                        </th>

                        <th class="px-6 py-4">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($suppliers as $supplier)

                        <tr
                            class="border-b
                                   border-[#3A4254]
                                   hover:bg-[#2D3445]"
                        >

                            {{-- NO --}}

                            <td class="px-6 py-4 text-gray-400">
                                {{ $suppliers->firstItem() + $loop->index }}
                            </td>


                            {{-- NAMA --}}

                            <td
                                class="px-6 py-4
                                       font-medium
                                       text-white"
                            >
                                {{ $supplier->name }}
                            </td>


                            {{-- TELEPON --}}

                            <td class="px-6 py-4 text-gray-400">
                                {{ $supplier->phone ?? '-' }}
                            </td>


                            {{-- EMAIL --}}

                            <td class="px-6 py-4 text-gray-400">
                                {{ $supplier->email ?? '-' }}
                            </td>


                            {{-- ALAMAT --}}

                            <td
                                class="px-6 py-4
                                       text-gray-400
                                       max-w-xs"
                            >
                                {{ $supplier->address ?? '-' }}
                            </td>


                            {{-- STATUS --}}

                            <td class="px-6 py-4">

                                @if($supplier->status)

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               text-xs
                                               font-medium
                                               text-green-300
                                               bg-green-900/30
                                               border border-green-800
                                               rounded-full"
                                    >
                                        Aktif
                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               text-xs
                                               font-medium
                                               text-gray-300
                                               bg-gray-800
                                               border border-gray-700
                                               rounded-full"
                                    >
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td class="px-6 py-4">

                                <div
                                    class="flex items-center
                                           justify-center
                                           gap-2"
                                >

                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('supplier.edit', $supplier) }}"
                                        class="px-3 py-2
                                               text-xs
                                               font-medium
                                               text-blue-300
                                               bg-blue-900/30
                                               border border-blue-800
                                               rounded-lg
                                               hover:bg-blue-900/50"
                                    >
                                        Edit
                                    </a>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route('supplier.destroy', $supplier) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus supplier ini?')"
                                        class="inline-block m-0"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-3 py-2
                                                   text-xs
                                                   font-medium
                                                   text-red-300
                                                   bg-red-900/30
                                                   border border-red-800
                                                   rounded-lg
                                                   hover:bg-red-900/50"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-12
                                       text-center
                                       text-gray-500"
                            >

                                <div class="text-4xl mb-3">
                                    🏢
                                </div>

                                <p class="text-gray-400">
                                    Belum ada supplier.
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Klik tombol "Tambah Supplier" untuk menambahkan data.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        @if($suppliers->hasPages())

            <div
                class="px-6 py-4
                       border-t border-[#3A4254]"
            >

                {{ $suppliers->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
```
