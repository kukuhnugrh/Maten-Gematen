@extends('admin/layout_admin')
@section('info-halaman', 'Detail Lapak')

@section('content-CSS')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<style>
    .catatan-admin {
        height: 250px;
        resize: none;
    }

    .ellipsis {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-color-dashboard {
        background-color: #8B0000 !important;
        color: white;
    }
</style>
@endsection

@section('content')
<div id="main-content" class="d-flex flex-column">

    <div class="card mb-3">
        <div class="card-header card-color-dashboard">
            Catatan Admin
        </div>
        <div class="card-body">

            <form action="{{  route('daftar-lapak.updateLapak')  }}" method="POST">
                @csrf
                <input type="text" name="idLapak" value="{{$detailLapak['_id']}}" hidden>
                <input type="text" name="statusLapak" id="statusLapak" value="{{$detailLapak['status_lapak']}}" hidden>

                <div class="row mb-2">
                    <label for="statusLapak" class="col-sm-2 form-label">Status lapak</label>
                    <div class="col-sm-8">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status-lapak">
                            <label class="form-check-label" for="flexSwitchCheckChecked" id="status-lapak-text"></label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <label for="catatanAdmin" class="col-sm-2 form-label">Catatan Admin</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="catatanAdmin" id="catatanAdmin" style="height: 250px;resize: none;" maxlength="3000">{{$detailLapak['catatan_lapak']}}</textarea>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <button class="btn btn-primary" type="submit" id="btnSimpanProduk">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header card-color-dashboard">
            Informasi Lapak
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-hover " id="tabel-kategori" cellspacing="0" width="100%">

                    <tbody>
                        <tr>
                            <th scope="col" width="30%">Nama Lapak</th>
                            <td scope="col" width="60%">: {{$detailLapak['nama_lapak']}}</td>
                        </tr>
                        <tr>
                            <th scope="col" width="30%">Wilayah</th>
                            <td scope="col" width="60%">: {{$detailLapak['wilayah_lapak']['nama_wilayah']}}</td>
                        </tr>
                        <tr>
                            <th scope="col" width="30%">Alamat Lapak</th>
                            <td scope="col" width="60%">: {{$detailLapak['alamat_lapak']['detail_alamat']}}, Kel. {{$detailLapak['alamat_lapak']['kelurahan']}}, Kec. {{$detailLapak['alamat_lapak']['kecamatan']}}</td>
                        </tr>
                        <tr>
                            <th scope="col" width="30%">Deskripsi Lapak</th>
                            <td scope="col" width="60%">: {{$detailLapak['deskripsi_lapak']}}</td>
                        </tr>
                        <tr>
                            <th scope="col" width="30%">Total Produk</th>
                            <td scope="col" width="60%">: {{count($detailLapak['produk_lapak'])}}</td>
                        </tr>
                        <tr>
                            <th scope="col" width="30%">Total Penjualan</th>
                            <td scope="col" width="60%">: {{$detailLapak['penjualan_lapak']}}</td>
                        </tr>
                        <tr>
                            <th scope="col" width="30%">Lokasi Lapak</th>
                            @if($detailLapak['alamat_lapak']['longitude'] != null && $detailLapak['alamat_lapak']['latitude'] != null)
                            <td scope="col" width="60%">: Aktif</td>
                            @else
                            <td scope="col" width="60%">: Tidak Aktif</td>
                            @endif
                        </tr>

                    </tbody>
                </table>

                <div id="mapid" style="display: none;"></div>

            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-header card-color-dashboard">
            List Produk
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($detailLapak['produk_lapak'] as $produk)
                <div class="col-lg-3 col-sm-4 col-xs-2 mb-3">
                    <div class="card">
                        <img src="{{ asset('assets/img/produk.jpg') }}" class="rounded" width="100%" alt="">
                        <div class="p-2">
                            <div style="height: 50px;">
                                <h6 class="card-title ellipsis">{{$produk['nama_produk']}}</h6>
                            </div>
                            <div class="info card-text">
                                <p class="d-block">Rp. {{$produk['harga_produk']}}</p>
                                <span class="text1">Terjual {{$produk['penjualan_produk']}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

@section('content-JS')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script>
    let status_lapak = <?php echo json_encode($detailLapak['status_lapak']) ?>;

    $(document).ready(function() {
        if ($("#statusLapak").val() == 'ACTIVE') {
            $("#status-lapak").click();
            $("#status-lapak-text").text('ACTIVE');
        } else {
            $("#status-lapak-text").text('INACTIVE');
        }

        $("#status-lapak").click(function() {
            $("#status-lapak").prop('checked');
            if ($("#status-lapak").prop('checked')) {
                $("#statusLapak").val("ACTIVE");
                $("#status-lapak-text").text('ACTIVE');
            } else {
                $("#statusLapak").val("INACTIVE");
                $("#status-lapak-text").text('INACTIVE');
            }
        });


        // if (status_lapak == 'ACTIVE') {
        //     $("#status-lapak").click();
        //     $("#status-lapak-text").text('ACTIVE');
        //     console.log(status_lapak);
        // } else {
        //     $("#status-lapak-text").text('INACTIVE');
        // }

        // $("#status-lapak").click(function(e) {
        //     $("#status-lapak").prop('disabled', true);
        //     e.preventDefault();
        //     $("#status-lapak-form").submit();
        // });

        let latitudeDb = <?php echo json_encode($detailLapak['alamat_lapak']['latitude']) ?>;
        let longitude = <?php echo json_encode($detailLapak['alamat_lapak']['longitude']) ?>;

        if (latitudeDb != null && longitude != null) {
            $("#mapid").css({
                "display": "",
                "height": "400px"
            });
            var mymap = L.map('mapid').setView([latitudeDb, longitude], 13);
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWx2cmlhbGRvIiwiYSI6ImNrczhxdmF2ejA5bm8yeHFwcGhuN3N5b3AifQ.PhSSLBopyWGM0y2nsDDbOg', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'your.mapbox.access.token'
            }).addTo(mymap);
            mymap.scrollWheelZoom.disable();
            marker = new L.Marker([latitudeDb, longitude]).addTo(mymap);
        }


    });
</script>
@endsection