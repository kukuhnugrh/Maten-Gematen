@extends('admin/layout_admin')
@section('info-halaman', 'List Kategori')

@section('content-CSS')
<style>
    .actionKategori {
        margin: -5px 0px -5px 0px;
    }
</style>
@endsection

@section('content')
<div id="main-content" class="d-flex flex-column ">
    <div class="d-flex">
        <button type="button" id="tutorial-menambah-kategori" data-bs-toggle="modal" data-bs-target="#tutorial-menambah" class="btn btn-warning col-md-2 mb-3 me-3">Tutorial Menambah Kategori</button>
        <button type="button" id="tambah-kategori" data-bs-toggle="modal" data-bs-target="#tambah-edit-kategori" class="btn btn-primary col-md-2 mb-3 me-3">Tambah Kategori</button>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table style="border-spacing: 0 15px;" class="table table-borderless table-hover" id="tabel-kategori" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th scope="col" width="10%">Ikon</th>
                            <th scope="col" width="70%">Nama Kategori</th>
                            <th scope="col" width="20%" class="center-item w-100">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('tambahanModal')

<!-- MODAL EDIT KATEGORI -->
<div class="modal fade" id="tambah-edit-kategori" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header card-color-dashboard">
                    <h5 class="modal-title" id="modal-judul">Tambah Kategori</h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible fade show" id="alert-tambah-edit" role="alert"></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control" name="idKategori" id="idKategori">
                            <div class="form-group">
                                <label for="namaKategori">Nama Kategori</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="namaKategori" id="namaKategori" maxlength="15" autocomplete="off" oninput="checkTotalHuruf(this.value, 'kategori_produk')">
                                    <span class="input-group-text"><span id="totalKategoriProduk">0</span>/15</span>
                                </div>
                                <div class="alert-message text-danger" id="namaKategoriError"></div>
                            </div>
                            <div class="form-group">
                                <label for="iconKategori">Nama Icon Kategori</label>
                                <input type="text" class="form-control" name="iconKategori" id="iconKategori" placeholder="Contoh: format-list-bulleted-square">
                                <div class="alert-message text-danger" id="iconKategoriError"></div>
                            </div>
                            <div>
                                <p class="d-flex justify-content-end" style="font-size: 0.875em;">Tempat mencari icon : <a href="https://materialdesignicons.com/" target="_blank">Material Design Icons</a></p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="tombol-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan" value="tambah-kategori">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- AKHIR MODAL -->
@endsection

@section('tutorialMenambahKategoriModal')

<div class="modal fade" id="tutorial-menambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-tutorial" name="form-tutorial" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header card-color-dashboard">
                    <h5 class="modal-title" id="modal-judul">Tutorial Menambah Kategori</h5>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table style="border-spacing: 0 15px;" class="table table-borderless table-hover" id="tabel-kategori" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" width="20%">Langkah</th>
                                    <th scope="col" width="80%" class="center-item w-100">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #dcdde1;">
                                    <td class="text-center">1.</td>
                                    <td>Buka Halaman Website <a href="https://materialdesignicons.com/" target="_blank">Material Design Icons</a> Untuk Mencari Icon</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dcdde1;">
                                    <td class="text-center">2.</td>
                                    <td>Cari Icon Yang Diinginkan Dengan Menginputkan Nama Icon Pada Kolom Search <a href="https://mande.paroki-gmaklaten.web.id/assets/img/Halaman_utama_MDI.png" target="_blank"><img width="50%" src="{{ asset('assets/img/Halaman_utama_MDI.png') }}"></a></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dcdde1;">
                                    <td class="text-center">3.</td>
                                    <td>Pilih Ikon Yang Sesuai Dengan Yang Diinginkan <a href="https://mande.paroki-gmaklaten.web.id/assets/img/Pilih_Ikon_Sesuai.png" target="_blank"><img width="50%" src="{{ asset('assets/img/Halaman_utama_MDI.png') }}"></a></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dcdde1;">
                                    <td class="text-center">4.</td>
                                    <td>Salin Nama Ikon Dan Tempelkan Pada Nama Ikon Kategori<a href="https://mande.paroki-gmaklaten.web.id/assets/img/Salin_dan_Tempelkan.png" target="_blank"><img width="50%" src="{{ asset('assets/img/Halaman_utama_MDI.png') }}"></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="tombol-cancel" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('content-JS')
<script>
    let kategoris = <?php echo json_encode($kategoriProduk) ?>;

    function listKategori(kategori) {
        let dataKategori = kategori["_id"] + '_' + kategori["iconText"] + '_' + kategori["iconName"];
        let data = '<tr style="border-bottom: 1px solid #dcdde1;">' +
            '<td><i class="mdi mdi-' + kategori["iconText"] + '"></i></td>' +
            '<td>' + kategori["iconName"] + '</td>' +
            '<td>' +
            '<button type="button" id="edit-kategori" data-bs-toggle="modal" data-id="' + dataKategori + '" data-bs-target="#tambah-edit-kategori" class="btn btn-outline-success actionKategori center-item w-100">Edit</button>' +
            '</td>' +
            '</tr>';
        return data;
    }

    function checkTotalHuruf(value, jnsInput) {
        let total = value.length;
        $("#totalKategoriProduk").text(total);

    }

    $(document).ready(function() {
        $("#tabel-kategori").append('<tbody id="list-kategori"></tbody>');
        for (let index = 0; index < kategoris.length; index++) {
            $("#list-kategori").append(listKategori(kategoris[index]));
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#tambah-kategori").click(function() {
            $("#totalKategoriProduk").text(0);
            $('.alert').css('display', 'none');
            $('#idKategori').val('');
            $('#iconKategori').val('');
            $('#namaKategori').val('');
            $('#modal-judul').html("Tambah Kategori"); //valuenya tambah pegawai baru
            $('#namaKategoriError').text('');
            $('#iconKategoriError').text('');
            $('#tombol-simpan').val('tambah'); //tombol simpan
        });

        $("#tutorial-menambah-kategori").click(function() {
            $('.alert').css('display', 'none')
            $('#form-tutorial').trigger("reset"); //mereset semua input dll didalamnya
            $('#modal-judul').html("Tutorial Tambah Kategori"); //valuenya tambah pegawai baru
        });

        $('body').on('click', '#edit-kategori', function() {
            let data = $(this).data('id').split("_");

            $('.alert').css('display', 'none');
            $('#idKategori').val('');
            $('#iconKategori').val('');
            $('#namaKategori').val('');
            $('#modal-judul').html("Edit Kategori");
            $('#namaKategoriError').text('');
            $('#iconKategoriError').text('');
            $('#tombol-simpan').val('ubah'); //tombol simpan

            $('#idKategori').val(data[0]);
            $('#iconKategori').val(data[1]);
            $('#namaKategori').val(data[2]);

            $("#totalKategoriProduk").text($('#namaKategori').val().length);
        });

        $("#tombol-simpan").click(function(e) {
            $('#tombol-simpan').html('Proses...'); //tombol simpan
            $('.alert').css('display', 'none');
            $("#tombol-simpan").prop("disabled", true);
            $("#tombol-cancel").prop("disabled", true);
            $('#namaKategoriError').text('');
            $('#iconKategoriError').text('');
            e.preventDefault();
            $.ajax({
                data: $('#form-tambah-edit').serialize(), //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
                url: "{{route('kategori-produk.createUpdateKategori')}}", //url simpan data
                type: "POST", //karena simpan kita pakai method POST
                dataType: 'json', //data tipe kita kirim berupa JSON
                success: function(data) { //jika berhasil
                    $("#list-kategori").remove();
                    $("#tabel-kategori").append('<tbody id="list-kategori"></tbody>');
                    $.get('kategori-produk/get-kategori', function(kategori) {
                        for (let index = 0; index < kategori.length; index++) {
                            $("#list-kategori").append(listKategori(kategori[index]));
                        }
                        if ($('#tombol-simpan').val() == "tambah") {
                            $('#alert-tambah-edit').text('Data berhasil di tambah')

                        } else {
                            $('#alert-tambah-edit').text('Data berhasil di ubah')
                        }
                        $('.alert').css('display', '')
                        $("#tombol-simpan").prop("disabled", false);
                        $("#tombol-cancel").prop("disabled", false);
                        $('#tombol-simpan').html('Simpan'); //tombol simpan
                    })

                },
                error: function(data) {
                    $('.alert').css('display', 'none')
                    $("#tombol-simpan").prop("disabled", false);
                    $("#tombol-cancel").prop("disabled", false);
                    $('#tombol-simpan').html('Simpan'); //tombol simpan

                    $('#namaKategoriError').text(data.responseJSON.iconName);
                    $('#iconKategoriError').text(data.responseJSON.iconText);

                }
            });
        });


    });
</script>
@endsection