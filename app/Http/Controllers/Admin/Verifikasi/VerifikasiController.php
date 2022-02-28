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
        $dataLapak = Http::withToken(session('_jwtToken'))->get('http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/get')->collect();
        $tmp_lapak_verify = array();

        foreach ($dataLapak['data'] as $lapak) {
            if ($lapak['status_lapak'] == "VERIFY") {
                $responseLapak = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/" . $lapak['_id'] . "/get")->collect();
                $lapak['deskripsi_lapak'] = $responseLapak['data']['deskripsi_lapak'];
                $lapak['alamat_lapak'] = $responseLapak['data']['alamat_lapak'];
                $lapak['no_telepon_lapak'] = $responseLapak['data']['no_telepon_lapak'];
                array_push($tmp_lapak_verify, $lapak);
            }
        }

        return view('admin/verifikasi_lapak', ['dataLapak' => $tmp_lapak_verify]);
    }

    public function updateStatusLapak(Request $request)
    {
        $response_detail_lapak = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/" . $request->idLapak . "/get")->collect();
        //return $response_detail_lapak;
        $updateLapak = Http::withToken(session('_jwtToken'))->put('http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/update/' . $request->idLapak, [
            "nama_lapak" => $response_detail_lapak['data']['nama_lapak'],
            "wilayah_id" => $response_detail_lapak['data']['wilayah_lapak']['wilayah_id'],
            "deskripsi_lapak" => $response_detail_lapak['data']['deskripsi_lapak'],
            "alamat_lapak" => $response_detail_lapak['data']['alamat_lapak'],
            "no_telepon_lapak" => $response_detail_lapak['data']['no_telepon_lapak'],
            "status_lapak" => "ACTIVE",
            "catatan_lapak" => $response_detail_lapak['data']['catatan_lapak']
        ]);

        return redirect()->route('daftar-lapak.detaillapak', Crypt::encryptString($request->idLapak));
    }

    public function indexVerifikasiTransaksi()
    {
        $transaksi = Http::withToken(session('_jwtToken'))->get('http://ecommerce-api.paroki-gmaklaten.web.id/api/transaksi/get')->collect();
        
        return view('admin/verifikasi_transaksi', ['dataTransaksi' => $transaksi]);
    }

    public function updateStatusTransaksi(Request $request)
    {
        $updateLapak = Http::withToken(session('_jwtToken'))->put('http://ecommerce-api.paroki-gmaklaten.web.id/api/transaksi/update-status/' . $request->idTransaksi, [
            "status" => $request->statusTransaksi,
        ]);
        $transaksi = Http::withToken(session('_jwtToken'))->get('http://ecommerce-api.paroki-gmaklaten.web.id/api/transaksi/get')->collect();

        return view('admin/verifikasi_transaksi', ['dataTransaksi' => $transaksi]);
    }
}
