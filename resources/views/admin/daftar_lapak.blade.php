@extends('admin/layout_admin')
@section('info-halaman', 'Daftar Lapak')

@section('content')
<div id="main-content" class="d-flex flex-column">
    <div class="container-fluid p-0">
        <div class="input-group mb-3 w-50">
            <span class="input-group-text" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
            <input class="form-control" type="search" id="search-input" placeholder="Nama Lapak" aria-label="Nama Lapak" oninput="searchAction(this.value)">
        </div>
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
            <div id="body-lapak" class="row my-3 mx-2">

            </div>
        </div>
    </div>
</div>

@endsection

@section('content-JS')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    let data = <?php echo json_encode($arrLapak) ?>;
    let type = "SEMUA";

    function foreachLapak(type) {

        $('#body-lapak').empty();

        if (data.length == 0) {
            $('#body-lapak').append(
                '<div class="container-fluid center-item bg-white ellipsis">' +
                '<span class="fw-bold">Belum Ada Lapak Terdaftar</span>' +
                '</div>'
            );
        } else {
            var count = 0;
            data.forEach(lapak => {
                if (type == "SEMUA" || lapak.status_lapak == type) {
                    count++;
                    appendLapak(lapak);
                }
            });

            if (type != "SEMUA" && count == 0) {
                if (type == "ACTIVE") {
                    $('#body-lapak').append(
                        '<div class="container-fluid center-item bg-white ellipsis">' +
                        '<span class="fw-bold">Tidak Terdapat Lapak Aktif Saat Ini</span>' +
                        '</div>'
                    );
                } else {
                    $('#body-lapak').append(
                        '<div class="container-fluid center-item bg-white ellipsis">' +
                        '<span class="fw-bold">Tidak Terdapat Lapak NonAktif Saat Ini</span>' +
                        '</div>'
                    );
                }
            }
;        }
    }

    function appendLapak(data) {
        $('#body-lapak').append(
            '<div class="col-lg-6 col-xl-3 mb-4">' +
            '<div class="card bg-white text-dark h-100">' +
            '<div class="card-body">' +
            '<div class="d-flex justify-content-between align-items-center">' +
            '<div class="me-3">' +
            '<div class="text-lg fw-bold mb-2">' + data.nama_lapak + '</div>' +
            '<div class="text-dark-75 small badge bg-primary rounded-pill">' + data.status_lapak + '</div>' +
            '</div>' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="32"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 155.2C0 147.9 2.153 140.8 6.188 134.7L81.75 21.37C90.65 8.021 105.6 0 121.7 0H518.3C534.4 0 549.3 8.021 558.2 21.37L633.8 134.7C637.8 140.8 640 147.9 640 155.2C640 175.5 623.5 192 603.2 192H36.84C16.5 192 .0003 175.5 .0003 155.2H0zM64 224H128V384H320V224H384V464C384 490.5 362.5 512 336 512H112C85.49 512 64 490.5 64 464V224zM512 224H576V480C576 497.7 561.7 512 544 512C526.3 512 512 497.7 512 480V224z"/></svg>' +
            '</div>' +
            '</div>' +
            '<div class="card-footer d-flex align-items-center justify-content-between small">' +
            '<a class="text-dark stretched-link text-decoration-none" href="' + data.link_detail + '"> LIHAT DETAIL </a>' +
            ' </div>' +
            '</div>' +
            '</div>'
        );
    }

    function searchAction(value) {
        $("#body-lapak").empty();

        if (data.length != 0) {
            $("#body-lapak").append('<div class="row" id="data-lapak"></div>');
            let count = 0;
            let result;
            data.forEach(lapak => {
                result = lapak.nama_lapak.match(new RegExp(value, "gi"));
                if (result != null) {
                    count++;
                    if(lapak.status_lapak == type){
                        $("#data-lapak").append(appendLapak(lapak));
                    }
                } 
            });
            if ( count == 0 ) {
                $("#body-lapak").append('<div id="data-lapak" class="d-flex justify-content-center align-items-center"><span class="fw-bold">Lapak Tidak Ditemukan</span></div>');
            }
        } else {
            $("#body-lapak").append('<div id="data-lapak" class="d-flex justify-content-center align-items-center"><span class="fw-bold">Belum Ada Lapak Terdaftar</span></div>');
        }
    }

    $(document).ready(function() {
        $("#semua-status").css('display', '');
        $("#status-active").css('display', 'none');
        $("#status-inactive").css('display', 'none');
        
        foreachLapak("SEMUA");

        $("#semua-lapak").click(function(e) {
            type = "SEMUA";
            foreachLapak("SEMUA");
            $('#search-input').val("");
            $("#semua-status").css('display', '');
            $("#status-active").css('display', 'none');
            $("#status-inactive").css('display', 'none');

            $("#semua-lapak").removeClass("active active-color").addClass("active active-color");
            $("#lapak-aktif").removeClass("active active-color");
            $("#lapak-nonaktif").removeClass("active active-color");
        });

        $("#lapak-aktif").click(function(e) {
            type = "ACTIVE";
            foreachLapak("ACTIVE");
            $('#search-input').val("");
            $("#semua-status").css('display', 'none');
            $("#status-active").css('display', '');
            $("#status-inactive").css('display', 'none');

            $("#semua-lapak").removeClass("active active-color");
            $("#lapak-aktif").removeClass("active active-color").addClass("active active-color");
            $("#lapak-nonaktif").removeClass("active active-color");

        });
        $("#lapak-nonaktif").click(function(e) {
            type = "INACTIVE";
            foreachLapak("INACTIVE");
            $('#search-input').val("");
            $("#semua-status").css('display', 'none');
            $("#status-active").css('display', 'none');
            $("#status-inactive").css('display', '');

            $("#semua-lapak").removeClass("active active-color");
            $("#lapak-aktif").removeClass("active active-color");
            $("#lapak-nonaktif").removeClass("active active-color").addClass("active active-color");

        });


    });
</script>