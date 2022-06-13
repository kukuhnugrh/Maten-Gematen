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
            <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="form-control" placeholder="Tanggal Mulai" aria-label="start date" name="start"
                    id="start-date" onchange="lapakFilterTanggal()">
                <span class="input-group-text">sampai</span>
                <input type="text" class="form-control" placeholder="Tanggal Akhir" aria-label="end date" name="end"
                    id="end-date" onchange="lapakFilterTanggal()">
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table style="border-spacing: 0 15px;" class="table table-borderless table-hover" id="tabel-lapak"
                    cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th scope="col" width="25">Nama Lapak</th>
                            <th scope="col" width="25%">Nama Umat</th>
                            <th scope="col" width="10%">No. WA</th>
                            <th scope="col" width="15%">Tanggal Gabung</th>
                            <th scope="col" width="15%">Total Produk</th>
                            <th scope="col" width="10%">Total Sales</th>
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
<script src="{{ asset('assets/datepicker/js/format-date.js') }}"></script>
<script src="{{ asset('assets/datepicker/locales/bootstrap-datepicker.id.min.js') }}"></script>

<script>
    let lapaks = <?php echo json_encode($arrLapak) ?>;

    function listLapak(lapaks) {
        let data = '<tr style="border-bottom: 1px solid #dcdde1;">' +
            '<td>' + lapaks["nama_lapak"] + '</td>' +
            '<td>' + lapaks["nama_user"] + '</td>' +
            '<td>' + lapaks["no_telepon_lapak"] + '</td>' +
            '<td>' + lapaks["created_date"] + '</td>' +
            '<td>' + lapaks["total_produk"] + '</td>' +
            '<td>' + lapaks["penjualan_lapak"] + '</td>' +
            '</tr>';
        return data;
    }


    function lapakFilterTanggal() {
        $("#list-lapak").remove();
        $("#tabel-lapak").append('<tbody id="list-lapak"></tbody>');

        if ($('#start-date').val() == '' && $('#end-date').val() == '') {
            for (let index = 0; index < lapaks.length; index++) {
                $("#list-lapak").append(listLapak(lapaks[index]));
            }
        } else {
            const startDateTime = new Date($('#start-date').val());
            const endDateTime = new Date($('#end-date').val());

            let count = 0;
            for (let index = 0; index < lapaks.length; index++) {
                if (lapaks[index]['time_created'] >= startDateTime.getTime() && lapaks[index]['time_created'] <= endDateTime.getTime()) {
                    count++;
                    $("#list-lapak").append(listLapak(lapaks[index]));
                }

            }
            if (count == 0) {
                $("#list-lapak").append(
                    '<tr style="border-bottom: 1px solid #dcdde1;">' +
                    '<td colspan="6" class="text-center fw-bold"> LAPAK TIDAK DITEMUKAN </td>' +
                    '</tr>'
                );
            }
            $('#total_lapak').text(count);
        }
    }

    $(document).ready(function() {
        $('.input-daterange').datepicker({
            format: "MM dd, yyyy",
            orientation: "bottom right",
            autoclose: true,
            clearBtn: true,
        });

        $('#total_lapak').text(lapaks.length);

        lapaks.sort((a, b) => {
            const arrDate1 = a.created_date.split("-");
            const arrDate2 = b.created_date.split("-");
            let da = new Date(arrDate1[2], --arrDate1[1], arrDate1[0]);
            let db = new Date(arrDate2[2], --arrDate2[1], arrDate2[0]);
            return da - db;
        });

        $("#tabel-lapak").append('<tbody id="list-lapak"></tbody>');
        for (let index = 0; index < lapaks.length; index++) {
            const arrDate = lapaks[index]['created_date'].split("-");
            const d = new Date(arrDate[2], --arrDate[1], arrDate[0]);
            lapaks[index]['time_created'] = d.getTime();
            lapaks[index]['created_date'] = formatTanggal(d);
            $("#list-lapak").append(listLapak(lapaks[index]));
        }

    });
</script>
@endsection