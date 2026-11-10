@extends('layouts.app')

@section('title', 'Atribut Produk - Stockify')

@section('page-title', 'Atribut Produk')

@section('page-description', 'Kelola atribut dan nilai atribut produk Stockify')

@section('content')

<!-- HEADER -->

<div class="flex items-center justify-between mb-6">

    <div>

        <h2 class="text-2xl font-bold text-white">
            Atribut Produk
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Kelola atribut produk seperti ukuran, warna, merek, dan lainnya.
        </p>

    </div>

</div>


<!-- SUCCESS -->

@if(session('success'))

    <div
        class="p-4 mb-6
               text-sm text-green-300
               bg-green-900/30
               border border-green-800
               rounded-lg"
    >

        {{ session('success') }}

    </div>

@endif


<!-- ERROR -->

@if($errors->any())

    <div
        class="p-4 mb-6
               text-sm text-red-300
               bg-red-900/30
               border border-red-800
               rounded-lg"
    >

        <p class="mb-2 font-semibold">
            Terjadi kesalahan:
        </p>

        <ul class="pl-5 list-disc">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


<!-- TAMBAH ATRIBUT -->

<div
    class="p-5 mb-6
           bg-[#252B3A]
           border border-[#3A4254]
           rounded-lg"
>

    <div class="mb-5">

        <h3 class="text-lg font-semibold text-white">
            Tambah Atribut
        </h3>

        <p class="text-sm text-gray-400">
            Contoh: Ukuran, Warna, Merek, Material, Kapasitas.
        </p>

    </div>


    <form
        action="{{ route('atribut.store') }}"
        method="POST"
        class="grid grid-cols-12 gap-4"
    >

        @csrf


        <!-- NAMA -->

        <div class="col-span-4">

            <label
                class="block mb-2
                       text-sm font-medium
                       text-gray-300"
            >
                Nama Atribut
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Contoh: Warna"
                required
                class="w-full
                       px-4 py-2.5
                       text-sm text-white
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg
                       placeholder-gray-500
                       focus:outline-none
                       focus:ring-2
                       focus:ring-gray-600"
            >

        </div>


        <!-- DESKRIPSI -->

        <div class="col-span-6">

            <label
                class="block mb-2
                       text-sm font-medium
                       text-gray-300"
            >
                Deskripsi
            </label>

            <input
                type="text"
                name="description"
                value="{{ old('description') }}"
                placeholder="Contoh: Pilihan warna produk"
                class="w-full
                       px-4 py-2.5
                       text-sm text-white
                       bg-[#2D3445]
                       border border-[#3A4254]
                       rounded-lg
                       placeholder-gray-500
                       focus:outline-none
                       focus:ring-2
                       focus:ring-gray-600"
            >

        </div>


        <!-- BUTTON -->

        <div class="col-span-2 flex items-end">

            <button
                type="submit"
                class="w-full
                       px-4 py-2.5
                       text-sm font-medium
                       text-white
                       bg-[#111B36]
                       border border-[#3A4254]
                       rounded-lg
                       hover:bg-[#0B132B]"
            >
                + Tambah
            </button>

        </div>

    </form>

</div>


<!-- DAFTAR ATRIBUT -->

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
            Daftar Atribut
        </h3>

        <p class="text-sm text-gray-400">
            Kelola atribut dan nilai yang tersedia.
        </p>

    </div>


    <div class="divide-y divide-[#3A4254]">

        @forelse($attributes as $attribute)

            <div class="p-5">

                <!-- HEADER -->

                <div
                    class="flex items-center
                           justify-between
                           mb-4"
                >

                    <div>

                        <h4
                            class="text-base
                                   font-semibold
                                   text-white"
                        >
                            {{ $attribute->name }}
                        </h4>


                        @if($attribute->description)

                            <p
                                class="mt-1
                                       text-sm
                                       text-gray-400"
                            >
                                {{ $attribute->description }}
                            </p>

                        @endif

                    </div>


                    <div class="flex items-center gap-2">

                        <!-- EDIT -->

                        <button
                            type="button"
                            onclick="editAttribute(
                                {{ $attribute->id }},
                                @js($attribute->name),
                                @js($attribute->description)
                            )"
                            class="px-3 py-2
                                   text-xs
                                   text-blue-300
                                   bg-blue-900/30
                                   border border-blue-800
                                   rounded-lg
                                   hover:bg-blue-900/50"
                        >
                            Edit
                        </button>


                        <!-- DELETE -->

                        <form
                            action="{{ route(
                                'atribut.destroy',
                                $attribute
                            ) }}"
                            method="POST"
                            onsubmit="return confirm(
                                'Yakin ingin menghapus atribut ini beserta seluruh nilainya?'
                            )"
                            class="inline-block m-0"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="px-3 py-2
                                       text-xs
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

                </div>


                <!-- NILAI -->

                <div class="mb-4">

                    <p
                        class="mb-2
                               text-xs
                               font-medium
                               text-gray-400
                               uppercase"
                    >
                        Nilai Atribut
                    </p>


                    <div class="flex flex-wrap gap-2">

                        @forelse($attribute->values as $value)

                            <div
                                class="flex items-center
                                       gap-2
                                       px-3 py-1.5
                                       text-sm text-gray-200
                                       bg-[#2D3445]
                                       border border-[#3A4254]
                                       rounded-lg"
                            >

                                <span>
                                    {{ $value->value }}
                                </span>


                                <form
                                    action="{{ route(
                                        'atribut.value.destroy',
                                        $value
                                    ) }}"
                                    method="POST"
                                    onsubmit="return confirm(
                                        'Hapus nilai atribut ini?'
                                    )"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-400
                                               hover:text-red-300"
                                        title="Hapus"
                                    >
                                        ×
                                    </button>

                                </form>

                            </div>

                        @empty

                            <span
                                class="text-sm
                                       text-gray-500"
                            >
                                Belum ada nilai atribut.
                            </span>

                        @endforelse

                    </div>

                </div>


                <!-- TAMBAH NILAI -->

                <form
                    action="{{ route(
                        'atribut.value.store',
                        $attribute
                    ) }}"
                    method="POST"
                    class="flex gap-2"
                >

                    @csrf

                    <input
                        type="text"
                        name="value"
                        placeholder="Tambah nilai, contoh: Hitam"
                        required
                        class="flex-1
                               px-4 py-2
                               text-sm text-white
                               bg-[#2D3445]
                               border border-[#3A4254]
                               rounded-lg
                               placeholder-gray-500
                               focus:outline-none
                               focus:ring-2
                               focus:ring-gray-600"
                    >


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
                        + Tambah Nilai
                    </button>

                </form>

            </div>

        @empty

            <div class="px-6 py-12 text-center">

                <div
                    class="flex items-center
                           justify-center
                           w-16 h-16
                           mx-auto mb-4
                           bg-[#2D3445]
                           rounded-full"
                >
                    ⚙
                </div>

                <h3
                    class="text-lg
                           font-semibold
                           text-white"
                >
                    Belum ada atribut
                </h3>

                <p
                    class="mt-1
                           text-sm
                           text-gray-400"
                >
                    Tambahkan atribut pertama untuk produk.
                </p>

            </div>

        @endforelse

    </div>

</div>


<!-- EDIT MODAL -->

<div
    id="editModal"
    class="fixed inset-0 z-50
           hidden
           items-center
           justify-center
           bg-black/60"
>

    <div
        class="w-full max-w-lg
               p-6
               bg-[#252B3A]
               border border-[#3A4254]
               rounded-lg"
    >

        <div
            class="flex items-center
                   justify-between
                   mb-5"
        >

            <h3
                class="text-lg
                       font-semibold
                       text-white"
            >
                Edit Atribut
            </h3>


            <button
                type="button"
                onclick="closeEditModal()"
                class="text-2xl
                       text-gray-400
                       hover:text-white"
            >
                ×
            </button>

        </div>


        <form
            id="editAttributeForm"
            method="POST"
        >

            @csrf

            @method('PUT')


            <div class="mb-4">

                <label
                    class="block mb-2
                           text-sm font-medium
                           text-gray-300"
                >
                    Nama Atribut
                </label>

                <input
                    id="editName"
                    type="text"
                    name="name"
                    required
                    class="w-full
                           px-4 py-2.5
                           text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none"
                >

            </div>


            <div class="mb-5">

                <label
                    class="block mb-2
                           text-sm font-medium
                           text-gray-300"
                >
                    Deskripsi
                </label>

                <textarea
                    id="editDescription"
                    name="description"
                    rows="3"
                    class="w-full
                           px-4 py-2.5
                           text-sm text-white
                           bg-[#2D3445]
                           border border-[#3A4254]
                           rounded-lg
                           focus:outline-none"
                ></textarea>

            </div>


            <div class="flex justify-end gap-2">

                <button
                    type="button"
                    onclick="closeEditModal()"
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
                           rounded-lg"
                >
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection


@section('scripts')

<script>

function editAttribute(id, name, description)
{
    const modal = document.getElementById('editModal');

    const form = document.getElementById('editAttributeForm');

    const nameInput = document.getElementById('editName');

    const descriptionInput =
        document.getElementById('editDescription');


    form.action = `/atribut-produk/${id}`;

    nameInput.value = name ?? '';

    descriptionInput.value = description ?? '';


    modal.classList.remove('hidden');

    modal.classList.add('flex');
}


function closeEditModal()
{
    const modal = document.getElementById('editModal');

    modal.classList.add('hidden');

    modal.classList.remove('flex');
}


document
    .getElementById('editModal')
    ?.addEventListener('click', function(event)
    {
        if (event.target === this) {

            closeEditModal();

        }
    });

</script>

@endsection