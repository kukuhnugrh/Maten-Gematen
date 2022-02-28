@extends('layouts/master')
@section('info-halaman', 'Histori Penjualan')

@section('content')
<div id="main-content" class="d-flex flex-column">
    @if (count($dataTransaksi['data']) == 0)
    <div class="container-fluid center-item bg-white ellipsis">
        <span class="fw-bold">Belum Ada Transaksi Terjadi</span>
    </div>
    @else
    @foreach ($dataTransaksi['data'] as $dt)
    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item items-shadow">
            <h2 class="accordion-header" id="flush-heading{{$loop->index}}">
                <button class="accordion-button collapsed fw-bold text-dark shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$loop->index}}" aria-expanded="false" aria-controls="flush-collapse{{$loop->index}}">
                    Transaksi nomor {{ $dt['_id'] }}
                </button>
            </h2>
            <div id="flush-collapse{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$loop->index}}" data-bs-parent="#accordionFlushExample">

                <div class="row g-3">
                    <div class="col-6">
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover " id="tabel-kategori" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <th scope="col" width="30%">Pembeli</th>
                                        <td scope="col" width="60%">: {{ $dt['user']['nama'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col" width="30%">Status Transaksi</th>
                                        <td scope="col" width="60%">: {{ $dt['status'] }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col" width="30%">Total Harga</th>
                                        <td scope="col" width="60%">: 123456</td>
                                    </tr>
                                    <tr>
                                        <th scope="col" width="30%">Updated At</th>
                                        <td scope="col" width="60%">: {{ $dt['updated_date'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row m-2">
                            <div class='col-lg-4 col-sm-4'>
                                <div class='card box-shadow-product'>
                                    <img src="https://ecommerce-api.paroki-gmaklaten.web.id/gambar-produk/Prodok coba - 11645091395.jpg " class='rounded' width='100%' height=' 100px'>
                                    <div class='p-2'>
                                        <div style='height: 50px;'>
                                            <h4 class='card-title ellipsis'>Coba coba coba coba</h4>
                                        </div>
                                        <div class='info card-text'>
                                            <p class='d-block'>Rp. 123</p>
                                            <p class='d-block'>Jumlah: 10</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='col-lg-4 col-sm-4'>
                                <div class='card box-shadow-product'>
                                    <img src="https://ecommerce-api.paroki-gmaklaten.web.id/gambar-produk/Prodok coba - 11645091395.jpg " class='rounded' width='100%' height=' 100px'>
                                    <div class='p-2'>
                                        <div style='height: 50px;'>
                                            <h4 class='card-title ellipsis'>Coba</h4>
                                        </div>
                                        <div class='info card-text'>
                                            <p class='d-block'>Rp. 123</p>
                                            <p class='d-block'>Jumlah: 10</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
</div>
@endsection