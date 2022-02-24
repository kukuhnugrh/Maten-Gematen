@extends('layouts/master')
@section('info-halaman', 'List Produk')

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

    .box-shadow-product {
        box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
    }
</style>
@endsection

@section('content')
<div id="main-content" class="d-flex flex-column">

    <div class="d-flex justify-content-start mb-3">
        <input class="form-control me-2 w-50" type="search" id="search-input" placeholder="Search" aria-label="Search" oninput="searchAction(this.value)">
        <a href=" {{route('produkku.viewCreateProduk')}}" class="btn text-white col-md-2" style="background-color: #A13333;">Tambah Produk</a>
    </div>

    <div class="card ">
        <div class="card-header" style="background-color: #A13333">
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
            "<img src='" + "https://ecommerce-api.paroki-gmaklaten.web.id/gambar-produk/" + data.gambar_produk[0] + "' class='rounded' width='100%'' height='160px'>" +
            "<div class='p-2'>" +
            "<div style='height: 50px;'>" +
            "<h6 class='card-title ellipsis'>" + data.nama_produk + "</h6>" +
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
            $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center">Produk Tidak Ditemukan</div>');
        }
    }

    $(document).ready(function() {
        $("#data-produk").remove();
        if(data.length != 0) {
            $("#body-produk").append('<div class="row" id="data-produk"></div>');
            data.forEach(produk => {
                $("#data-produk").append(showProduk(produk));
            });
        } else {
            $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center">Belum Ada Produk Terdaftar</div>');
        }

        $("#semua-produk").click(function(e) {
            $("#data-produk").remove();
            if(data.length != 0) {
                $("#body-produk").append('<div class="row" id="data-produk"></div>');
                data.forEach(produk => {
                    $("#data-produk").append(showProduk(produk));
                });
            } else {
                $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center">Belum Ada Produk Terdaftar</div>');
            }
            $("#search-input").val("");
            $("#semua-produk").removeClass("active active-color").addClass("active active-color");
            $("#produk-tersedia").removeClass("active active-color");
            $("#produk-kosong").removeClass("active active-color");

        });

        $("#produk-tersedia").click(function(e) {
            $("#data-produk").remove();
            if(data.length != 0) {
                $("#body-produk").append('<div class="row" id="data-produk"></div>');
                var count = 0;
                data.forEach(produk => {
                    if (produk.penjualan_produk != 0) {
                        count++;
                        $("#data-produk").append(showProduk(produk));
                    }
                    if (count == 0){
                        $("#data-produk").remove();
                        $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center">Tidak Ada Produk Tersedia</div>');
                    }
                });
            } else {
                $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center">Belum Ada Produk Terdaftar</div>');
            }
            $("#search-input").val("");
            $("#semua-produk").removeClass("active active-color");
            $("#produk-tersedia").removeClass("active active-color").addClass("active active-color");
            $("#produk-kosong").removeClass("active active-color");

        });

        $("#produk-kosong").click(function(e) {
            $("#data-produk").remove();
            if(data.length != 0) {
                $("#body-produk").append('<div class="row" id="data-produk"></div>');
                var count = 0;
                data.forEach(produk => {
                    if (produk.penjualan_produk <= 0) {
                        count++;
                        $("#data-produk").append(showProduk(produk));
                    }
                    if (count == 0){
                        $("#data-produk").remove();
                        $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center">Tidak Ada Produk Kosong</div>');
                    }
                });
            } else {
                $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center">Belum Ada Produk Terdaftar</div>');
            }
            $("#search-input").val("");
            $("#semua-produk").removeClass("active active-color");
            $("#produk-tersedia").removeClass("active active-color");
            $("#produk-kosong").removeClass("active active-color").addClass("active active-color");
        });
    });
</script>
@endsection