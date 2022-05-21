@extends('admin/layout_admin')
@section('info-halaman', 'Daftar Permintaan Verifikasi Rating')

@section('content')
<div id="main-content" class="d-flex flex-column">

    <div class="card">
        <div class="card-body">
            @if (count($dataRating['data']) == 0)
            <div class="container-fluid center-item bg-white ellipsis">
                <span class="fw-bold">Tidak Ada Permintaan Verifikasi Rating</span>
            </div>
            @else
            @php $count = 0; @endphp
            <div id="accordionDataRating" class="row accordion accordion-flush">
                @foreach($dataRating['data'] as $dt)
                @if ($dt['status'] == "UNVERIFIED")
                @php $count++; @endphp
                <div class="col-lg-6 col-xl-6 p-0 px-2 mb-2">
                    <div class="accordion-item items-shadow">
                        <span class="accordion-header" id="flush-heading{{ $loop->index }}">
                            <button class="accordion-button collapsed fw-bold text-dark shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $loop->index }}" aria-expanded="false" aria-controls="flush-collapse{{ $loop->index }}">
                                Transaksi: {{ $dt['transaksi_id'] }}
                            </button>
                        </span>
                        <div id="flush-collapse{{ $loop->index }}" class="accordion-collapse collapse p-0" aria-labelledby="flush-heading{{ $loop->index }}" data-bs-parent="#accordionDataRating">
                            <div class="accordion-body px-0">
                                <div class="row g-0">
                                    <div class="col-md-4 d-flex flex-column justify-content-center">
                                        @if ($dt['gambar_rating'] == null)
                                        <img src="https://vignette3.wikia.nocookie.net/lego/images/a/ac/No-Image-Basic.png/revision/latest?cb=20130819001030" class="img-fluid" />
                                        @else
                                        <img src="https://ecommerce-api.paroki-gmaklaten.web.id/rating-produk/{{ $dt['gambar_rating'] }}" class="img-fluid" />
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body p-0">
                                            <div class="h-75 w-100">
                                                <table class="table table-borderless table-hover" id="tabel-kategori" cellspacing="0" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <th class="resposinve-text" scope="col" width="45%">Produk</th>
                                                            <td class="resposinve-text" scope="col" width="5%">:</td>
                                                            <td class="resposinve-text" scope="col" width="50%">{{ $dt['produk']['nama_produk'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="resposinve-text" scope="col" width="45%">Pembeli</th>
                                                            <td class="resposinve-text" scope="col" width="5%">:</td>
                                                            <td class="resposinve-text" scope="col" width="50%">{{ $dt['user']['nama_user'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="resposinve-text" scope="col" width="45%">Status</th>
                                                            <td class="resposinve-text" scope="col" width="5%">:</td>
                                                            <td class="resposinve-text" scope="col" width="50%">{{ $dt['status'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="resposinve-text" scope="col" width="45%">Nilai</th>
                                                            <td class="resposinve-text" scope="col" width="5%">:</td>
                                                            <td class="resposinve-text" scope="col" width="50%">{{ $dt['value'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="resposinve-text" scope="col" width="45%">Catatan</th>
                                                            <td class="resposinve-text" scope="col" width="5%">:</td>
                                                            <td class="resposinve-text" scope="col" width="50%">{{ $dt['catatan'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="resposinve-text" scope="col" width="45%">Tanggal Dibuat</th>
                                                            <td class="resposinve-text" scope="col" width="5%">:</td>
                                                            <td class="resposinve-text" scope="col" width="50%">{{ date('d F Y', strtotime($dt['updated_date'])) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="p-2">
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <form id="status-update-verifikasi-form" class="w-100 mb-2 center-item" action="{{  route('verifikasi-rating.updateStatus')  }}" method="POST">
                                                        @csrf
                                                        <input type="text" value="{{ $dt['_id'] }}" name="idRating" hidden>
                                                        <input type="text" value="VERIFIED" name="statusRating" hidden>
                                                        <button type="submit" class="btn btn-primary w-75">VERIFY</button>
                                                    </form>
                                                    <form id="status-update-tolak-form" class="w-100 mb-2 center-item" action="{{  route('verifikasi-rating.updateStatus')  }}" method="POST">
                                                        @csrf
                                                        <input type="text" value="{{ $dt['_id'] }}" name="idRating" hidden>
                                                        <input type="text" value="REJECTED" name="statusRating" hidden>
                                                        <button type="submit" class="btn btn-danger w-75">TOLAK</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @if ($count == 0)
            <div class="container-fluid center-item bg-white ellipsis">
                <span class="fw-bold">Tidak Ada Permintaan Verifikasi Rating</span>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>

@endsection

@section('content-JS')
<script>
    // $("#update-status-verifikasi-button").click(function(e) {
    //     e.preventDefault();
    //     $("#status-update-verifikasi-form").submit();
    // });
    // $("#update-status-tolak-button").click(function(e) {
    //     e.preventDefault();
    //     $("#status-update-tolak-form").submit();
    // });
</script>
@endsection