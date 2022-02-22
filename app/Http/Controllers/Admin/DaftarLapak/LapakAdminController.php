<?php

namespace App\Http\Controllers\Admin\DaftarLapak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class LapakAdminController extends Controller
{
    public function index()
    {
        # code...
        $dataLapak = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/get")->collect();
        $tmp_lapak_verify = array();

        foreach ($dataLapak['data'] as $lapak) {
            if ($lapak['status_lapak'] != "VERIFY") {
                array_push($tmp_lapak_verify, $lapak);
            }
        }

        return view('admin/daftar_lapak', ['arrLapak' => $tmp_lapak_verify]);
    }

    public function detailLapak($id_lapak)
    {
        $_id = Crypt::decryptString($id_lapak);
        $response_detail_lapak = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/" . $_id . "/get")->collect();
        return view('admin/detail_lapak', ['detailLapak' => $response_detail_lapak['data']]);
    }

    public function updateLapak(Request $request)
    {
        // dd($request);
        $response_detail_lapak = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/" . $request->idLapak . "/get")->collect();
        //return $response_detail_lapak;
        $updateLapak = Http::withToken(session('_jwtToken'))->accept('application/json')->acceptJson()->put('http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/update', [
            "id_lapak" => $request->idLapak,
            "nama_lapak" => $response_detail_lapak['nama_lapak'],
            "wilayah" => $response_detail_lapak['wilayah'],
            "deskripsi_lapak" => $response_detail_lapak['deskripsi_lapak'],
            "alamat_lapak" => $response_detail_lapak['alamat_lapak'],
            "status_lapak" => $request->statusLapak,
            "catatan_lapak" => $request->catatanAdmin
        ]);

        return redirect()->route('daftar-lapak.detaillapak', Crypt::encryptString($updateLapak['lapak']['_id']));
    }
}
