@extends('layouts.staff-gudang')

@section('title', 'Konfirmasi Pengeluaran Barang - Stockify')

@section('page-title', 'Konfirmasi Pengeluaran Barang')

@section(
    'page-description',
    'Catat, periksa, dan konfirmasi barang yang akan dikeluarkan'
)

@section('content')

<!-- ===================================================== -->
<!-- HEADER -->
<!-- ===================================================== -->

<div class="mb-6">

    <div class="flex items-center justify-between">

        <div>

            <h2 class="text-2xl font-bold text-white">
                Konfirmasi Pengeluaran Barang
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                Catat barang yang akan keluar kemudian lakukan pemeriksaan.
            </p>

        </div>


        <a
            href="{{ route('staff-gudang.stok.keluar.tambah') }}"
            class="inline-flex items-center
                   px-4 py-2.5
                   text-sm font-medium
                   text-white
                   bg-[#111B36]
                   border border-[#3A4254]
                   rounded-lg
                   hover:bg-[#0B132B]"
        >

            <svg
                class="w-5 h-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16m8-8H4"
                />

            </svg>

            Catat Barang Keluar

        </a>

    </div>

</div>


<!-- ===================================================== -->
<!-- SUCCESS -->
<!-- ===================================================== -->

@if(session('success'))

<div
    class="p-4 mb-6
           text-sm text-green-300
           bg-green-900/20
           border border-green-800
           rounded-lg"
>

    {{ session('success') }}

</div>

@endif


<!-- ===================================================== -->
<!-- ERROR -->
<!-- ===================================================== -->

@if(session('error'))

<div
    class="p-4 mb-6
           text-sm text-red-300
           bg-red-900/20
           border border-red-800
           rounded-lg"
>

    {{ session('error') }}

</div>

@endif


<!-- ===================================================== -->
<!-- VALIDATION ERROR -->
<!-- ===================================================== -->

@if($errors->any())

<div
    class="p-4 mb-6
           text-sm text-red-300
           bg-red-900/20
           border border-red-800
           rounded-lg"
>

    <ul class="list-disc ml-5">

        @foreach($errors->all() as $error)

            <li>
                {{ $error }}
            </li>

        @endforeach

    </ul>

</div>

@endif


<!-- ===================================================== -->
<!-- INFORMASI -->
<!-- ===================================================== -->

<div
    class="mb-6 p-5
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg"
>

    <div class="flex items-start gap-4">

        <div
            class="flex items-center justify-center
                   w-10 h-10
                   flex-shrink-0
                   bg-[#2D3445]
                   rounded-lg"
        >

            <svg
                class="w-5 h-5 text-gray-300"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 16h-1v-4h-1
                       m1-4h.01
                       M12 2a10 10 0
                       100 20
                       10 10 0
                       000-20z"
                />

            </svg>

        </div>


        <div>

            <h3 class="font-semibold text-white">
                Alur Pengeluaran
            </h3>

            <p class="mt-1 text-sm text-gray-400">

                Catat barang yang akan dikeluarkan,
                kemudian periksa produk, atribut, jumlah,
                dan kondisi barang sebelum melakukan konfirmasi.
                Stok hanya akan dikurangi setelah barang
                dinyatakan sesuai.

            </p>

        </div>

    </div>

</div>


<!-- ===================================================== -->
<!-- TABLE -->
<!-- ===================================================== -->

<div
    class="bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           overflow-hidden"
>

    <!-- HEADER TABLE -->

    <div
        class="flex items-center justify-between
               p-5
               border-b border-[#3A4254]"
    >

        <div>

            <h3 class="text-lg font-semibold text-white">
                Transaksi Barang Keluar
            </h3>

            <p class="text-sm text-gray-400">
                Daftar transaksi pengeluaran barang.
            </p>

        </div>


        <span
            class="px-3 py-1.5
                   text-xs font-medium
                   text-blue-300
                   bg-blue-900/30
                   rounded-full"
        >

            {{ $transactions->where('status', 'pending')->count() }}

            Menunggu

        </span>

    </div>


    <!-- TABLE -->

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
                        Produk
                    </th>

                    <th class="px-6 py-4">
                        Jumlah
                    </th>

                    <th class="px-6 py-4">
                        Referensi
                    </th>

                    <th class="px-6 py-4">
                        Tanggal
                    </th>

                    <th class="px-6 py-4">
                        Status
                    </th>

                    <th class="px-6 py-4 text-right">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($transactions as $transaction)

                <tr
                    class="border-b
                           border-[#3A4254]
                           hover:bg-[#2D3445]"
                >

                    <!-- NO -->

                    <td class="px-6 py-4 text-gray-400">

                        {{ $loop->iteration }}

                    </td>


                    <!-- PRODUK -->

                    <td class="px-6 py-4">

                        <p class="font-medium text-white">

                            {{ $transaction->product->name ?? '-' }}

                        </p>


                        @if($transaction->description)

                            <p class="mt-1 text-xs text-gray-500">

                                {{ $transaction->description }}

                            </p>

                        @endif

                    </td>


                    <!-- JUMLAH -->

                    <td class="px-6 py-4 text-white">

                        <span class="font-semibold">

                            {{ $transaction->quantity }}

                        </span>

                        <span class="text-gray-500">

                            {{ $transaction->product->unit ?? 'unit' }}

                        </span>

                    </td>


                    <!-- REFERENSI -->

                    <td class="px-6 py-4 text-gray-300">

                        {{ $transaction->reference_number ?? '-' }}

                    </td>


                    <!-- TANGGAL -->

                    <td class="px-6 py-4 text-gray-400">

                        {{ $transaction->created_at->format('d/m/Y H:i') }}

                    </td>


                    <!-- STATUS -->

                    <td class="px-6 py-4">

                        @if(
                            $transaction->status === 'pending' ||
                            $transaction->status === 'menunggu'
                        )

                            <span
                                class="inline-flex
                                       px-2.5 py-1
                                       text-xs font-medium
                                       text-yellow-300
                                       bg-yellow-900/30
                                       rounded-full"
                            >

                                Menunggu Pemeriksaan

                            </span>

                        @elseif($transaction->status === 'confirmed')

                            <span
                                class="inline-flex
                                       px-2.5 py-1
                                       text-xs font-medium
                                       text-green-300
                                       bg-green-900/30
                                       rounded-full"
                            >

                                Dikonfirmasi

                            </span>

                        @elseif($transaction->status === 'rejected')

                            <span
                                class="inline-flex
                                       px-2.5 py-1
                                       text-xs font-medium
                                       text-red-300
                                       bg-red-900/30
                                       rounded-full"
                            >

                                Tidak Sesuai

                            </span>

                        @else

                            <span
                                class="inline-flex
                                       px-2.5 py-1
                                       text-xs font-medium
                                       text-gray-300
                                       bg-gray-900/30
                                       rounded-full"
                            >

                                {{ $transaction->status }}

                            </span>

                        @endif

                    </td>


                    <!-- AKSI -->

                    <td class="px-6 py-4 text-right">

                        @if(
                            $transaction->status === 'pending' ||
                            $transaction->status === 'menunggu'
                        )

                            <button
                                type="button"
                                onclick="openInspectionModal(
                                    {{ $transaction->id }},
                                    @js($transaction->product->name ?? '-'),
                                    @js($transaction->quantity),
                                    @js($transaction->product->unit ?? 'unit'),
                                    @js($transaction->reference_number ?? '-')
                                )"
                                class="px-4 py-2
                                       text-xs font-medium
                                       text-white
                                       bg-[#111B36]
                                       border border-[#3A4254]
                                       rounded-lg
                                       hover:bg-[#0B132B]"
                            >

                                Periksa

                            </button>

                        @else

                            <button
                                type="button"
                                onclick="openDetailModal(
                                    @js($transaction->product->name ?? '-'),
                                    @js($transaction->quantity),
                                    @js($transaction->product->unit ?? 'unit'),
                                    @js($transaction->reference_number ?? '-'),
                                    @js($transaction->status),
                                    @js($transaction->inspection_notes ?? '-')
                                )"
                                class="px-4 py-2
                                       text-xs font-medium
                                       text-gray-300
                                       bg-[#2D3445]
                                       border border-[#3A4254]
                                       rounded-lg
                                       hover:bg-[#111B36]"
                            >

                                Lihat Hasil

                            </button>

                        @endif

                    </td>

                </tr>


                @empty

                <tr>

                    <td
                        colspan="7"
                        class="px-6 py-12 text-center"
                    >

                        <p class="text-white font-medium">

                            Belum ada transaksi barang keluar.

                        </p>


                        <p class="mt-1 text-sm text-gray-500">

                            Gunakan tombol "Catat Barang Keluar"
                            untuk mencatat pengeluaran.

                        </p>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<!-- ===================================================== -->
<!-- MODAL PEMERIKSAAN -->
<!-- ===================================================== -->

<div
    id="inspectionModal"
    class="fixed inset-0 z-50
           hidden
           items-start justify-center
           bg-black/70
           overflow-y-auto"
>

    <div
        class="w-full max-w-2xl
               mx-4 my-8
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               shadow-xl"
    >

        <!-- HEADER -->

        <div
            class="flex items-center justify-between
                   p-5
                   border-b border-[#3A4254]"
        >

            <div>

                <h3 class="text-lg font-semibold text-white">

                    Pemeriksaan Barang Keluar

                </h3>


                <p class="text-sm text-gray-400">

                    Pastikan barang yang akan dikeluarkan
                    sesuai dengan transaksi.

                </p>

            </div>


            <button
                type="button"
                onclick="closeInspectionModal()"
                class="text-2xl text-gray-400 hover:text-white"
            >

                ×

            </button>

        </div>


        <!-- FORM -->

        <form
            id="inspectionForm"
            method="POST"
        >

            @csrf

            @method('PATCH')


            <div class="p-5 space-y-5">

                <!-- INFORMASI PRODUK -->

                <div
                    class="grid grid-cols-1
                           md:grid-cols-3
                           gap-4"
                >

                    <div>

                        <p class="text-xs text-gray-500">
                            Produk
                        </p>

                        <p
                            id="modalProduct"
                            class="mt-1
                                   font-semibold
                                   text-white"
                        >
                            -
                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-gray-500">
                            Jumlah
                        </p>

                        <p
                            id="modalQuantity"
                            class="mt-1
                                   font-semibold
                                   text-white"
                        >
                            -
                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-gray-500">
                            Referensi
                        </p>

                        <p
                            id="modalReference"
                            class="mt-1
                                   text-white"
                        >
                            -
                        </p>

                    </div>

                </div>


                <!-- PRODUK -->

                <div>

                    <label
                        class="block mb-2
                               text-sm font-medium
                               text-white"
                    >

                        Nama produk sesuai?

                    </label>


                    <div class="flex gap-6">

                        <label
                            class="flex items-center
                                   gap-2
                                   text-sm
                                   text-gray-300"
                        >

                            <input
                                type="radio"
                                name="product_match"
                                value="1"
                                required
                                class="w-4 h-4"
                            >

                            Sesuai

                        </label>


                        <label
                            class="flex items-center
                                   gap-2
                                   text-sm
                                   text-gray-300"
                        >

                            <input
                                type="radio"
                                name="product_match"
                                value="0"
                                class="w-4 h-4"
                            >

                            Tidak Sesuai

                        </label>

                    </div>

                </div>


                <!-- ATRIBUT -->

                <div>

                    <label
                        class="block mb-2
                               text-sm font-medium
                               text-white"
                    >

                        Atribut produk sesuai?

                    </label>


                    <div class="flex gap-6">

                        <label
                            class="flex items-center
                                   gap-2
                                   text-sm
                                   text-gray-300"
                        >

                            <input
                                type="radio"
                                name="attribute_match"
                                value="1"
                                required
                                class="w-4 h-4"
                            >

                            Sesuai

                        </label>


                        <label
                            class="flex items-center
                                   gap-2
                                   text-sm
                                   text-gray-300"
                        >

                            <input
                                type="radio"
                                name="attribute_match"
                                value="0"
                                class="w-4 h-4"
                            >

                            Tidak Sesuai

                        </label>

                    </div>

                </div>


                <!-- JUMLAH -->

                <div>

                    <label
                        class="block mb-2
                               text-sm font-medium
                               text-white"
                    >

                        Jumlah barang sesuai?

                    </label>


                    <div class="flex gap-6">

                        <label
                            class="flex items-center
                                   gap-2
                                   text-sm
                                   text-gray-300"
                        >

                            <input
                                type="radio"
                                name="quantity_match"
                                value="1"
                                required
                                class="w-4 h-4"
                            >

                            Sesuai

                        </label>


                        <label
                            class="flex items-center
                                   gap-2
                                   text-sm
                                   text-gray-300"
                        >

                            <input
                                type="radio"
                                name="quantity_match"
                                value="0"
                                class="w-4 h-4"
                            >

                            Tidak Sesuai

                        </label>

                    </div>

                </div>


                <!-- KONDISI -->

                <div>

                    <label
                        for="condition"
                        class="block mb-2
                               text-sm font-medium
                               text-white"
                    >

                        Kondisi Barang

                    </label>


                    <select
                        id="condition"
                        name="condition"
                        required
                        class="w-full
                               p-3
                               text-sm
                               text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg
                               focus:outline-none"
                    >

                        <option value="">
                            Pilih kondisi
                        </option>

                        <option value="baik">
                            Baik
                        </option>

                        <option value="rusak">
                            Rusak
                        </option>

                        <option value="sebagian_rusak">
                            Sebagian Rusak
                        </option>

                    </select>

                </div>


                <!-- CATATAN -->

                <div>

                    <label
                        for="inspection_notes"
                        class="block mb-2
                               text-sm font-medium
                               text-white"
                    >

                        Catatan Pemeriksaan

                    </label>


                    <textarea
                        id="inspection_notes"
                        name="inspection_notes"
                        rows="4"
                        class="w-full
                               p-3
                               text-sm
                               text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg
                               focus:outline-none"
                        placeholder="Tuliskan hasil pemeriksaan atau ketidaksesuaian..."
                    ></textarea>

                </div>

            </div>


            <!-- FOOTER -->

            <div
                class="flex justify-end
                       gap-3
                       p-5
                       border-t border-[#3A4254]"
            >

                <button
                    type="button"
                    onclick="closeInspectionModal()"
                    class="px-4 py-2
                           text-sm
                           text-gray-300
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           hover:bg-[#111B36]"
                >

                    Batal

                </button>


                <button
                    type="submit"
                    class="px-5 py-2
                           text-sm
                           font-medium
                           text-white
                           bg-[#111B36]
                           border border-[#3A4254]
                           rounded-lg
                           hover:bg-[#0B132B]"
                >

                    Simpan Pemeriksaan

                </button>

            </div>

        </form>

    </div>

</div>


<!-- ===================================================== -->
<!-- MODAL DETAIL -->
<!-- ===================================================== -->

<div
    id="detailModal"
    class="fixed inset-0 z-50
           hidden
           items-center justify-center
           bg-black/70
           p-4"
>

    <div
        class="w-full max-w-lg
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               shadow-xl"
    >

        <div
            class="flex items-center justify-between
                   p-5
                   border-b border-[#3A4254]"
        >

            <h3 class="text-lg font-semibold text-white">

                Hasil Pemeriksaan

            </h3>


            <button
                type="button"
                onclick="closeDetailModal()"
                class="text-2xl text-gray-400 hover:text-white"
            >

                ×

            </button>

        </div>


        <div class="p-5 space-y-4">

            <div>

                <p class="text-xs text-gray-500">
                    Produk
                </p>

                <p
                    id="detailProduct"
                    class="mt-1 text-white font-semibold"
                >
                    -
                </p>

            </div>


            <div>

                <p class="text-xs text-gray-500">
                    Jumlah
                </p>

                <p
                    id="detailQuantity"
                    class="mt-1 text-white"
                >
                    -
                </p>

            </div>


            <div>

                <p class="text-xs text-gray-500">
                    Referensi
                </p>

                <p
                    id="detailReference"
                    class="mt-1 text-white"
                >
                    -
                </p>

            </div>


            <div>

                <p class="text-xs text-gray-500">
                    Status
                </p>

                <p
                    id="detailStatus"
                    class="mt-1 text-white"
                >
                    -
                </p>

            </div>


            <div>

                <p class="text-xs text-gray-500">
                    Catatan Pemeriksaan
                </p>

                <div
                    id="detailNotes"
                    class="mt-1 p-3
                           text-sm text-gray-300
                           bg-[#2D3445]
                           rounded-lg"
                >
                    -
                </div>

            </div>

        </div>


        <div
            class="flex justify-end
                   p-5
                   border-t border-[#3A4254]"
        >

            <button
                type="button"
                onclick="closeDetailModal()"
                class="px-4 py-2
                       text-sm
                       text-gray-300
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg"
            >

                Tutup

            </button>

        </div>

    </div>

</div>

@endsection


@section('scripts')

<script>

function openInspectionModal(
    id,
    product,
    quantity,
    unit,
    reference
) {

    document.getElementById(
        'modalProduct'
    ).textContent = product;


    document.getElementById(
        'modalQuantity'
    ).textContent =
        quantity + ' ' + unit;


    document.getElementById(
        'modalReference'
    ).textContent = reference;


    document.getElementById(
        'inspectionForm'
    ).action =
        "{{ url('/staff-gudang/stok/keluar') }}"
        + "/"
        + id
        + "/konfirmasi";


    document.getElementById(
        'inspectionForm'
    ).reset();


    document.getElementById(
        'modalProduct'
    ).textContent = product;


    document.getElementById(
        'modalQuantity'
    ).textContent =
        quantity + ' ' + unit;


    document.getElementById(
        'modalReference'
    ).textContent = reference;


    const modal =
        document.getElementById(
            'inspectionModal'
        );


    modal.classList.remove('hidden');

    modal.classList.add('flex');

    document.body.classList.add(
        'overflow-hidden'
    );
}


function closeInspectionModal()
{
    const modal =
        document.getElementById(
            'inspectionModal'
        );


    modal.classList.add('hidden');

    modal.classList.remove('flex');

    document.body.classList.remove(
        'overflow-hidden'
    );
}


function openDetailModal(
    product,
    quantity,
    unit,
    reference,
    status,
    notes
) {

    document.getElementById(
        'detailProduct'
    ).textContent = product;


    document.getElementById(
        'detailQuantity'
    ).textContent =
        quantity + ' ' + unit;


    document.getElementById(
        'detailReference'
    ).textContent = reference;


    document.getElementById(
        'detailStatus'
    ).textContent =
        status === 'confirmed'
            ? 'Dikonfirmasi'
            : 'Tidak Sesuai';


    document.getElementById(
        'detailNotes'
    ).textContent =
        notes || 'Tidak ada catatan.';


    const modal =
        document.getElementById(
            'detailModal'
        );


    modal.classList.remove('hidden');

    modal.classList.add('flex');

    document.body.classList.add(
        'overflow-hidden'
    );
}


function closeDetailModal()
{
    const modal =
        document.getElementById(
            'detailModal'
        );


    modal.classList.add('hidden');

    modal.classList.remove('flex');

    document.body.classList.remove(
        'overflow-hidden'
    );
}


/*
|--------------------------------------------------------------------------
| KLIK DI LUAR MODAL
|--------------------------------------------------------------------------
*/

document
    .getElementById('inspectionModal')
    .addEventListener(
        'click',
        function(event) {

            if (
                event.target === this
            ) {

                closeInspectionModal();

            }

        }
    );


document
    .getElementById('detailModal')
    .addEventListener(
        'click',
        function(event) {

            if (
                event.target === this
            ) {

                closeDetailModal();

            }

        }
    );

</script>

@endsection