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
                <div class="row g-3 py-3">
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
                    <div class="col-6 center-horizontal">
                        @foreach ($dt['produk'] as $dtproduk )
                            <div id="produk-transaksi" class="row">
                                <div class="col-4 center-item">
                                    <img src="https://ecommerce-api.paroki-gmaklaten.web.id/gambar-produk/{{ $dtproduk['gambar_produk'][0] }}" class='rounded'>
                                </div>
                                <div class="col-8">
                                    <div class='row p-2 h-100'>
                                        <div class="col-6 h-100 d-flex flex-column justify-content-center">
                                            <div class="w-100">Nama produk</div>
                                            <div class="w-100">Harga produk</div>
                                            <div class="w-100">Jumlah produk</div>
                                        </div>
                                        <div class="col-6 h-100 d-flex flex-column justify-content-center">
                                            <div class="w-100">: {{ $dtproduk['nama_produk'] }}</div>
                                            <div class="w-100 text-danger">: Rp {{ $dtproduk['harga_produk'] }}</div>
                                            <div class="w-100">: {{ $dtproduk['jumlah_produk'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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