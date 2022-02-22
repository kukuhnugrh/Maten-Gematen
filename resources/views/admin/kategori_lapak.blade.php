@extends('admin/layout_admin')
@section('info-halaman', 'List Kategori')

@section('content-CSS')
<style>
    .card-color-dashboard {
        background-color: #8B0000 !important;
        color: white;
    }

    .actionKategori {
        margin: -5px 0px -5px 0px;
    }
</style>
@endsection

@section('content')
<div id="main-content" class="d-flex flex-column ">
    <button type="button" id="tambah-kategori" data-bs-toggle="modal" data-bs-target="#tambah-edit-kategori" class="btn btn-primary col-md-2 mb-3">Tambah Kategori</button>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-start">

            </div>
            <div class="table-responsive">
                <table class="table table-borderless table-hover " id="tabel-kategori" cellspacing="0" width="100%">

                    <thead>
                        <tr>
                            <th scope="col" width="80%">Nama Kategori</th>
                            <th scope="col" width="20%">Action</th>
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
            <!-- <form action="{{route('kategori-produk.createUpdateKategori')}}" method="POST" class="form-horizontal"> -->

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
                                <input type="text" class="form-control" name="namaKategori" id="namaKategori">
                                <div class="alert-message text-danger" id="namaKategoriError"></div>
                            </div>
                            <div class="form-group">
                                <label for="iconKategori">Nama Icon Kategori</label>
                                <input type="text" class="form-control" name="iconKategori" id="iconKategori" placeholder="Contoh: format-list-bulleted-square">
                                <div class="alert-message text-danger" id="iconKategoriError"></div>
                            </div>
                            <div>
                                <p class="d-flex justify-content-end" style="font-size: 0.875em;">Tampat mencari icon : <a href="https://materialdesignicons.com/" target="_blank">Material Design Icons</a></p>

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

@section('content-JS')
<script>
    let kategoris = <?php echo json_encode($kategoriProduk) ?>;

    function listKategori(kategori) {
        let dataKategori = kategori["_id"] + '_' + kategori["iconText"] + '_' + kategori["iconName"];
        let data = '<tr>' +
            '<td>' + kategori["iconName"] + '</td>' +
            '<td>' +
            '<button type="button" id="edit-kategori" data-bs-toggle="modal" data-id="' + dataKategori + '" data-bs-target="#tambah-edit-kategori" class="btn btn-outline-danger actionKategori">Edit</button>' +
            '</td>' +
            '</tr>';
        return data;
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
            $('.alert').css('display', 'none')
            $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
            $('#modal-judul').html("Tambah Kategori"); //valuenya tambah pegawai baru
            $('#namaKategoriError').text('');
            $('#iconKategoriError').text('');
            $('#tombol-simpan').val('tambah'); //tombol simpan
        });

        $('body').on('click', '#edit-kategori', function() {
            let data = $(this).data('id').split("_");

            $('.alert').css('display', 'none');
            $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
            $('#modal-judul').html("Edit Kategori");
            $('#namaKategoriError').text('');
            $('#iconKategoriError').text('');
            $('#tombol-simpan').val('ubah'); //tombol simpan

            $('#idKategori').val(data[0]);
            $('#iconKategori').val(data[1]);
            $('#namaKategori').val(data[2]);
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