@extends('admin/layout_admin')
@section('info-halaman', 'List Lapak Baru')

@section('content')
<div id="main-content" class="d-flex flex-column">

    <div class="card">
        <div class="card-body">
            @if (count($dataLapak) == 0)
            <div class="container-fluid center-item bg-white ellipsis">
                <span class="fw-bold">Tidak Ada Permintaan Verifikasi Lapak</span>
            </div>
            @else
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach($dataLapak as $dl)
                <div class="accordion-item items-shadow mb-3">
                    <span class="accordion-header" id="flush-heading{{$loop->index}}">
                        <button class="accordion-button collapsed fw-bold text-dark shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$loop->index}}" aria-expanded="false" aria-controls="flush-collapse{{$loop->index}}">
                            {{$dl['nama_lapak']}}
                        </button>
                    </span>
                    <div id="flush-collapse{{$loop->index}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$loop->index}}" data-bs-parent="#accordionFlushExample">
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover " id="tabel-kategori" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <th class="resposinve-text" scope="col" width="45%">Nama Lapak</th>
                                        <td class="resposinve-text" scope="col" width="5%">:</td>
                                        <td class="resposinve-text" scope="col" width="50%">{{ $dl['nama_lapak'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="resposinve-text" scope="col" width="45%">Pemilik</th>
                                        <td class="resposinve-text" scope="col" width="5%">:</td>
                                        <td class="resposinve-text" scope="col" width="50%">{{ $dl['nama_user'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="resposinve-text" scope="col" width="45%">Paroki</th>
                                        <td class="resposinve-text" scope="col" width="5%">:</td>
                                        <td class="resposinve-text" scope="col" width="50%">{{ $dl['paroki_lapak']['nama_paroki'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="resposinve-text" scope="col" width="45%">Alamat Lapak</th>
                                        <td class="resposinve-text" scope="col" width="5%">:</td>
                                        <td class="resposinve-text" scope="col" width="50%">{{ $dl['alamat_lapak']['detail_alamat'] }}, Kel. {{ $dl['alamat_lapak']['kelurahan'] }}, Kec. {{$dl['alamat_lapak']['kecamatan']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="resposinve-text" scope="col" width="45%">Deskripsi Lapak</th>
                                        <td class="resposinve-text" scope="col" width="5%">:</td>
                                        <td class="resposinve-text" scope="col" width="50%">{{ $dl['deskripsi_lapak'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="resposinve-text" scope="col" width="45%">No WhatsApp Lapak</th>
                                        <td class="resposinve-text" scope="col" width="5%">:</td>
                                        <td class="resposinve-text" scope="col" width="50%">{{ $dl['no_telepon_lapak'] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="resposinve-text" scope="col" width="45%">Created At</th>
                                        <td class="resposinve-text" scope="col" width="5%">:</td>
                                        <td class="resposinve-text" scope="col" width="50%">{{ date('d F Y', strtotime( $dl['created_date'] ))}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="m-2">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <a href="" class="btn btn-primary d-flex justify-content-center align-items-center" id="update-status-button" type="button">VERIFIED</a>
                                </div>

                                <form id="status-update-form" action="{{  route('verifikasi-lapak.updateStatus')  }}" method="POST" class="d-none">
                                    @csrf
                                    <label for="idLapak" hidden></label>
                                    <input type="text" value="{{$dl['_id']}}" id="idLapak" name="idLapak" hidden>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('content-JS')
<script>
    function sendFormData(index, event) {

    }


    $("#update-status-button").click(function(e) {
        e.preventDefault();
        $("#status-update-form").submit();
    });
</script>
@endsection