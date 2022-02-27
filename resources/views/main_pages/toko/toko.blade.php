@extends('layouts/master')
@section('info-halaman', 'Detail Lapak')
@section('content-CSS')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
@endsection
@section('content')
<div id="main-content" class="d-flex flex-column">
    @if (session('status_update_lapak'))
    <div class="alert alert-success" role="alert">
        {{ session('status_update_lapak') }}
    </div>
    @endif

    <form onsubmit="return validateForm()" action="{{route('tokoku.updateLapak')}}" method="POST">
        @csrf
        @method('PUT')
        <div class="card mb-3">
            <div class="card-header card-color-dashboard">
                Informasi Toko
            </div>
            <div class="card-body">
                <div class="col-11">
                    <div class="row mb-2">
                        <label for="namaLapak" class="col-sm-3 form-label">*Nama Lapak</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control wajib" id="namaLapak" name="namaLapak" oninput="checkTotalHuruf(this.value, 'nama_lapak')" value="{{$lapak['data']['nama_lapak']}}">
                                <span class="input-group-text"><span id="totalNamaLapak">0</span>/100</span>
                            </div>
                            <div class="form-text wajib-isi text-danger"></div>
                            @error('namaLapak')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="wilayahLapak" class="col-sm-3 form-label">*Wilayah Lapak</label>
                        <div class="col-sm-9">
                            <select class="form-select wajib" aria-label="Default select example" name="wilayahLapak" id="wilayahLapak">
                                <option value="" selected>Pilih Wilayah</option>
                                @foreach ($wilayahs as $wilayah)
                                @if ($wilayah['_id'] === $lapak['data']['wilayah_lapak']['wilayah_id'])
                                <option value="{{$wilayah['_id'] .'_'.$wilayah['nama_wilayah']}}" selected>{{$wilayah['nama_wilayah']}}</option>
                                @else
                                <option value="{{$wilayah['_id'] .'_'.$wilayah['nama_wilayah']}}">{{$wilayah['nama_wilayah']}}</option>
                                @endif
                                @endforeach
                            </select>
                            <div class="form-text wajib-isi text-danger"></div>
                            @error('wilayahLapak')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="row mb-2">
                        <label for="deskripsiLapak" class="col-sm-3 form-label">*Deskripsi Lapak</label>
                        <div class="col-sm-9">
                            <textarea class="form-control wajib" name="deskripsiLapak" id="deskripsiLapak" style="height: 250px;resize: none;" maxlength="3000" oninput="checkTotalHuruf(this.value, 'deskripsi_lapak')">{{$lapak['data']['deskripsi_lapak']}}</textarea>
                            <div class="d-flex bd-highlight">
                                <div id="validateDeskripsiLapak" class="me-auto bd-highlight form-text wajib-isi text-danger"></div>
                                @error('deskripsiLapak')
                                <div class="me-auto bd-highlight form-text text-danger">{{ $message }}</div>
                                @enderror
                                <label class="bd-highlight form-label"><span id="totalDeskripsiLapak">0</span>/3000</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="noHandphoneLapak" class="col-sm-3 form-label">*Nomor WhatsApp</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control wajib" id="noHandphoneLapak" autocomplete="off" name="noHandphoneLapak" value="{{$lapak['data']['no_telepon_lapak']}}" onkeypress="return cekKarakter(event)">
                            <div class="d-flex bd-highlight">
                                <div id="validatenoHandphoneLapak" class="me-auto bd-highlight form-text wajib-isi text-danger"></div>
                                @error('noHandphoneLapak')
                                <div class="me-auto bd-highlight form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">

            <div class="card-header card-color-dashboard">
                Alamat Toko
            </div>
            <div class="card-body">
                <div class="col-11">
                    <div class="row mb-2">
                        <label for="kabupaten" class="col-sm-3 form-label">Kabupaten</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="Klaten" disabled>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="kecamatan" class="col-sm-3 form-label">*Kecamatan</label>
                        <div class="col-sm-9">
                            <select class="form-select wajib" name="kecamatan" id="kecamatan">
                                <option value="" selected>-- Pilih Kecamatan --</option>
                            </select>
                            <div class="form-text wajib-isi text-danger"></div>
                            @error('kecamatan')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="kelurahan" class="col-sm-3 form-label">*Kelurahan</label>
                        <div class="col-sm-9">
                            <select class="form-select wajib" name="kelurahan" id="kelurahan">
                                <option value="" selected>-- Pilih Kelurahan --</option>
                            </select>
                            <div class="form-text wajib-isi text-danger"></div>
                            @error('kelurahan')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="row mb-2">
                        <label for="detailAlamat" class="col-sm-3 form-label">*Detail Alamat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control wajib" name="detailAlamat" id="detailAlamat" value="{{$lapak['data']['alamat_lapak']['detail_alamat']}}">
                            <div class="form-text wajib-isi text-danger"></div>
                            @error('detailAlamat')
                            <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>

                    <div class="row mb-2">
                        <label for="titikLokasi" class="col-sm-3 form-label">Lokasi Lapak</label>
                        <div class="col-sm-9">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                <label class="form-check-label" for="flexSwitchCheckDefault" id="switchCheck">Tidak Aktif</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="mapid"></div>

                <input type="text" class="form-control" name="latitude" id="latitude" hidden>
                <input type="text" class="form-control" name="longitude" id="longitude" hidden>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn" style="background-color: #A13333; color: white;" id="btnsimpan">Simpan</button>
        </div>
    </form>


</div>
@endsection

@section('content-JS')

<script>
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

    function cekKelurahan(kecamatan) {
        $('#kelurahan').empty();
        $('#kelurahan').append('<option value="">-- Pilih Kelurahan --</option>');
        if (kecamatan != "") {
            $.ajax({
                url: "https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=" + kecamatan,
                success: function(kelurahan) {
                    $kelurahanDb = <?php echo json_encode($lapak['data']['alamat_lapak']['kelurahan']) ?>;
                    $.each(kelurahan.kelurahan, function(index, data) {
                        if ($kelurahanDb == data.nama) {
                            $('#kelurahan').append('<option value="' + data.id + '_' + data.nama + '" selected>' + data.nama + '</option>');
                        } else {
                            $('#kelurahan').append('<option value="' + data.id + '_' + data.nama + '">' + data.nama + '</option>');
                        }

                    });
                }
            });
        }
    }

    function activeMaps(mymap, inptlatitude, inptlongitude) {
        if (inptlatitude == null && inptlongitude == null) {
            inptlatitude = -7.7012443035017455;
            inptlongitude = 110.59937404767979;
        }
        resetLokasi();
        mymap.setView([inptlatitude, inptlongitude], 13);
        if (cekLokasi) {
            $("#switchCheck").text('Aktif');
            $('#mapid').css("height", "400px");
            var curLocation = [inptlatitude, inptlongitude];
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
        } else {
            $("#switchCheck").text('Tidak Aktif');
            $('#mapid').css("height", "");
            marker.remove();
        }
    }

    $(document).ready(function() {

        $("#totalNamaLapak").text($('#namaLapak').val().length);
        $("#totalDeskripsiLapak").text($('#deskripsiLapak').val().length);

        $.ajax({
            url: "https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=3310",
            success: function(kecamatan) {
                $kecamatanDb = <?php echo json_encode($lapak['data']['alamat_lapak']['kecamatan']) ?>;
                $.each(kecamatan.kecamatan, function(index, data) {
                    if ($kecamatanDb == data.nama) {
                        $('#kecamatan').append('<option value="' + data.id + '_' + data.nama + '" selected>' + data.nama + '</option>');
                    } else {
                        $('#kecamatan').append('<option value="' + data.id + '_' + data.nama + '">' + data.nama + '</option>');
                    }

                });
                let slctKecamatan = $('#kecamatan').val().split("_");
                if (slctKecamatan[0] != "") {
                    cekKelurahan(slctKecamatan[0]);
                }
                $("#kecamatan").on("change", function(e) {
                    let kecamatanArr = e.target.value.split("_");
                    cekKelurahan(kecamatanArr[0]);
                });

            }
        });


        let latitudeDb = <?php echo json_encode($lapak['data']['alamat_lapak']['latitude']) ?>;
        let longitudeDb = <?php echo json_encode($lapak['data']['alamat_lapak']['longitude']) ?>;

        var mymap = L.map('mapid').setView([-7.7012443035017455, 110.59937404767979], 13);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWx2cmlhbGRvIiwiYSI6ImNrczhxdmF2ejA5bm8yeHFwcGhuN3N5b3AifQ.PhSSLBopyWGM0y2nsDDbOg', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'your.mapbox.access.token'
        }).addTo(mymap);

        if (latitudeDb != null && longitudeDb != null) {
            $("#flexSwitchCheckDefault").click()
            cekLokasi = $("#flexSwitchCheckDefault").prop('checked');

            activeMaps(mymap, latitudeDb, longitudeDb);
        }

        $("#flexSwitchCheckDefault").click(function(e) {
            cekLokasi = $("#flexSwitchCheckDefault").prop('checked');
            activeMaps(mymap, latitudeDb, longitudeDb);
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
    });
</script>
@endsection