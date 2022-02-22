@extends('admin/layout_admin')
@section('info-halaman', 'List Lapak')

@section('content-CSS')
<style>
    .active-color {
        color: black !important;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div id="main-content" class="d-flex flex-column">
    <div class="container-fluid p-0">
        <div class="card ">
            <div class="card-header" style="background-color: #8B0000">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <button id="semua-lapak" class="nav-link active active-color" style="color: white;">Semua Lapak</button>
                    </li>
                    <li class="nav-item">
                        <button id="lapak-aktif" class="nav-link" style="color: white;">Lapak Aktif</button>
                    </li>
                    <li class="nav-item">
                        <button id="lapak-nonaktif" class="nav-link" style="color: white;">Lapak Nonaktif</button>
                    </li>
                </ul>
            </div>
            <div class="card-body" id="body-lapak">
                <ul class="list-group" id="semua-status">
                    @foreach($arrLapak as $lapak)
                    <a href="{{route('daftar-lapak.detaillapak',Crypt::encryptString($lapak['_id']))}}" style="text-decoration: none; color: black; font-weight: bold;">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$lapak['nama_lapak']}}
                            <span class="badge bg-primary rounded-pill">{{$lapak['status_lapak']}}</span>
                        </li>
                    </a>
                    @endforeach
                </ul>

                <ul class="list-group" id="status-active">
                    @foreach($arrLapak as $lapak)
                    @if($lapak['status_lapak'] == 'ACTIVE')
                    <a href="{{route('daftar-lapak.detaillapak',Crypt::encryptString($lapak['_id']))}}" style="text-decoration: none; color: black; font-weight: bold;">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$lapak['nama_lapak']}}
                            <span class="badge bg-primary rounded-pill">{{$lapak['status_lapak']}}</span>
                        </li>
                    </a>
                    @endif
                    @endforeach
                </ul>

                <ul class="list-group" id="status-inactive">
                    @foreach($arrLapak as $lapak)
                    @if($lapak['status_lapak'] == 'INACTIVE')
                    <a href="{{route('daftar-lapak.detaillapak',Crypt::encryptString($lapak['_id']))}}" style="text-decoration: none; color: black; font-weight: bold;">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$lapak['nama_lapak']}}
                            <span class="badge bg-primary rounded-pill">{{$lapak['status_lapak']}}</span>
                        </li>
                    </a>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@section('content-JS')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#semua-status").css('display', '');
        $("#status-active").css('display', 'none');
        $("#status-inactive").css('display', 'none');

        $("#semua-lapak").click(function(e) {
            $("#semua-status").css('display', '');
            $("#status-active").css('display', 'none');
            $("#status-inactive").css('display', 'none');

            $("#semua-lapak").removeClass("active active-color").addClass("active active-color");
            $("#lapak-aktif").removeClass("active active-color");
            $("#lapak-nonaktif").removeClass("active active-color");

        });
        $("#lapak-aktif").click(function(e) {
            $("#semua-status").css('display', 'none');
            $("#status-active").css('display', '');
            $("#status-inactive").css('display', 'none');

            $("#semua-lapak").removeClass("active active-color");
            $("#lapak-aktif").removeClass("active active-color").addClass("active active-color");
            $("#lapak-nonaktif").removeClass("active active-color");

        });
        $("#lapak-nonaktif").click(function(e) {
            $("#semua-status").css('display', 'none');
            $("#status-active").css('display', 'none');
            $("#status-inactive").css('display', '');

            $("#semua-lapak").removeClass("active active-color");
            $("#lapak-aktif").removeClass("active active-color");
            $("#lapak-nonaktif").removeClass("active active-color").addClass("active active-color");

        });


    });
</script>