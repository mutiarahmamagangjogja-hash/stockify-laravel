```blade
@extends('layouts.app')

@section('title', 'Stok Minimum')

@section('page-title', 'Stok Minimum')

@section('page-description', 'Pengaturan batas minimum persediaan produk')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}

    <div>

        <h2 class="text-2xl font-bold text-white">
            Stok Minimum
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Atur batas minimum stok untuk setiap produk.
        </p>

    </div>


    {{-- SUCCESS --}}

    @if(session('success'))

        <div
            class="p-4
                   text-sm text-green-300
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
                   text-sm text-red-300
                   bg-red-900/30
                   border border-red-800
                   rounded-lg"
        >

            <ul class="list-disc pl-5">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- TABLE --}}

    <div
        class="overflow-hidden
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        <div
            class="p-5
                   border-b border-[#3A4254]"
        >

            <h3 class="text-lg font-semibold text-white">
                Pengaturan Stok Minimum
            </h3>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead
                    class="bg-[#2D3445]
                           text-xs
                           uppercase
                           text-gray-400"
                >

                    <tr>

                        <th class="px-6 py-4">
                            No
                        </th>

                        <th class="px-6 py-4">
                            Produk
                        </th>

                        <th class="px-6 py-4">
                            SKU
                        </th>

                        <th class="px-6 py-4">
                            Stok Saat Ini
                        </th>

                        <th class="px-6 py-4">
                            Stok Minimum
                        </th>

                        <th class="px-6 py-4">
                            Status
                        </th>

                        <th class="px-6 py-4">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-[#3A4254]">

                    @forelse($products as $product)

                        <tr class="hover:bg-[#2D3445]">

                            {{-- NO --}}

                            <td class="px-6 py-4 text-gray-400">

                                {{ $loop->iteration }}

                            </td>


                            {{-- PRODUK --}}

                            <td class="px-6 py-4">

                                <span class="font-medium text-white">

                                    {{ $product->name }}

                                </span>

                            </td>


                            {{-- SKU --}}

                            <td class="px-6 py-4 text-gray-400">

                                {{ $product->sku }}

                            </td>


                            {{-- STOK SAAT INI --}}

                            <td class="px-6 py-4">

                                <span
                                    class="font-semibold
                                    {{ $product->stock <= $product->minimum_stock
                                        ? 'text-red-400'
                                        : 'text-green-400' }}"
                                >

                                    {{ $product->stock }}

                                </span>

                                <span class="text-gray-500">
                                    {{ $product->unit }}
                                </span>

                            </td>


                            {{-- STOK MINIMUM --}}

                            <td class="px-6 py-4">

                                <form
                                    action="{{ route('stok.minimum.update', $product) }}"
                                    method="POST"
                                    class="flex items-center gap-2"
                                >

                                    @csrf

                                    @method('PUT')


                                    <input
                                        type="number"
                                        name="minimum_stock"
                                        min="0"
                                        value="{{ $product->minimum_stock }}"
                                        class="w-28
                                               px-3 py-2
                                               text-sm
                                               text-white
                                               bg-[#111B36]
                                               border border-[#3A4254]
                                               rounded-lg
                                               focus:outline-none"
                                    >


                                    <span class="text-gray-500">
                                        {{ $product->unit }}
                                    </span>

                            </td>


                            {{-- STATUS --}}

                            <td class="px-6 py-4">

                                @if($product->stock <= $product->minimum_stock)

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               text-xs
                                               font-medium
                                               text-red-300
                                               bg-red-900/30
                                               border border-red-800
                                               rounded-lg"
                                    >

                                        Stok Rendah

                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               text-xs
                                               font-medium
                                               text-green-300
                                               bg-green-900/30
                                               border border-green-800
                                               rounded-lg"
                                    >

                                        Aman

                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td class="px-6 py-4">

                                    <button
                                        type="submit"
                                        class="px-3 py-2
                                               text-xs
                                               font-medium
                                               text-white
                                               bg-[#111B36]
                                               border border-[#3A4254]
                                               rounded-lg
                                               hover:bg-[#0B132B]"
                                    >

                                        Simpan

                                    </button>

                                </form>

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

                                Belum ada produk.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
```
