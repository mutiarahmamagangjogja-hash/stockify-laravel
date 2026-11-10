@extends('layouts.manager-gudang')

@section('title', 'Stok Barang')

@section('content')


<div class="mb-4">

    <h3 class="fw-bold">
        Stok Barang
    </h3>

    <p class="text-muted">
        Pantau ketersediaan stok produk.
    </p>

</div>



<div class="card shadow-sm">

    <div class="card-body">


        <div class="table-responsive">


            <table class="table align-middle">


                <thead>

                    <tr>

                        <th>No</th>

                        <th>SKU</th>

                        <th>Produk</th>

                        <th>Stok</th>

                        <th>Minimum</th>

                        <th>Status Stok</th>

                    </tr>

                </thead>


                <tbody>


                    @forelse($products as $product)


                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $product->sku }}
                            </td>

                            <td>
                                {{ $product->name }}
                            </td>

                            <td>
                                {{ $product->stock }}
                                {{ $product->unit }}
                            </td>

                            <td>
                                {{ $product->minimum_stock }}
                                {{ $product->unit }}
                            </td>

                            <td>


                                @if($product->stock == 0)

                                    <span class="badge bg-danger">
                                        Habis
                                    </span>

                                @elseif(
                                    $product->stock
                                    <=
                                    $product->minimum_stock
                                )

                                    <span class="badge bg-warning text-dark">
                                        Menipis
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        Aman
                                    </span>

                                @endif


                            </td>

                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-muted py-4"
                            >
                                Belum ada data stok.
                            </td>

                        </tr>


                    @endforelse


                </tbody>


            </table>


        </div>


    </div>


</div>


@endsection
