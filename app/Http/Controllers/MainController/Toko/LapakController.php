<?php

namespace App\Http\Controllers\MainController\Toko;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LapakController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wilayahs = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/wilayah/get")->collect();
        $lapak = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/" . session('_lapakId') . "/get")->collect();
        //return session("_lapakId");
        return view('main_pages/toko/toko', ['wilayahs' => $wilayahs['data'], 'lapak' => $lapak]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $wilayahs = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/wilayah/get")->collect();
        return view('main_pages/toko/new_lapak', ['wilayahs' => $wilayahs['data']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validasi Request
        $validated = $request->validate([
            'namaLapak' => 'required|max:100',
            'wilayahLapak' => 'required',
            'deskripsiLapak' => 'required|max:3000',
            'noHandphoneLapak' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'detailAlamat' => 'required'
        ]);

        //Simpan Data Lapak kedalam database
        $kecamatan = explode("_", $request->kecamatan);
        $kelurahan = explode("_", $request->kelurahan);
        $wilayah = explode('_', $request->wilayahLapak);

        $responseData = Http::withToken(session('_jwtToken'))->accept('application/json')->post('https://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/create', [
            "user_id" => session("_userId"),
            "nama_lapak" => $request->namaLapak,
            "wilayah_id" => $wilayah[0],
            "deskripsi_lapak" => $request->deskripsiLapak,
            "alamat_lapak" => array(
                "kecamatan" => $kecamatan[1],
                "kelurahan" => $kelurahan[1],
                "detail_alamat" => $request->detailAlamat,
                "longitude" => $request->longitude,
                "latitude" => $request->latitude
            ),
            "no_telepon_lapak" => $request->noHandphoneLapak,
        ]);

        session(['_lapakId' => $responseData['data']['_id'], '_namaLapak' => $responseData['data']['nama_lapak'], '_statusLapak' => $responseData['data']['status_lapak'], '_catatanLapak' => $responseData['data']['catatan_lapak']]);

        return redirect()->route('home')->with("status", $responseData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $validated = $request->validate([
            'namaLapak' => 'required|max:100',
            'wilayahLapak' => 'required',
            'deskripsiLapak' => 'required|max:3000',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'detailAlamat' => 'required',
            'noHandphoneLapak' => 'required',
        ]);

        //Simpan Data Lapak kedalam database
        $kecamatan = explode("_", $request->kecamatan);
        $kelurahan = explode("_", $request->kelurahan);
        $wilayah = explode('_', $request->wilayahLapak);

        $storeData = Http::withToken(session('_jwtToken'))->accept('application/json')->put('http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/update/' . session("_lapakId"), [
            "nama_lapak" => $request->namaLapak,
            "wilayah_id" => $wilayah[0],
            "deskripsi_lapak" => $request->deskripsiLapak,
            "alamat_lapak" => array(
                "kecamatan" => $kecamatan[1],
                "kelurahan" => $kelurahan[1],
                "detail_alamat" => $request->detailAlamat,
                "longitude" => $request->longitude,
                "latitude" => $request->latitude
            ),
            "no_telepon_lapak" => $request->noHandphoneLapak,
            "status_lapak" => session('_statusLapak'),
            "catatan_lapak" => session('_catatanLapak')
        ])->collect();


        return redirect()->route('tokoku.index')->with("status_update_lapak", $storeData['message']);
    }
}
