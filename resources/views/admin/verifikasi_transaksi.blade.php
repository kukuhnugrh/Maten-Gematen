@extends('admin/layout_admin')
@section('info-halaman', 'List Transaksi Berlangsung')

@section('content')
<div id="main-content" class="d-flex flex-column">

    <div class="card">
        <div class="card-body">
            @if (count($dataTransaksi) == 0)
                <div class="container-fluid center-item bg-white ellipsis">
                    <span class="fw-bold">Tidak Ada Permintaan Verifikasi Transaksi</span>
                </div>
            @else
                @foreach($dataTransaksi as $dt)
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item items-shadow">
                        <h2 class="accordion-header" id="flush-heading{{$loop->index}}">
                            <button class="accordion-button collapsed fw-bold text-dark shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$loop->index}}" aria-expanded="false" aria-controls="flush-collapse{{$loop->index}}">
                                {{$dt['_id']}}
                            </button>
                        </h2>
                        <div id="flush-collapse{{$loop->index}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$loop->index}}" data-bs-parent="#accordionFlushExample">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover " id="tabel-kategori" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <th scope="col" width="30%">Wilayah</th>
                                            <td scope="col" width="60%">: {{$dt['wilayah_lapak']['nama_wilayah']}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col" width="30%">Alamat Lapak</th>
                                            <td scope="col" width="60%">: {{$dt['alamat_lapak']['detail_alamat']}}, Kel. {{$dt['alamat_lapak']['kelurahan']}}, Kec. {{$dt['alamat_lapak']['kecamatan']}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col" width="30%">Deskripsi Lapak</th>
                                            <td scope="col" width="60%">: {{$dt['deskripsi_lapak']}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col" width="30%">No Whatsapp</th>
                                            <td scope="col" width="60%">: {{$dt['no_telepon_lapak']}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-grid gap-2 p-2">
                                    <a href="" class="btn btn-primary" id="update-status-button" type="button">VERIFY</a>
                                </div>
                                <form id="status-update-form" action="{{  route('verifikasi-lapak.updateStatus')  }}" method="POST" class="d-none">
                                    @csrf
                                    <input type="text" value="{{$dt['_id']}}" name="idLapak" hidden>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@endsection

@section('content-JS')
<script>
    $("#update-status-button").click(function(e) {
        e.preventDefault();
        $("#status-update-form").submit();
    });
</script>
@endsection