@extends('layouts.staff-gudang')

@section('title', 'Konfirmasi Penerimaan Barang - Stockify')

@section('page-title', 'Konfirmasi Penerimaan Barang')

@section(
    'page-description',
    'Catat, periksa, dan konfirmasi barang yang diterima'
)

@section('content')

<div class="mb-6">

    <div class="flex items-center justify-between">

        <div>

            <h2 class="text-2xl font-bold text-white">
                Konfirmasi Penerimaan Barang
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                Catat barang yang datang kemudian lakukan pemeriksaan fisik.
            </p>

        </div>


        <a
            href="{{ route('staff-gudang.stok.masuk.tambah') }}"
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

            Catat Barang Masuk

        </a>

    </div>

</div>


{{-- ========================================================= --}}
{{-- FLASH SUCCESS --}}
{{-- ========================================================= --}}

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


{{-- ========================================================= --}}
{{-- FLASH ERROR --}}
{{-- ========================================================= --}}

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


{{-- ========================================================= --}}
{{-- VALIDATION --}}
{{-- ========================================================= --}}

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


{{-- ========================================================= --}}
{{-- INFORMASI --}}
{{-- ========================================================= --}}

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
                    d="M13 16h-1v-4h-1m1-4h.01
                       M12 2a10 10 0 100 20
                       10 10 0 000-20z"
                />

            </svg>

        </div>


        <div>

            <h3 class="font-semibold text-white">
                Alur Penerimaan
            </h3>

            <p class="mt-1 text-sm text-gray-400">

                Catat barang yang datang, kemudian periksa
                nama produk, atribut, jumlah, dan kondisi
                barang sebelum melakukan konfirmasi.

            </p>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- TABEL --}}
{{-- ========================================================= --}}

<div
    class="bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg
           overflow-hidden"
>

    <div
        class="flex items-center justify-between
               p-5
               border-b border-[#3A4254]"
    >

        <div>

            <h3 class="text-lg font-semibold text-white">
                Riwayat Barang Masuk
            </h3>

            <p class="text-sm text-gray-400">
                Daftar transaksi penerimaan barang.
            </p>

        </div>


        <span
            class="px-3 py-1.5
                   text-xs font-medium
                   text-gray-300
                   bg-[#2D3445]
                   rounded-full"
        >

            {{ $transactions->count() }} Transaksi

        </span>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full text-sm text-left">

            <thead
                class="text-xs text-gray-400
                       uppercase bg-[#2D3445]"
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
                    class="border-b border-[#3A4254]
                           hover:bg-[#2D3445]"
                >

                    <td class="px-6 py-4 text-gray-400">
                        {{ $loop->iteration }}
                    </td>


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


                    <td class="px-6 py-4 text-white">

                        {{ $transaction->quantity }}

                        {{ $transaction->product->unit ?? 'unit' }}

                    </td>


                    <td class="px-6 py-4 text-gray-300">

                        {{ $transaction->reference_number ?? '-' }}

                    </td>


                    <td class="px-6 py-4 text-gray-400">

                        {{ $transaction->created_at->format('d/m/Y H:i') }}

                    </td>


                    {{-- ================================================= --}}
                    {{-- STATUS --}}
                    {{-- ================================================= --}}

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

                        @elseif(
                            $transaction->status === 'confirmed'
                        )

                            <span
                                class="inline-flex
                                       px-2.5 py-1
                                       text-xs font-medium
                                       text-green-300
                                       bg-green-900/30
                                       rounded-full"
                            >

                                Sesuai

                            </span>

                        @elseif(
                            $transaction->status === 'rejected'
                        )

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
                                       bg-gray-700
                                       rounded-full"
                            >

                                {{ $transaction->status }}

                            </span>

                        @endif

                    </td>


                    {{-- ================================================= --}}
                    {{-- AKSI --}}
                    {{-- ================================================= --}}

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
                                onclick="openResultModal(
                                    @js($transaction->product->name ?? '-'),
                                    @js($transaction->quantity),
                                    @js($transaction->reference_number ?? '-'),
                                    @js($transaction->status),
                                    @js($transaction->product_match),
                                    @js($transaction->attribute_match),
                                    @js($transaction->quantity_match),
                                    @js($transaction->condition),
                                    @js($transaction->inspection_notes ?? $transaction->notes)
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
                            Belum ada transaksi barang masuk.
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            Klik "Catat Barang Masuk" untuk mencatat barang yang datang.
                        </p>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- ========================================================= --}}
{{-- MODAL PEMERIKSAAN --}}
{{-- ========================================================= --}}

<div
    id="inspectionModal"
    class="fixed inset-0 z-50
           hidden
           items-center justify-center
           bg-black/70
           p-4"
>

    <div
        class="w-full max-w-2xl
               max-h-[90vh]
               overflow-y-auto
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg
               shadow-xl"
    >

        {{-- HEADER --}}

        <div
            class="sticky top-0 z-10
                   flex items-center justify-between
                   p-5
                   bg-[#252B3A]
                   border-b border-[#3A4254]"
        >

            <div>

                <h3 class="text-lg font-semibold text-white">
                    Pemeriksaan Barang Masuk
                </h3>

                <p class="text-sm text-gray-400">
                    Pastikan barang fisik sesuai dengan transaksi.
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


        <form
            id="inspectionForm"
            method="POST"
        >

            @csrf

            @method('PATCH')


            <div class="p-5 space-y-6">


                {{-- INFORMASI TRANSAKSI --}}

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
                            class="mt-1 font-semibold text-white"
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
                            class="mt-1 font-semibold text-white"
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
                            class="mt-1 text-white"
                        >
                            -
                        </p>

                    </div>

                </div>


                {{-- NAMA PRODUK --}}

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
                            class="flex items-center gap-2
                                   text-sm text-gray-300"
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
                            class="flex items-center gap-2
                                   text-sm text-gray-300"
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


                {{-- ATRIBUT --}}

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
                            class="flex items-center gap-2
                                   text-sm text-gray-300"
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
                            class="flex items-center gap-2
                                   text-sm text-gray-300"
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


                {{-- JUMLAH --}}

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
                            class="flex items-center gap-2
                                   text-sm text-gray-300"
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
                            class="flex items-center gap-2
                                   text-sm text-gray-300"
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


                {{-- KONDISI --}}

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
                        class="w-full p-3
                               text-sm text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg"
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


                {{-- CATATAN --}}

                <div>

                    <label
                        for="inspection_notes"
                        class="block mb-2
                               text-sm font-medium
                               text-white"
                    >

                        Catatan Ketidaksesuaian

                    </label>


                    <textarea
                        id="inspection_notes"
                        name="inspection_notes"
                        rows="4"
                        class="w-full p-3
                               text-sm text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg"
                        placeholder="Tuliskan hasil pemeriksaan atau ketidaksesuaian barang..."
                    ></textarea>

                </div>

            </div>


            {{-- FOOTER --}}

            <div
                class="sticky bottom-0
                       flex justify-end gap-3
                       p-5
                       bg-[#252B3A]
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
                           rounded-lg"
                >

                    Batal

                </button>


                <button
                    type="submit"
                    class="px-4 py-2
                           text-sm font-medium
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


{{-- ========================================================= --}}
{{-- MODAL HASIL PEMERIKSAAN --}}
{{-- ========================================================= --}}

<div
    id="resultModal"
    class="fixed inset-0 z-50
           hidden
           items-center justify-center
           bg-black/70
           p-4"
>

    <div
        class="w-full max-w-xl
               max-h-[90vh]
               overflow-y-auto
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        <div
            class="flex items-center justify-between
                   p-5
                   border-b border-[#3A4254]"
        >

            <div>

                <h3 class="text-lg font-semibold text-white">
                    Hasil Pemeriksaan
                </h3>

                <p class="text-sm text-gray-400">
                    Detail hasil pemeriksaan barang.
                </p>

            </div>


            <button
                type="button"
                onclick="closeResultModal()"
                class="text-2xl text-gray-400 hover:text-white"
            >

                ×

            </button>

        </div>


        <div class="p-5 space-y-5">


            {{-- STATUS --}}

            <div>

                <p class="text-xs text-gray-500">
                    Status Pemeriksaan
                </p>

                <span
                    id="resultStatus"
                    class="inline-flex mt-2
                           px-3 py-1.5
                           text-sm font-medium
                           rounded-full"
                >

                    -

                </span>

            </div>


            {{-- PRODUK --}}

            <div>

                <p class="text-xs text-gray-500">
                    Produk
                </p>

                <p
                    id="resultProduct"
                    class="mt-1 font-semibold text-white"
                >

                    -

                </p>

            </div>


            {{-- JUMLAH --}}

            <div>

                <p class="text-xs text-gray-500">
                    Jumlah
                </p>

                <p
                    id="resultQuantity"
                    class="mt-1 text-white"
                >

                    -

                </p>

            </div>


            {{-- REFERENSI --}}

            <div>

                <p class="text-xs text-gray-500">
                    Nomor Referensi
                </p>

                <p
                    id="resultReference"
                    class="mt-1 text-white"
                >

                    -

                </p>

            </div>


            {{-- HASIL CHECK --}}

            <div
                class="p-4
                       bg-[#2D3445]
                       rounded-lg
                       space-y-3"
            >

                <div class="flex justify-between">

                    <span class="text-sm text-gray-400">
                        Nama Produk
                    </span>

                    <span
                        id="resultProductMatch"
                        class="text-sm font-medium text-white"
                    >
                        -
                    </span>

                </div>


                <div class="flex justify-between">

                    <span class="text-sm text-gray-400">
                        Atribut
                    </span>

                    <span
                        id="resultAttributeMatch"
                        class="text-sm font-medium text-white"
                    >
                        -
                    </span>

                </div>


                <div class="flex justify-between">

                    <span class="text-sm text-gray-400">
                        Jumlah
                    </span>

                    <span
                        id="resultQuantityMatch"
                        class="text-sm font-medium text-white"
                    >
                        -
                    </span>

                </div>


                <div class="flex justify-between">

                    <span class="text-sm text-gray-400">
                        Kondisi
                    </span>

                    <span
                        id="resultCondition"
                        class="text-sm font-medium text-white"
                    >
                        -
                    </span>

                </div>

            </div>


            {{-- CATATAN --}}

            <div>

                <p class="text-xs text-gray-500">
                    Catatan Pemeriksaan
                </p>

                <div
                    id="resultNotes"
                    class="mt-2 p-4
                           text-sm text-gray-300
                           bg-[#2D3445]
                           rounded-lg"
                >

                    Tidak ada catatan.

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
                onclick="closeResultModal()"
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
    reference
) {

    document.getElementById(
        'modalProduct'
    ).textContent = product;


    document.getElementById(
        'modalQuantity'
    ).textContent =
        quantity + ' unit';


    document.getElementById(
        'modalReference'
    ).textContent = reference;


    document.getElementById(
        'inspectionForm'
    ).action =
        "{{ url('/staff-gudang/stok/masuk') }}"
        + "/"
        + id
        + "/konfirmasi";


    document.getElementById(
        'inspectionModal'
    ).classList.remove('hidden');


    document.getElementById(
        'inspectionModal'
    ).classList.add('flex');
}


function closeInspectionModal()
{
    document.getElementById(
        'inspectionModal'
    ).classList.add('hidden');


    document.getElementById(
        'inspectionModal'
    ).classList.remove('flex');
}


function openResultModal(
    product,
    quantity,
    reference,
    status,
    productMatch,
    attributeMatch,
    quantityMatch,
    condition,
    notes
) {

    document.getElementById(
        'resultProduct'
    ).textContent = product;


    document.getElementById(
        'resultQuantity'
    ).textContent =
        quantity + ' unit';


    document.getElementById(
        'resultReference'
    ).textContent = reference;


    const statusElement =
        document.getElementById(
            'resultStatus'
        );


    if (status === 'confirmed') {

        statusElement.textContent =
            'Sesuai';

        statusElement.className =
            'inline-flex mt-2 px-3 py-1.5 text-sm font-medium text-green-300 bg-green-900/30 rounded-full';

    } else {

        statusElement.textContent =
            'Tidak Sesuai';

        statusElement.className =
            'inline-flex mt-2 px-3 py-1.5 text-sm font-medium text-red-300 bg-red-900/30 rounded-full';

    }


    document.getElementById(
        'resultProductMatch'
    ).textContent =
        productMatch == 1
            ? 'Sesuai'
            : 'Tidak Sesuai';


    document.getElementById(
        'resultAttributeMatch'
    ).textContent =
        attributeMatch == 1
            ? 'Sesuai'
            : 'Tidak Sesuai';


    document.getElementById(
        'resultQuantityMatch'
    ).textContent =
        quantityMatch == 1
            ? 'Sesuai'
            : 'Tidak Sesuai';


    let conditionText = '-';


    if (condition === 'baik') {

        conditionText = 'Baik';

    } else if (condition === 'rusak') {

        conditionText = 'Rusak';

    } else if (condition === 'sebagian_rusak') {

        conditionText = 'Sebagian Rusak';

    }


    document.getElementById(
        'resultCondition'
    ).textContent =
        conditionText;


    document.getElementById(
        'resultNotes'
    ).textContent =
        notes && notes.trim() !== ''
            ? notes
            : 'Tidak ada catatan pemeriksaan.';


    document.getElementById(
        'resultModal'
    ).classList.remove('hidden');


    document.getElementById(
        'resultModal'
    ).classList.add('flex');
}


function closeResultModal()
{
    document.getElementById(
        'resultModal'
    ).classList.add('hidden');


    document.getElementById(
        'resultModal'
    ).classList.remove('flex');
}


/*
|--------------------------------------------------------------------------
| Tutup modal jika klik area luar
|--------------------------------------------------------------------------
*/

document
    .getElementById('inspectionModal')
    .addEventListener(
        'click',
        function (event) {

            if (event.target === this) {

                closeInspectionModal();

            }

        }
    );


document
    .getElementById('resultModal')
    .addEventListener(
        'click',
        function (event) {

            if (event.target === this) {

                closeResultModal();

            }

        }
    );

</script>

@endsection