@extends('layouts/master')
@section('info-halaman', 'Daftar Produk')

@section('content')
<div id="main-content" class="d-flex flex-column">
    @if ($status_lapak == 'UNVERIFIED')
    <div class="alert alert-warning w-100 py-3 mt-0 mb-3" role="alert">
        Penambahan Produk Hanya Dapat Dilakukan Setelah Lapak Terverifikasi
    </div>
    @endif
    <div class="d-flex justify-content-start align-items-center mb-3">
        <div class="input-group w-50">
            <span class="input-group-text" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size: 1em;"></i></span>
            <input class="form-control me-2" type="search" id="search-input" placeholder="Search" aria-label="Search" oninput="searchAction(this.value)">
        </div>
        @if ($status_lapak == 'UNVERIFIED')
        <a href="#" class='btn btn-secondary text-white center-item w-25'>Tambah Produk</a>
        @else
        <a href="{{ route('produkku.viewCreateProduk') }}" class='btn btn-primary text-white center-item w-25'>Tambah Produk</a>
        @endif

    </div>

    <div class="card ">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <button id="semua-produk" class="nav-link active active-color" style="color: white;" onclick="getStatusProduk('SEMUA')">Semua Produk</button>
                </li>
                <li class="nav-item">
                    <button id="produk-tersedia" class="nav-link" style="color: white;" onclick="getStatusProduk('TERSEDIA')">Produk Tersedia</button>
                </li>
                <li class="nav-item">
                    <button id="produk-kosong" class="nav-link" style="color: white;" onclick="getStatusProduk('KOSONG')">Produk Kosong</button>
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

    let statusProduk = 'SEMUA';

    function getStatusProduk(status) {
        statusProduk = status;
    }

    function getNamaProduk(produk, value) {
        let count = 0;
        let result = produk.nama_produk.match(new RegExp(value, "gi"));
        if (result != null) {
            count++
            $("#data-produk").append(showProduk(produk));
        }
        return count;
    }

    function showProduk(data) {
        var produk_html = "<div class='col-lg-3 col-md-6 col-xs-2 mb-3'>" +
            "<a href='" + data.link_detail + "' style='text-decoration: none; color: black;'>" +
            "<div class='card box-shadow-product'>" +
            "<img src='" + "https://ecommerce-api.paroki-gmaklaten.web.id/gambar-produk/" + data.gambar_produk[0] + "' class='rounded contain' width='100%' height='200px'>" +
            "<div class='p-2'>" +
            "<div>" +
            "<div class='responsive-text ellipsis' style='min-height: 100px;'>" + data.nama_produk + "</div>" +
            "</div>" +
            "<div class='info card-text'>" +
            "<p class='d-block text-danger fw-bold'>Rp. " + data.harga_produk + "</p>" +
            "<span class='text1'>Terjual " + data.penjualan_produk + "</span>" +
            "</div>" +
            "</div>" +
            "</div>" +
            " </a>" +
            " </div>";
        return produk_html;
    }

    function searchAction(value) {
        $("#body-produk").empty();
        $("#data-produk").remove();

        if (data.length != 0) {
            $("#body-produk").append('<div class="row" id="data-produk"></div>');
            let count = 0;
            data.forEach(produk => {
                if (statusProduk == 'SEMUA') {
                    count += getNamaProduk(produk, value);
                } else if (statusProduk == 'TERSEDIA') {
                    if (produk.stok_produk != 0) {
                        count += getNamaProduk(produk, value);
                    }
                } else {
                    if (produk.stok_produk <= 0) {
                        count += getNamaProduk(produk, value);
                    }
                }

            });
            if (count == 0) {
                $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center"><span class="fw-bold">Produk Tidak Ditemukan</span></div>');
            }
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

                });
                if (count == 0) {
                    $("#data-produk").remove();
                    $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center"><span class="fw-bold">Tidak Ada Produk Tersedia</span></div>');
                }
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

                });
                if (count == 0) {
                    $("#data-produk").remove();
                    $("#body-produk").append('<div id="data-produk" class="d-flex justify-content-center align-items-center"><span class="fw-bold">Tidak Ada Produk Kosong</span></div>');
                }
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