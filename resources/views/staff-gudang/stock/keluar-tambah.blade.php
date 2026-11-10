@extends('layouts.staff-gudang')

@section('title', 'Catat Barang Keluar - Stockify')

@section('page-title', 'Catat Barang Keluar')

@section(
    'page-description',
    'Catat transaksi pengeluaran barang dari gudang'
)

@section('content')

<div class="max-w-4xl">

    <!-- HEADER -->

    <div class="mb-6">

        <h2 class="text-2xl font-bold text-white">
            Catat Barang Keluar
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Isi data barang yang akan dikeluarkan dari gudang.
        </p>

    </div>


    <!-- FORM -->

    <div
        class="bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        <form
            action="{{ route('staff-gudang.stok.keluar.simpan') }}"
            method="POST"
        >

            @csrf


            <div class="p-6 space-y-6">

                <!-- PRODUK -->

                <div>

                    <label
                        for="product_id"
                        class="block mb-2
                               text-sm font-medium
                               text-white"
                    >

                        Produk
                        <span class="text-red-400">*</span>

                    </label>


                    <select
                        id="product_id"
                        name="product_id"
                        required
                        class="w-full p-3
                               text-sm text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg
                               focus:outline-none"
                    >

                        <option value="">
                            Pilih produk
                        </option>


                        @foreach($products as $product)

                            <option
                                value="{{ $product->id }}"
                                data-stock="{{ $product->stock }}"
                                data-unit="{{ $product->unit }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}
                            >

                                {{ $product->name }}
                                —
                                Stok:
                                {{ $product->stock }}
                                {{ $product->unit }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- STOK TERSEDIA -->

                <div
                    id="stockInfo"
                    class="hidden p-4
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg"
                >

                    <p class="text-xs text-gray-500">
                        Stok tersedia
                    </p>

                    <p
                        id="availableStock"
                        class="mt-1
                               text-lg
                               font-semibold
                               text-white"
                    >

                        -

                    </p>

                </div>


                <!-- JUMLAH -->

                <div>

                    <label
                        for="quantity"
                        class="block mb-2
                               text-sm font-medium
                               text-white"
                    >

                        Jumlah
                        <span class="text-red-400">*</span>

                    </label>


                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        value="{{ old('quantity') }}"
                        min="1"
                        required
                        class="w-full p-3
                               text-sm text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg
                               focus:outline-none"
                        placeholder="Masukkan jumlah barang"
                    >

                </div>


                <!-- NOMOR REFERENSI -->

                <div>

                    <label
                        for="reference_number"
                        class="block mb-2
                               text-sm font-medium
                               text-white"
                    >

                        Nomor Referensi

                    </label>


                    <input
                        type="text"
                        id="reference_number"
                        name="reference_number"
                        value="{{ old('reference_number') }}"
                        class="w-full p-3
                               text-sm text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg
                               focus:outline-none"
                        placeholder="Contoh: SO-001 / RET-001"
                    >

                </div>


                <!-- KETERANGAN -->

                <div>

                    <label
                        for="description"
                        class="block mb-2
                               text-sm font-medium
                               text-white"
                    >

                        Keterangan / Tujuan Pengeluaran

                    </label>


                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="w-full p-3
                               text-sm text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg
                               focus:outline-none"
                        placeholder="Contoh: Pengeluaran untuk pesanan pelanggan, retur, atau kebutuhan lainnya."
                    >{{ old('description') }}</textarea>

                </div>

            </div>


            <!-- FOOTER -->

            <div
                class="flex items-center
                       justify-end
                       gap-3
                       p-5
                       border-t border-[#3A4254]"
            >

                <a
                    href="{{ route('staff-gudang.stok.keluar') }}"
                    class="px-4 py-2
                           text-sm
                           text-gray-300
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           hover:bg-[#111B36]"
                >

                    Batal

                </a>


                <button
                    type="submit"
                    class="px-5 py-2
                           text-sm font-medium
                           text-white
                           bg-[#111B36]
                           border border-[#3A4254]
                           rounded-lg
                           hover:bg-[#0B132B]"
                >

                    Simpan Transaksi

                </button>

            </div>

        </form>

    </div>

</div>

@endsection


@section('scripts')

<script>

const productSelect =
    document.getElementById(
        'product_id'
    );


const stockInfo =
    document.getElementById(
        'stockInfo'
    );


const availableStock =
    document.getElementById(
        'availableStock'
    );


productSelect.addEventListener(
    'change',
    function() {

        const option =
            this.options[
                this.selectedIndex
            ];


        if (!this.value) {

            stockInfo.classList.add(
                'hidden'
            );

            return;

        }


        const stock =
            option.dataset.stock;


        const unit =
            option.dataset.unit;


        availableStock.textContent =
            stock + ' ' + unit;


        stockInfo.classList.remove(
            'hidden'
        );

    }
);

</script>

@endsection