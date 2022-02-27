@extends('layouts/master')
@section('info-halaman', 'Histori Penjualan')

@section('content')
<div id="main-content" class="d-flex flex-column">
    @if (count($dataTransaksi['data']) == 0)
        <div class="container-fluid center-item bg-white ellipsis">
            <span class="fw-bold">Belum Ada Transaksi Terjadi</span>
        </div>
    @else
        @foreach ($dataTransaksi as $dt)
        <h5 class="card-title fw-bold">Transasaksi : {{$dt['_id']}} </h5>
        <ul class="list-group">
            @foreach ($dt['produk'] as $dtproduk)
            <li class="list-group-item">
                <h5 class="card-title">{{$dtproduk['nama_produk']}}</h5>
                <div class="card-text">Rp. {{$dtproduk['harga_produk']}}</div>
                <div class="card-text">Terjual {{$dtproduk['jumlah_produk']}} item.</div>
            </li>
            @endforeach
        </ul>
        @endforeach
    @endif
</div>
</div>
@endsection