<?php

namespace App\Http\Controllers\Admin\Verifikasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class VerifikasiController extends Controller
{
    //
    public function indexVerifikasiLapak()
    {
        $dataLapak = Http::withToken(session('_jwtToken'))->get('https://dev-ecommerce-api.paroki-gmaklaten.web.id/api/lapak/get')->collect();
        $tmp_lapak_verify = array();

        foreach ($dataLapak['data'] as $lapak) {
            if ($lapak['status_lapak'] == "UNVERIFIED") {
                $responseLapak = Http::withToken(session('_jwtToken'))->get("https://dev-ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/" . $lapak['_id'] . "/get")->collect();

                array_push($tmp_lapak_verify, $responseLapak['data']);
            }
        }

        return view('admin/verifikasi_lapak', ['dataLapak' => $tmp_lapak_verify]);
    }

    public function updateStatusLapak(Request $request)
    {
        $response_detail_lapak = Http::withToken(session('_jwtToken'))->get("https://dev-ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/" . $request->idLapak . "/get")->collect();
        //return $response_detail_lapak;
        $updateLapak = Http::withToken(session('_jwtToken'))->put('https://dev-ecommerce-api.paroki-gmaklaten.web.id/api/lapak/update/' . $request->idLapak, [
            "nama_lapak" => $response_detail_lapak['data']['nama_lapak'],
            "paroki_id" => $response_detail_lapak['data']['paroki_lapak']['paroki_id'],
            "deskripsi_lapak" => $response_detail_lapak['data']['deskripsi_lapak'],
            "alamat_lapak" => $response_detail_lapak['data']['alamat_lapak'],
            "no_telepon_lapak" => $response_detail_lapak['data']['no_telepon_lapak'],
            "status_lapak" => "ACTIVE",
            "catatan_lapak" => $response_detail_lapak['data']['catatan_lapak']
        ]);

        return redirect()->route('daftar-lapak.detaillapak', Crypt::encryptString($request->idLapak));
    }

    public function indexVerifikasiRating()
    {
        $rating = Http::withToken(session('_jwtToken'))->get('https://dev-ecommerce-api.paroki-gmaklaten.web.id/api/rating/get')->collect();
        return view('admin/verifikasi_rating', ['dataRating' => $rating]);
    }

    public function updateStatusRating(Request $request)
    {
        $updateRating = Http::withToken(session('_jwtToken'))->put('https://dev-ecommerce-api.paroki-gmaklaten.web.id/api/rating/update/' . $request->idRating, [
            "status_rating" => $request->statusRating,
        ]);

        return redirect()->route('verifikasi-rating.index');
    }
}
