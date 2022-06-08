@extends('admin/layout_admin')
@section('info-halaman', 'Dashboard')

@section('content-CSS')
<link rel="stylesheet" href="{{ asset('assets/datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div id="main-content" class="d-flex flex-column">

    <div class="d-flex align-items-center bd-highlight mb-3">
        <div class="me-auto bd-highlight fs-5 fw-bold text-uppercase">Total Lapak : <span id="total_lapak"></span></div>
        <div class="bd-highlight border">
            <div class="input-daterange input-group" id="datepicker" >
                <input type="text" class="form-control" placeholder="Tanggal Mulai" aria-label="start date" name="start" id="start-date" onchange="lapakFilterTanggal()">
                <span class="input-group-text">sampai</span>
                <input type="text" class="form-control" placeholder="Tanggal Akhir" aria-label="end date" name="end" id="end-date" onchange="lapakFilterTanggal()">
            </div>
        </div>
      </div>

    <div class="card">
        <div class="card-body">
            
            <div class="table-responsive">
                <table style="border-spacing: 0 15px;" class="table table-borderless table-hover" id="tabel-lapak" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th scope="col" width="30">Nama Lapak</th>
                            <th scope="col" width="30%">Nama Umat</th>
                            <th scope="col" width="20%">No. WA</th>
                            <th scope="col" width="10%">Total Produk</th>
                            <th scope="col" width="10%">Total Penjualan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('content-JS')
<script src="{{ asset('assets/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/datepicker/locales/bootstrap-datepicker.id.min.js') }}"></script>

<script>
    let lapaks = <?php echo json_encode($arrLapak) ?>;

    function listLapak(lapaks) {
        let data = '<tr style="border-bottom: 1px solid #dcdde1;">' +
            '<td>' + lapaks["nama_lapak"] + '</td>' +
            '<td>' + lapaks["nama_user"] + '</td>' +
            '<td>' + lapaks["no_telepon_lapak"] + '</td>' +
            '<td>' + lapaks["total_produk"] + '</td>' +
            '<td>' + lapaks["penjualan_lapak"] + '</td>' +
            '</tr>';
        return data;
    }

    function lapakFilterTanggal() {
        const startDateTime = new Date($('#start-date').val());
        const endDateTime = new Date($('#end-date').val());


        $("#list-lapak").remove();
        $("#tabel-lapak").append('<tbody id="list-lapak"></tbody>');
        let count = 0;
        for (let index = 0; index < lapaks.length; index++) {
            if (lapaks[index]['created_date'] >= startDateTime.getTime() && lapaks[index]['created_date'] <= endDateTime.getTime()) {
                count++;
                $("#list-lapak").append(listLapak(lapaks[index]));
            }
            
        }
        if(count == 0){
            $("#list-lapak").append(
                '<tr style="border-bottom: 1px solid #dcdde1;">' +
                    '<td colspan="5" class="text-center fw-bold"> LAPAK TIDAK DITEMUKAN </td>' +
                '</tr>'
            );
        }
        $('#total_lapak').text(count);
    }

    $(document).ready(function() {
        $('.input-daterange').datepicker({
            format: "MM dd, yyyy",
            orientation: "bottom right",
            autoclose: true
        });

        $('#total_lapak').text(lapaks.length);

        $("#tabel-lapak").append('<tbody id="list-lapak"></tbody>');
        for (let index = 0; index < lapaks.length; index++) {
            const arrDate = lapaks[index]['created_date'].split("-");
            const d = new Date(arrDate[2],--arrDate[1],arrDate[0]);
            lapaks[index]['created_date'] = d.getTime();
            $("#list-lapak").append(listLapak(lapaks[index]));
        }

    });
</script>
@endsection