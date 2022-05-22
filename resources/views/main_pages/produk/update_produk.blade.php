@extends('layouts/master')
@section('info-halaman', 'Detail Produk')

@section('content')
<div id="main-content" class="d-flex flex-column">
    @if (session('status_createUpdate_produk'))
    <div class="alert alert-success" role="alert">
        {{ session('status_createUpdate_produk') }}
    </div>
    @endif

    <form action="{{route('produkku.updateProduk')}}" onsubmit="return validateForm()" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card mb-3">
            <div class="card-header card-color-dashboard">
                Informasi Produk
            </div>
            <div class="card-body">
                <div class="col-11">
                    <input type="text" name="id_produk" value="{{Crypt::encryptString($detail_produk['_id'])}}" hidden>
                    <div class="row mb-2">
                        <label for="namaProduk" class="col-sm-3 form-label text-end">Nama Produk <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control wajib" name="nama_produk" id="namaProduk" placeholder="Masukkan Nama Produk" maxlength="100" autocomplete="off" oninput="checkTotalHuruf(this.value, 'nama_produk')" value="{{$detail_produk['nama_produk']}}">
                                <span class="input-group-text"><span id="totalNamaProduk">0</span>/100</span>
                            </div>
                            <div id="validateNamaProduk" class="form-text wajib-isi text-danger"></div>
                            @if ($errors->has('nama_produk'))
                            @foreach ($errors->get('nama_produk') as $message)
                            <div class="form-text text-danger">{{ $message }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="deskripsiProduk" class="col-sm-3 form-label text-end">Deskripsi Produk <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <textarea class="form-control deskripsi-produk wajib" name="deskripsi_produk" id="deskripsiProduk" maxlength="3000" oninput="checkTotalHuruf(this.value,'deskripsi_produk')" style="height: 250px; resize: none;">{{$detail_produk['deskripsi_produk']}}</textarea>
                            <div class="d-flex bd-highlight">
                                <div id="validateDeskripsiProduk" class="me-auto bd-highlight form-text wajib-isi text-danger"></div>
                                @if ($errors->has('deskripsi_produk'))
                                @foreach ($errors->get('deskripsi_produk') as $message)
                                <div class="form-text text-danger">{{ $message }}</div>
                                @endforeach
                                @endif
                                <label class="bd-highlight form-label"><span id="totalDeskripsiProduk">0</span>/3000</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="kategoriProduk" class="col-sm-3 form-label text-end">Kategori Produk <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-select wajib" name="kategori_produk" id="kategoriProduk">
                                <option value=""> -- Pilih Kategori -- </option>
                                @foreach ($kategoris as $kategori)
                                @if ($kategori['_id'] === $detail_produk['kategori_produk']['kategori_id'])
                                <option value="{{ $kategori['_id'] .'_'.$kategori['iconText'].'_'.$kategori['iconName'] }}" selected>{{ $kategori['iconName']}}</option>
                                @else
                                <option value="{{ $kategori['_id'] .'_'.$kategori['iconText'].'_'.$kategori['iconName'] }}">{{ $kategori['iconName']}}</option>
                                @endif
                                @endforeach
                            </select>
                            <div id="validateKategoriLapak" class="form-text wajib-isi text-danger"></div>
                            @if ($errors->has('kategori_produk'))
                            @foreach ($errors->get('kategori_produk') as $message)
                            <div class="form-text text-danger">{{ $message }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="selectKondisiProduk" class="col-sm-3 form-label text-end">Kondisi Produk</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="selectKondisiProduk" id="selectKondisiProduk">
                                @if ($detail_produk['kondisi_produk'] === 'baru')
                                <option value="baru" selected>Baru</option>
                                <option value="pernah dipakai">Pernah Dipakai</option>
                                @else
                                <option value="baru">Baru</option>
                                <option value="pernah dipakai" selected>Pernah Dipakai</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="merekProduk" class="col-sm-3 form-label text-end">Merek Produk</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" name="merek_produk" id="merekProduk" maxlength="50" autocomplete="off" oninput="checkTotalHuruf(this.value, 'merek_produk')" value="{{$detail_produk['merek_produk']}}">
                                <span class="input-group-text"><span id="totalMerekProduk">0</span>/50</span>
                            </div>
                            @if ($errors->has('merek_produk'))
                            @foreach ($errors->get('merek_produk') as $message)
                            <div class="form-text text-danger">{{ $message }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="selectKeamananProduk" class="col-sm-3 form-label text-end">Keamanan Produk</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="selectKeamananProduk" id="selectKeamananProduk">
                                @if ($detail_produk['keamanan_produk'] === 'aman')
                                <option value="aman" selected>Aman</option>
                                <option value="tidak aman">Mengandung baterai/magnet/cairan/bahan mudah terbakar</option>
                                @else
                                <option value="aman">Aman</option>
                                <option value="tidak aman" selected>Mengandung baterai/magnet/cairan/bahan mudah terbakar</option>
                                @endif

                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-sm-3 form-label text-end">Variasi Produk</label>
                        <div class="col-sm-9">
                            <div class="d-grid gap-2 mb-1">
                                <button class="btn btn-secondary" type="button" id="btnTambahVariasi">Tambah Variasi</button>
                            </div>
                            <div id="variasi"></div>
                            <div id="total_variasi"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-color-dashboard">
                Gambar Produk
            </div>
            <div class="card-body">
                <div class="col-11">

                    <div class="row mb-2">
                        <label for="inputKadaluarsaProduk" class="col-sm-3 form-label text-end">Gambar Produk <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" name="gambarInput" id="gambar-Input" value="" hidden>
                                <div class="row row-cols-3" id="tampung-gambar">
                                    <div class="position-relative col p-1 tampungGambar" style="width: 150px !important; height: 160px !important; align-items: center;" onmouseover="showIconDelete(0,'gambarProduk1')" onmouseout="hideIconDelete(0,'gambarProduk1')">
                                        <div class="d-flex align-items-center w-100 h-100 border border-dark iconTambah">
                                            <button class="btn w-100" type="button" onclick="$('#photo-add1').click()"><i class="mdi mdi-image-plus"></i></button>
                                            <input type="file" accept="image/png, image/jpeg" name="gambarProduk[]" id="photo-add1" class="d-none" onchange="tampilGambar(this,0,'gambarProduk1')">
                                        </div>
                                        <div class="position-absolute d-flex align-items-center border border-dark iconDelete d-none" style="width: 142px; height: 152px;">
                                            <button type="button" class="btn w-100" onclick="deleteImage(0,'gambarProduk1','photo-add1')"><i class="mdi mdi-delete"></i></button>
                                        </div>

                                    </div>

                                    <div class="position-relative col p-1 tampungGambar" style="width: 150px !important; height: 160px !important; align-items: center;" onmouseover="showIconDelete(1,'gambarProduk2')" onmouseout="hideIconDelete(1,'gambarProduk2')">
                                        <div class="d-flex align-items-center w-100 h-100 border border-dark iconTambah">
                                            <button class="btn w-100" type="button" onclick="$('#photo-add2').click()"><i class="mdi mdi-image-plus"></i></button>
                                            <input type="file" accept="image/png, image/jpeg" name="gambarProduk[]" id="photo-add2" class="d-none" onchange="tampilGambar(this,1,'gambarProduk2')">
                                        </div>
                                        <div class="position-absolute d-flex align-items-center border border-dark iconDelete d-none" style="width: 142px; height: 152px;">
                                            <button type="button" class="btn w-100" onclick="deleteImage(1,'gambarProduk2','photo-add2')"><i class="mdi mdi-delete"></i></button>
                                        </div>

                                    </div>

                                    <div class="position-relative col p-1 tampungGambar" style="width: 150px !important; height: 160px !important; align-items: center;" onmouseover="showIconDelete(2,'gambarProduk3')" onmouseout="hideIconDelete(2,'gambarProduk3')">
                                        <div class="d-flex align-items-center w-100 h-100 border border-dark iconTambah">
                                            <button class="btn w-100" type="button" onclick="$('#photo-add3').click()"><i class="mdi mdi-image-plus"></i></button>
                                            <input type="file" accept="image/png, image/jpeg" name="gambarProduk[]" id="photo-add3" class="d-none" onchange="tampilGambar(this,2,'gambarProduk3')">
                                        </div>
                                        <div class="position-absolute d-flex align-items-center border border-dark iconDelete d-none" style="width: 142px; height: 152px;">
                                            <button type="button" class="btn w-100" onclick="deleteImage(2,'gambarProduk3','photo-add3')"><i class="mdi mdi-delete"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="validateGambarProduk" class="me-auto bd-highlight form-text text-danger"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-color-dashboard">
                Informasi Penjualan
            </div>
            <div class="card-body">
                <div class="col-11">
                    <div class="row mb-2">
                        <label for="hargaProduk" class="col-sm-3 form-label text-end">Harga Produk <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control wajib" name="harga_produk" id="hargaProduk" autocomplete="off" placeholder="Masukkan Harga Produk" onkeyup="cekKarakter()" value="{{$detail_produk['harga_produk']}}" onpaste="return false;">
                            </div>
                            <div id="validateHargaProduk" class="form-text wajib-isi text-danger"></div>
                            @if ($errors->has('harga_produk'))
                            @foreach ($errors->get('harga_produk') as $message)
                            <div class="form-text text-danger">{{ $message }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="stokProduk" class="col-sm-3 form-label text-end">Stok Produk <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control wajib" name="stok_produk" id="stokProduk" autocomplete="off" onkeyup="cekKarakter(this.value, 'stokProduk')" value="{{$detail_produk['stok_produk']}}" onpaste="return false;">
                            </div>
                            <div id="validateStokProduk" class="form-text wajib-isi text-danger"></div>
                            @if ($errors->has('stok_produk'))
                            @foreach ($errors->get('stok_produk') as $message)
                            <div class="form-text text-danger">{{ $message }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-color-dashboard">
                Informasi Pengiriman
            </div>
            <div class="card-body">
                <div class="col-11">
                    <div class="row mb-2">
                        <label for="beratProduk" class="col-sm-3 form-label text-end">Berat Produk <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control wajib" name="berat_produk" id="beratProduk" autocomplete="off" placeholder="Masukkan Berat Produk" onkeyup="cekKarakter(this.value, 'beratProduk')" value="{{$detail_produk['berat_produk']}}" onpaste="return false;">
                                <span class="input-group-text">gram</span>
                            </div>
                            <div id="validateHargaProduk" class="form-text wajib-isi text-danger"></div>
                            @if ($errors->has('berat_produk'))
                            @foreach ($errors->get('berat_produk') as $message)
                            <div class="form-text text-danger">{{ $message }}</div>
                            @endforeach
                            @endif
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button class="btn" type="submit" id="btnSimpanProduk" style="background-color: #A13333; color: white;">Simpan Produk</button>
        </div>
    </form>




</div>
@endsection

@section('content-JS')
<script>
    let totalVariasi = 0;

    function checkTotalHuruf(value, jnsInput) {
        let total = value.length;
        if (jnsInput === 'nama_produk') {
            $("#totalNamaProduk").text(total);
        } else if (jnsInput === 'deskripsi_produk') {
            $("#totalDeskripsiProduk").text(total);
        } else if (jnsInput === 'merek_produk') {
            $("#totalMerekProduk").text(total);
        }
    }

    function deleteVariasi() {
        $('#variasi_' + totalVariasi).remove();
        totalVariasi--;
    }

    let dataGambar = new Array("", "", "");
    let sambungValue = "";

    function validateForm() {
        let inputWajib = $('.wajib');
        let pesanError = $('.wajib-isi');
        let jumlahError = 0;
        let inputTotalVariasi = "<input type='text' class='form-control' name='inptTotalVariasi' value='" + totalVariasi + "' hidden>";
        $("#total_variasi").append(inputTotalVariasi);
        $('#validateGambarProduk').text('');

        for (let index = 1; index <= dataGambar.length; index++) {
            if (dataGambar[index - 1] != "") {
                if (index == dataGambar.length) {
                    sambungValue = sambungValue + (dataGambar[(index - 1)]);
                } else {
                    sambungValue = sambungValue + (dataGambar[(index - 1)] + '_');
                }
                $('#gambar-Input').val(sambungValue);
            }
        }
        if ($('#gambar-Input').val() == "") {
            jumlahError++;
            $('#validateGambarProduk').text('Gambar Tidak Boleh Kosong');
        }

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

    function cekKarakter() {
        let data = $('#hargaProduk').val();
        data = data.replace(/[.,]/, "");
        if(data[0] == 0){
            $('#hargaProduk').val(data.substr(1, data.length));
        }else{
            let regex = /[a-zA-Z]/g;
            $('#hargaProduk').val(data.replace(regex, ""));
        }
        formatCurrency();
    }

    function formatCurrency() {
        let data = $('#hargaProduk').val();
        data = data.replace(/[.,]/, "");
        console.log(data);
        $('#hargaProduk').val(Intl.NumberFormat('en-US').format(data));
    }

    function itemVariasi(counter, inptSize, inptWarna, inptMotif) {
        var txt1 = "<div id='variasi_" + counter + "'>" +

            "<div class='d-flex bd-highlight'>" +
            "<p class='me-auto bd-highlight align-content-center'><strong>Variasi " + counter + "</strong></p>" +
            "<button type='button' class='btn-close bd-highlight' onclick='deleteVariasi()'></button>" +
            "</div>" +

            "<div class='mb-2'>" +
            "<label for='inputVariasiSize' class='form-label'>Size</label>" +
            "<div class = 'input-group' >" +
            "<input type='text' class='form-control' name='inputVariasiSize[]' id='inputVariasiSize_" + counter + "' value='" + inptSize + "'>" +
            "</div>" +
            "<div id='validateVariasiSize_" + counter + "' class='form-text '></div>" +
            "</div>" +

            "<div class='mb-2'>" +
            "<label for='inputVariasiWarna' class='form-label'>Warna</label>" +
            "<div class='input-group' >" +
            "<input type='text' class='form-control' name='inputVariasiWarna[]' id='inputVariasiWarna_" + counter + "' value='" + inptWarna + "'>" +
            "</div>" +
            "<div id='validateVariasiWarna_" + counter + "' class='form-text'></div> " +
            "</div>" +

            "<div class='mb-2'>" +
            "<label for='inputVariasiMotif' class='form-label'>Motif</label> " +
            "<div class='input-group' >" +
            "<input type='text' class='form-control' name='inputVariasiMotif[]' id='inputVariasiMotif_" + counter + "' value='" + inptMotif + "'>" +
            "</div>" +
            "<div id='validateVariasiMotif_" + counter + "' class='form-text'></div>" +
            "</div>" +

            "</div>";
        return txt1;
    }

    let variasi = <?php echo json_encode($detail_produk['variasi_produk']) ?>;
    if (variasi != null) {
        for (let index = 0; index < variasi.length; index++) {
            if (variasi[index]['size'] != null || variasi[index]['warna'] != null || variasi[index]['motif'] != null) {
                if (variasi[index]['size'] == null) {
                    variasi[index]['size'] = ''
                }
                if (variasi[index]['warna'] == null) {
                    variasi[index]['warna'] = ''
                }
                if (variasi[index]['motif'] == null) {
                    variasi[index]['motif'] = ''
                }
                totalVariasi++;
                $("#variasi").append(itemVariasi(totalVariasi, variasi[index]['size'], variasi[index]['warna'], variasi[index]['motif']));
            }
        }
    }



    function showIconDelete(index, IdGambar) {
        if ($('.iconDelete').eq(index).hasClass('hover')) {
            $('.iconDelete').eq(index).removeClass("d-none");
            $('#' + IdGambar).css("opacity", 0.2);
        }
    }

    function hideIconDelete(index, IdGambar) {
        if ($('.iconDelete').eq(index).hasClass('hover')) {
            $('.iconDelete').eq(index).addClass("d-none");
            $('#' + IdGambar).css("opacity", 1);
        }
    }

    function tampilGambar(input, keterangan, IdGambar) {
        if (input.files && input.files[0]) {
            var size = parseFloat(input.files[0].size / (1024 * 1024)).toFixed(2);
            if (size > 1) {
                alert('Gambar tidak boleh lebih dari 1 MB');
            } else {
                var reader = new FileReader();
                reader.onload = function(e) {
                    let gambar = '<img src="' + event.target.result + '" class="w-100 h-100" id="' + IdGambar + '" style="max-height: 100% !important;" alt="">';
                    $('.iconTambah').eq(keterangan).addClass("d-none");
                    $('.tampungGambar').eq(keterangan).append(gambar);
                    $('.iconDelete').eq(keterangan).addClass("hover");
                }
                reader.readAsDataURL(input.files[0]);
                dataGambar[keterangan] = "Data Baru";
            }
        }
    }

    function deleteImage(index, IdGambar, idInput) {
        if ($('.iconDelete').eq(index).hasClass('hover')) {
            $('#' + IdGambar).remove();
            $('.iconTambah').eq(index).removeClass("d-none");
            $('.iconDelete').eq(index).removeClass('hover').addClass("d-none");
            $('#' + idInput).val('');

            dataGambar[index] = "";
        }
    }

    $(document).ready(function() {
        formatCurrency();
        let assetGambar = <?php echo json_encode($assetGambar) ?>;
        let gambarDatabase = <?php echo json_encode($detail_produk['gambar_produk']) ?>;

        for (let index = 0; index < 3; index++) {
            if (assetGambar[index] != "") {
                dataGambar[index] = gambarDatabase[index]
                let gambar = '<img src="' + assetGambar[index] + '" class="w-100 h-100" id="gambarProduk' + (index + 1) + '" style="max-height: 100% !important;" alt="">';
                $('.iconTambah').eq(index).addClass("d-none");
                $('.tampungGambar').eq(index).append(gambar);
                $('.iconDelete').eq(index).addClass("hover");
            }
        }

        $("#totalNamaProduk").text($('#namaProduk').val().length);
        $("#totalDeskripsiProduk").text($('#deskripsiProduk').val().length);
        $("#totalMerekProduk").text($('#merekProduk').val().length);

        $('#btnTambahVariasi').on('click', function(e) {
            totalVariasi++;
            $("#variasi").append(itemVariasi(totalVariasi, '', '', ''));


        });

    });
</script>
@endsection