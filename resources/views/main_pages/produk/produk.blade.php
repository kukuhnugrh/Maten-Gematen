@extends('layouts/master')
@section('info-halaman', 'List Produk')

@section('content')
<div id="main-content" class="d-flex flex-column">

    <div class="d-flex justify-content-start mb-3">
        <input class="form-control me-2 w-50" type="search" id="search-input" placeholder="Search" aria-label="Search" oninput="searchAction(this.value)">
        <a href=" {{route('produkku.viewCreateProduk')}}" class="btn btn-primary text-white col-md-2">Tambah Produk</a>
    </div>

    <div class="card ">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <button id="semua-produk" class="nav-link active active-color" style="color: white;">Semua Produk</button>
                </li>
                <li class="nav-item">
                    <button id="produk-tersedia" class="nav-link" style="color: white;">Produk Tersedia</button>
                </li>
                <li class="nav-item">
                    <button id="produk-kosong" class="nav-link" style="color: white;">Produk Kosong</button>
                </li>
            </ul>
        </div>
        <div class="card-body" id="body-produk">
            <div class="row" id="data-produk">
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-JS')
<script>
    let data = <?php echo json_encode($response_produk) ?>;

    function showProduk(data) {
        var produk_html = "<div class='col-lg-3 col-sm-4 col-xs-2 mb-3'>" +
            "<a href='" + data.link_detail + "' style='text-decoration: none; color: black;'>" +
            "<div class='card box-shadow-product'>" +
            "<img src='" + "https://ecommerce-api.paroki-gmaklaten.web.id/gambar-produk/" + data.gambar_produk[0] + "' class='rounded' width='100%' height='160px'>" +
            "<div class='p-2'>" +
            "<div style='height: 50px;'>" +
            "<h4 class='card-title ellipsis'>" + data.nama_produk + "</h4>" +
            "</div>" +
            "<div class='info card-text'>" +
            "<p class='d-block'>Rp. " + data.harga_produk + "</p>" +
            "<span class='text1'>Terjual " + data.penjualan_produk + "</span>" +
            "</div>" +
            "</div>" +
            "</div>" +
            " </a>" +
            " </div>";
        return produk_html;
    }

    function searchAction(value) {
        $("#data-produk").remove();

        if (data.length != 0) {
            $("#body-produk").append('<div class="row" id="data-produk"></div>');
            data.forEach(produk => {
                let result = produk.nama_produk.match(new RegExp(value, "gi"));
                if (result != null) {
                    $("#data-produk").append(showProduk(produk));
                }
            });
        } else {
            $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center"><span class="fw-bold">Produk Tidak Ditemukan</span></div>');
        }
    }

    $(document).ready(function() {
        $("#data-produk").remove();
        if (data.length != 0) {
            $("#body-produk").append('<div class="row" id="data-produk"></div>');
            data.forEach(produk => {
                $("#data-produk").append(showProduk(produk));
            });
        } else {
            $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center"><span class="fw-bold">Belum Ada Produk Terdaftar</span></div>');
        }

        $("#semua-produk").click(function(e) {
            $("#data-produk").remove();
            if (data.length != 0) {
                $("#body-produk").append('<div class="row" id="data-produk"></div>');
                data.forEach(produk => {
                    $("#data-produk").append(showProduk(produk));
                });
            } else {
                $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center"><span class="fw-bold">Belum Ada Produk Terdaftar</span></div>');
            }
            $("#search-input").val("");
            $("#semua-produk").removeClass("active active-color").addClass("active active-color");
            $("#produk-tersedia").removeClass("active active-color");
            $("#produk-kosong").removeClass("active active-color");

        });

        $("#produk-tersedia").click(function(e) {
            $("#data-produk").remove();
            if (data.length != 0) {
                $("#body-produk").append('<div class="row" id="data-produk"></div>');
                var count = 0;
                data.forEach(produk => {
                    if (produk.stok_produk != 0) {
                        count++;
                        $("#data-produk").append(showProduk(produk));
                    }
                    if (count == 0) {
                        $("#data-produk").remove();
                        $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center"><span class="fw-bold">Tidak Ada Produk Tersedia</span></div>');
                    }
                });
            } else {
                $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center"><span class="fw-bold">Belum Ada Produk Terdaftar</span></div>');
            }
            $("#search-input").val("");
            $("#semua-produk").removeClass("active active-color");
            $("#produk-tersedia").removeClass("active active-color").addClass("active active-color");
            $("#produk-kosong").removeClass("active active-color");

        });

        $("#produk-kosong").click(function(e) {
            $("#data-produk").remove();
            if (data.length != 0) {
                $("#body-produk").append('<div class="row" id="data-produk"></div>');
                var count = 0;
                data.forEach(produk => {
                    if (produk.stok_produk <= 0) {
                        count++;
                        $("#data-produk").append(showProduk(produk));
                    }
                    if (count == 0) {
                        $("#data-produk").remove();
                        $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center"><span class="fw-bold">Tidak Ada Produk Kosong</span></div>');
                    }
                });
            } else {
                $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center"><span class="fw-bold">Belum Ada Produk Terdaftar</span></div>');
            }
            $("#search-input").val("");
            $("#semua-produk").removeClass("active active-color");
            $("#produk-tersedia").removeClass("active active-color");
            $("#produk-kosong").removeClass("active active-color").addClass("active active-color");
        });
    });
</script>
@endsection