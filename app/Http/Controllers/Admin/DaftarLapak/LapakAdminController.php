<?php

namespace App\Http\Controllers\Admin\DaftarLapak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class LapakAdminController extends Controller
{
    public function index()
    {   
        # code...
        try {
            $response = $this->getClientHttp()->request('GET', '/api/lapak/get', [
                'headers' => [
                    'Authorization' => "Bearer" . session('_jwtToken')
                ],
            ]);
            $dataLapak = json_decode($response->getBody()->getContents(), true);
            $tmp_lapak_verify = array();
        
            foreach ($dataLapak['data'] as $lapak) {
                if ($lapak['status_lapak'] != "UNVERIFIED") {
                    $lapak['link_detail'] = route("daftar-lapak.detaillapak", Crypt::encryptString($lapak['_id']));
                    array_push($tmp_lapak_verify, $lapak);
                }
            }
            return view('admin/daftar_lapak', ['arrLapak' => $tmp_lapak_verify]);
        } catch (ClientException $e) {
            $bodyError = Psr7\Message::parseMessage(Psr7\Message::toString($e->getResponse()))['body'];

            $message = json_decode($bodyError);

            return back()->withErrors(['error' => $message]);
        }
        //$dataLapak = Http::withToken(session('_jwtToken'))->get("https://dev-ecommerce-api.paroki-gmaklaten.web.id/api/lapak/get")->collect();
        //dd($dataLapak);
        // $tmp_lapak_verify = array();
        
        // foreach ($dataLapak['data'] as $lapak) {
        //     if ($lapak['status_lapak'] != "UNVERIFIED") {
        //         $lapak['link_detail'] = route("daftar-lapak.detaillapak", Crypt::encryptString($lapak['_id']));
        //         array_push($tmp_lapak_verify, $lapak);
        //     }
        // }

        // return view('admin/daftar_lapak', ['arrLapak' => $tmp_lapak_verify]);
    }

    public function detailLapak($id_lapak)
    {
        $_id = Crypt::decryptString($id_lapak);
        $response_detail_lapak = Http::withToken(session('_jwtToken'))->get("https://dev-ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/" . $_id . "/get")->collect();
        return view('admin/detail_lapak', ['detailLapak' => $response_detail_lapak['data']]);
    }

    public function updateLapak(Request $request)
    {
        $response_detail_lapak = Http::withToken(session('_jwtToken'))->get("https://dev-ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/" . $request->idLapak . "/get")->collect();
        //return $response_detail_lapak;
        $updateLapak = Http::withToken(session('_jwtToken'))->put('https://dev-ecommerce-api.paroki-gmaklaten.web.id/api/lapak/update/' . $request->idLapak, [
            "nama_lapak" => $response_detail_lapak['data']['nama_lapak'],
            "paroki_id" => $response_detail_lapak['data']['paroki_lapak']['paroki_id'],
            "deskripsi_lapak" => $response_detail_lapak['data']['deskripsi_lapak'],
            "alamat_lapak" => $response_detail_lapak['data']['alamat_lapak'],
            "no_telepon_lapak" => $response_detail_lapak['data']['no_telepon_lapak'],
            "status_lapak" => $request->statusLapak,
            "catatan_lapak" => $request->catatanAdmin
        ]);

        return redirect()->route('daftar-lapak.detaillapak', Crypt::encryptString($request->idLapak))->with("status_update_catatan", "Berhasil Update Catatan");
    }

    protected function getClientHttp()
    {
        # code...
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://dev-ecommerce-api.paroki-gmaklaten.web.id',
            // You can set any number of default request options.
            'timeout'  => 20.0,
        ]);

        return $client;
    }
}
