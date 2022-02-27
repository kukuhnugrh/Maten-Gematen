@extends('layouts/master')
@section('info-halaman', 'Dashboard')

@section('content')
<div id="main-content" class="d-flex flex-column">
    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-xl-4 col-md-4 mb-3">
                    <div class="card h-100 shadow py-2 card-color-dashboard">
                        <div class="card-body text-white">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="fw-bold text-uppercase mb-1">Total Produk</div>
                                    <div class="h5 mb-0 fw-bold">{{count($lapak['data']['produk_lapak'])}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="mdi mdi-cube text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4 mb-3">
                    <div class="card h-100 shadow py-2 card-color-dashboard">
                        <div class="card-body text-white">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="fw-bold text-uppercase mb-1">Produk Terjual</div>
                                    <div class="h5 mb-0 fw-bold">{{$lapak['data']['penjualan_lapak']}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="mdi mdi-shopping text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4 mb-3">
                    <div class="card h-100 shadow py-2 card-color-dashboard">
                        <div class="card-body text-white">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="fw-bold text-uppercase mb-1">Rating Lapak</div>
                                    <div class="h5 mb-0 fw-bold">2</div>
                                </div>
                                <div class="col-auto">
                                    <i class="mdi mdi-star-circle text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-xl-5 col-lg-12 col-md-12" style="max-height: 600px;">
                    <div class="card mb-3" style="height: 350px;">
                        <div class="card-header card-color-dashboard">
                            Produk Terlaris
                        </div>
                        <div class="card-body">
                            @if (count($produk) == 0)
                                <div class="container-fluid d-flex justify-content-center align-items-center h-100 fw-bold">
                                    Belum ada Produk Terjual
                                </div>
                            @else
                                @foreach ( $produk as $p )
                                    <ul class="list-group list-group-flush p-0">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $p['nama_produk'] }}
                                            <span class="badge bg-primary rounded-pill">{{ $p['penjualan_produk'] }}</span>
                                        </li>
                                    </ul>
                                    @endforeach
                            @endif
                            
                        </div>
                    </div>
                </div>

                <div class="col-xl-7 col-lg-12 col-md-12" style="max-height: 600px;">

                    <div class="card" style="height: 95.6%;">
                        <div class="card-header card-color-dashboard">
                            Catatan Admin
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                Status Lapak
                                <span class="badge bg-primary rounded-pill">{{$lapak['data']['status_lapak']}}</span>
                            </div>
                            <textarea class="border border-1 rounded-1 w-100 p-2" style="height: 80%; resize: none;" disabled>{{$lapak['data']['catatan_lapak']}}</textarea>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>


</div>
@endsection

@section('content-JS')
@endsection