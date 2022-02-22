<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Route::currentRouteName() }}</title>
    <!-- icon -->
    <link rel="icon" href="{{ asset('assets/img/icon.ico') }}" type="image/x-icon" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/gematen-lapak-main.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Document</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />


    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <!-- MDI Icons -->
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row mx-2">
            <div class="col">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-account"></i>
                    <span>Halo User</span>
                </div>
            </div>
            <div class="col">
                <a href="" id="logout-text" class="d-flex justify-content-end align-items-center text-decoration-none">
                    <i class="mdi mdi-logout"></i>
                    <span class="fw-bold text-dark">Logout</span>
                </a>
            </div>
            <form id="logout-form" action="{{  route('logout.post')  }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        <div class="row">
            <div class="col">
                <h1 class="text-center">Isi Data Lapak</h1>
            </div>
        </div>
        <div class="row">

            <form onsubmit="return validateForm()" action="{{route('create-lapak')}}" method="POST">
                @csrf
                <div class="d-flex justify-content-center">
                    <div class="col-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                Informasi Toko
                            </div>
                            <div class="card-body">

                                <div class="mb-2">
                                    <label for="namaLapak" class="form-label">*Nama Lapak</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control wajib" id="namaLapak" name="namaLapak" oninput="checkTotalHuruf(this.value, 'nama_lapak')">
                                        <span class="input-group-text"><span id="totalNamaLapak">0</span>/100</span>
                                    </div>
                                    <div class="form-text wajib-isi text-danger"></div>
                                    @error('namaLapak')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="mb-2">
                                    <label for="wilayahLapak" class="form-label">*Wilayah Lapak</label>
                                    <select class="form-select wajib" aria-label="Default select example" name="wilayahLapak" id="wilayahLapak">
                                        <option value="" selected>Pilih Wilayah</option>
                                        @foreach ($wilayahs as $wilayah)
                                        <option value="{{$wilayah['_id'] .'_'.$wilayah['nama_wilayah']}}">{{$wilayah['nama_wilayah']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-text wajib-isi text-danger"></div>
                                    @error('wilayahLapak')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <div class="d-flex bd-highlight">
                                        <label for="deskripsiLapak" class="me-auto bd-highlight form-label">*Deskripsi Lapak</label>
                                        <label class="bd-highlight form-label"><span id="totalDeskripsiLapak">0</span>/3000</span></label>
                                    </div>
                                    <textarea class="form-control wajib" name="deskripsiLapak" id="deskripsiLapak" style="height: 250px;resize: none;" maxlength="3000" oninput="checkTotalHuruf(this.value, 'deskripsi_lapak')"></textarea>
                                    <div class="form-text wajib-isi text-danger"></div>
                                    @error('deskripsiLapak')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="noHandphoneLapak" class="form-label">*Nomor WhatsApp</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control wajib" id="noHandphoneLapak" autocomplete="off" name="noHandphoneLapak" onkeypress="return cekKarakter(event)">
                                    </div>
                                    <div class="form-text wajib-isi text-danger"></div>
                                    @error('noHandphoneLapak')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                Alamat Toko
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <label for="kabupaten" class="form-label">Kabupaten</label>
                                    <input type="text" class="form-control" value="Klaten" disabled>
                                </div>
                                <div class="mb-2">
                                    <label for="kecamatan" class="form-label">*Kecamatan</label>
                                    <select class="form-select wajib" name="kecamatan" id="kecamatan">
                                        <option value="" selected>-- Pilih Kecamatan --</option>
                                    </select>
                                    <div class="form-text wajib-isi text-danger"></div>
                                    @error('kecamatan')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="kelurahan" class="form-label">*Kelurahan</label>
                                    <select class="form-select wajib" name="kelurahan" id="kelurahan">
                                        <option value="" selected>-- Pilih Kelurahan --</option>
                                    </select>
                                    <div class="form-text wajib-isi text-danger"></div>
                                    @error('kelurahan')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <label for="detailAlamat" class="form-label">*Detail Alamat</label>
                                    <input type="text" class="form-control wajib" name="detailAlamat" id="detailAlamat">
                                    <div class="form-text wajib-isi text-danger"></div>
                                    @error('detailAlamat')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="mb-2">
                                    <div class="d-flex bd-highlight ">
                                        <label for="titikLokasi" class="form-label me-auto bd-highlight">Lokasi Lapak</label>
                                        <div class="form-check form-switch bd-highlight">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                            <label class="form-check-label" for="flexSwitchCheckDefault" id="switchCheck">Tidak Aktif</label>
                                        </div>
                                    </div>

                                    <div id="mapid" style="height: 400px;"></div>

                                    <input type="text" class="form-control" name="latitude" id="latitude" hidden>
                                    <input type="text" class="form-control" name="longitude" id="longitude" hidden>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mb-3">
                            <button type="submit" class="btn btn-primary" id="btnsimpan">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script>
        let latitude = -7.7012443035017455;
        let longitude = 110.59937404767979;
        let cekLokasi = false;
        let marker = "";

        function checkTotalHuruf(value, jnsInput) {
            let total = value.length;
            if (jnsInput === 'nama_lapak') {
                $("#totalNamaLapak").text(total);
            } else if (jnsInput === 'deskripsi_lapak') {
                $("#totalDeskripsiLapak").text(total);
            }
        }

        function cekKarakter(e) {
            var charCode = (e.which) ? e.which : event.keyCode;
            if (charCode >= 48 && charCode <= 57) {
                return true
            }
            return false;
        }

        function resetLokasi() {
            $('#latitude').val("");
            $('#longitude').val("");
        }

        function validateForm() {
            let inputWajib = $('.wajib');
            let pesanError = $('.wajib-isi');
            let jumlahError = 0;

            for (let i = 0; i < inputWajib.length; i++) {
                pesanError[i].innerHTML = "";
                if (inputWajib[i].value == "") {
                    pesanError[i].innerHTML = "Kolom Wajib Di Isi";
                    jumlahError++;
                }
            }
            if (jumlahError != 0) {
                return false;
            }

        }


        $(document).ready(function() {
            $.ajax({
                url: "https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=3310",
                success: function(kecamatan) {
                    $.each(kecamatan.kecamatan, function(index, data) {
                        $('#kecamatan').append('<option value="' + data.id + '_' + data.nama + '">' + data.nama + '</option>');
                    });
                    $("#kecamatan").on("change", function(e) {
                        let kecamatanArr = e.target.value.split("_")
                        $('#kelurahan').empty();
                        $('#kelurahan').append('<option value="">-- Pilih Kelurahan --</option>');
                        if (e.target.value != "") {
                            $.ajax({
                                url: "https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=" + kecamatanArr[0],
                                success: function(kelurahan) {
                                    $.each(kelurahan.kelurahan, function(index, data) {
                                        $('#kelurahan').append('<option value="' + data.id + '_' + data.nama + '">' + data.nama + '</option>');
                                    });
                                }
                            });
                        }
                    });
                }
            });

            var mymap = L.map('mapid').setView([latitude, longitude], 13);
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWx2cmlhbGRvIiwiYSI6ImNrczhxdmF2ejA5bm8yeHFwcGhuN3N5b3AifQ.PhSSLBopyWGM0y2nsDDbOg', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'your.mapbox.access.token'
            }).addTo(mymap);

            $("#flexSwitchCheckDefault").click(function(e) {

                resetLokasi();
                cekLokasi = $("#flexSwitchCheckDefault").prop('checked');
                if (!cekLokasi) {
                    $("#switchCheck").text('Tidak Aktif')
                    marker.remove();
                } else {
                    $("#switchCheck").text('Aktif')
                    var curLocation = [latitude, longitude];
                    marker = new L.Marker(curLocation).addTo(mymap);
                    marker.dragging.enable();
                    $('#latitude').val(marker.getLatLng().lat);
                    $('#longitude').val(marker.getLatLng().lng);

                    marker.on('dragend', function(event) {
                        var position = marker.getLatLng();
                        marker.setLatLng(position, {
                            draggable: 'true'
                        }).bindPopup(position).update();
                        $('#latitude').val(marker.getLatLng().lat);
                        $('#longitude').val(marker.getLatLng().lng);

                    });
                }
            });

            mymap.on("click", function(e) {
                resetLokasi()
                if (cekLokasi) {
                    if (!marker) {
                        marker = L.marker(e.latlng).addTo(mymap);
                    } else {
                        marker.setLatLng(e.latlng);
                    }
                    $('#latitude').val(e.latlng.lat);
                    $('#longitude').val(e.latlng.lng);
                }
            });

            $("#logout-text").click(function(e) {
                e.preventDefault();
                $("#logout-form").submit();
            });

        });
    </script>
    <!-- Boostrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>