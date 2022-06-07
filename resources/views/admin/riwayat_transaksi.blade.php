@extends('admin/layout_admin')
@section('info-halaman', 'Daftar Riwayat Transaksi')

@section('content')
<div id="main-content" class="d-flex flex-column">
    @if (count($dataTransaksi) == 0)
    <div class="container-fluid center-item bg-white border-gematen flex-grow-1">
        <span class="fw-bold">Belum Ada Transaksi Terjadi</span>
    </div>
    @else
    <div class="accordion accordion-flush" id="accordionFlushExample">
    @foreach ($dataTransaksi as $dt)
        <div class="accordion-item items-shadow rounded mb-3">
            <h2 class="accordion-header rounded" id="flush-heading{{$loop->index}}">
                <button class="accordion-button collapsed fw-bold text-dark shadow-none rounded-pill bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$loop->index}}" aria-expanded="false" aria-controls="flush-collapse{{$loop->index}}">
                    {{ date('d F Y', strtotime($dt['updated_date'])) }} - Transaksi nomor {{ $dt['_id'] }}
                </button>
            </h2>
            <div id="flush-collapse{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$loop->index}}" data-bs-parent="#accordionFlushExample">
                <div class="row g-3 py-3">
                    <div class="col-4">
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover " id="tabel-kategori" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <th class="resposinve-text" scope="col" width="30%">Pembeli</th>
                                        <td class="resposinve-text" scope="col" width="60%">: {{ $dt['user']['nama'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="resposinve-text" scope="col" width="30%">Status Transaksi</th>
                                        <td class="resposinve-text" scope="col" width="60%">: {{ $dt['status'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="resposinve-text" scope="col" width="30%">Total Harga</th>
                                        <td class="resposinve-text" scope="col" width="60%">: Rp {{ $dt['total_harga'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="resposinve-text" scope="col" width="30%">Updated At</th>
                                        <td class="resposinve-text"scope="col" width="60%">: {{ date('d F Y', strtotime($dt['updated_date'])) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-8 center-horizontal d-flex flex-column">
                        @foreach ($dt['produk'] as $dtproduk )
                        <div id="produk-transaksi" class="row mb-3 pb-3 border-bottom border-secondary">
                            <div class="col-4 center-item">
                                <img src="https://dev-ecommerce-api.paroki-gmaklaten.web.id/gambar-produk/{{ $dtproduk['gambar_produk'][0] }}" class='rounded'>
                            </div>
                            <div class="col-8 table-responsive">
                                <table class="table table-borderless table-hover " id="tabel-kategori" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <th class="resposinve-text" scope="col" width="30%">Nama produk</th>
                                            <td class="resposinve-text" scope="col" width="5%">:</td>
                                            <td class="resposinve-text" scope="col" width="55%">{{ $dtproduk['nama_produk'] }}</td>
                                        </tr>
                                        <tr>
                                            <th class="resposinve-text" scope="col" width="30%">Harga produk</th>
                                            <td class="resposinve-text" scope="col" width="5%">:</td>
                                            <td class="resposinve-text" scope="col" width="55%">Rp {{ $dtproduk['harga_produk'] }}</td>
                                        </tr>
                                        <tr>
                                            <th class="resposinve-text" scope="col" width="30%">Jumlah produk</th>
                                            <td class="resposinve-text" scope="col" width="5%">:</td>
                                            <td class="resposinve-text" scope="col" width="55%">{{ $dtproduk['jumlah_produk'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>
    @endif
</div>
@endsection