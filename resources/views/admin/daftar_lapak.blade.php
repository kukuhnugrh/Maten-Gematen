@extends('admin/layout_admin')
@section('info-halaman', 'List Lapak')

@section('content')
<div id="main-content" class="d-flex flex-column">
    <div class="container-fluid p-0">
        <div class="card ">
            <div class="card-header">
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
                    @if (count($arrLapak) == 0 )
                        <div class="container-fluid center-item bg-white ellipsis">
                            <span class="fw-bold">Belum Ada Lapak Terdaftar</span>
                        </div>
                    @else
                        @foreach($arrLapak as $lapak)
                        <a href="{{route('daftar-lapak.detaillapak',Crypt::encryptString($lapak['_id']))}}" style="text-decoration: none; color: black; font-weight: bold;">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{$lapak['nama_lapak']}}
                                <span class="badge bg-primary rounded-pill">{{$lapak['status_lapak']}}</span>
                            </li>
                        </a>
                        @endforeach
                    @endif
                </ul>

                <ul class="list-group" id="status-active">
                    @if (count($arrLapak) == 0 )
                        <div class="container-fluid center-item bg-white ellipsis">
                            <span class="fw-bold">Belum Ada Lapak Terdaftar</span>
                        </div>
                    @else
                        @php $count = 0 @endphp
                        @foreach($arrLapak as $lapak)
                            @if($lapak['status_lapak'] == 'ACTIVE')
                                @php ($count++) @endphp
                                <a href="{{route('daftar-lapak.detaillapak',Crypt::encryptString($lapak['_id']))}}" style="text-decoration: none; color: black; font-weight: bold;">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{$lapak['nama_lapak']}}
                                        <span class="badge bg-primary rounded-pill">{{$lapak['status_lapak']}}</span>
                                    </li>
                                </a>
                            @endif
                            @if ($count == 0)
                                <div class="container-fluid center-item bg-white ellipsis">
                                    <span class="fw-bold">Tidak Terdapat Lapak Aktif Saat Ini</span>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </ul>

                <ul class="list-group" id="status-inactive">
                    @if (count($arrLapak) == 0 )
                        <div class="container-fluid center-item bg-white ellipsis">
                            <span class="fw-bold">Belum Ada Lapak Terdaftar</span>
                        </div>
                    @else
                        @php $count = 0 @endphp
                        @foreach($arrLapak as $lapak)
                            @if($lapak['status_lapak'] == 'INACTIVE')
                                @php ($count++) @endphp
                                <a href="{{route('daftar-lapak.detaillapak',Crypt::encryptString($lapak['_id']))}}" style="text-decoration: none; color: black; font-weight: bold;">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{$lapak['nama_lapak']}}
                                        <span class="badge bg-primary rounded-pill">{{$lapak['status_lapak']}}</span>
                                    </li>
                                </a>
                            @endif
                        @endforeach
                        @if ($count == 0)
                            <div class="container-fluid center-item bg-white ellipsis">
                                <span class="fw-bold">Tidak Terdapat Lapak NonAktif Saat Ini</span>
                            </div>
                        @endif
                    @endif
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