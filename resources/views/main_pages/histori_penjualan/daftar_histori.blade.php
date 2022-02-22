@extends('layouts/master')

@section('content-CSS')
<style>
    .card {
        border: none;
        outline: none;
        background-color: #fff;
        border-radius: 20px;
        transition: transform .3s;
    }

    .text1 {
        font-size: 15px;
        color: #a39ea3;
    }

    .info {
        margin-top: 20px;
        line-height: 10px;
    }

    .ellipsis {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .active-color {
        color: black !important;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div id="main-content" class="d-flex flex-column">
    <div class="card ">
        <div class="card-header text-white" style="background-color: #8B0000;">
            <h4 class="fw-bold text-white">Histori Penjualan</h4>
        </div>
        <div class="card-body" id="body-histori">
            <div class="card ">
                <div class="card-body" id="body-produk">
                    <div class="row" id="semua-stok">
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
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection