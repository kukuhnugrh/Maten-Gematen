<?php

namespace App\Http\Controllers\MainController\Toko;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        $parokis = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/paroki/get")->collect();
        $responseLapak = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/" . session('_lapakId') . "/get")->collect();

        $lapak = $responseLapak['data'];
        $lapak['no_telepon_lapak'] = Str::replaceFirst('0', '', $responseLapak['data']['no_telepon_lapak']);

        return view('main_pages/toko/toko', ['parokis' => $parokis['data'], 'lapak' => $lapak]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paroki = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/paroki/get")->collect();
        return view('main_pages/toko/new_lapak', ['parokis' => $paroki['data']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lapak' => 'required|max:100',
            'paroki_lapak' => 'required',
            'deskripsi_lapak' => 'required|max:3000',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'detailAlamat' => 'required',
            'no_telepon_lapak' => 'required',
        ]);

        //Simpan Data Lapak kedalam database
        $kecamatan = explode("_", $request->input('kecamatan'));
        $kelurahan = explode("_", $request->input('kelurahan'));
        $paroki = explode('_', $request->paroki_lapak);

        $responseData = Http::withToken(session('_jwtToken'))->accept('application/json')->post('https://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/create', [
            "user_id" => session("_userId"),
            "nama_lapak" => $request->nama_lapak,
            "paroki_id" => $paroki[0],
            "deskripsi_lapak" => $request->deskripsi_lapak,
            "alamat_lapak" => array(
                "kecamatan" => $kecamatan[1],
                "kelurahan" => $kelurahan[1],
                "detail_alamat" => $request->detailAlamat,
                "longitude" => $request->longitude,
                "latitude" => $request->latitude
            ),
            "no_telepon_lapak" => "0" . $request->no_telepon_lapak,
        ]);

        if ($responseData['success']) {
            session(['_lapakId' => $responseData['data']['_id'], '_namaLapak' => $responseData['data']['nama_lapak'], '_statusLapak' => $responseData['data']['status_lapak'], '_catatanLapak' => $responseData['data']['catatan_lapak']]);

            return redirect()->route('home')->with("status", $responseData);
        } else {
            $errorMessage = $responseData->collect();

            return back()->withErrors($errorMessage['message'])->withInput();
        }
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
            'nama_lapak' => 'required|max:100',
            'paroki_lapak' => 'required',
            'deskripsi_lapak' => 'required|max:3000',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'detailAlamat' => 'required',
            'no_telepon_lapak' => 'required',
        ]);

        //Simpan Data Lapak kedalam database
        $kecamatan = explode("_", $request->kecamatan);
        $kelurahan = explode("_", $request->kelurahan);
        $paroki = explode('_', $request->paroki_lapak);

        $updateData = Http::withToken(session('_jwtToken'))->accept('application/json')->put('http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/update/' . session("_lapakId"), [
            "nama_lapak" => $request->nama_lapak,
            "paroki_id" => $paroki[0],
            "deskripsi_lapak" => $request->deskripsi_lapak,
            "alamat_lapak" => array(
                "kecamatan" => $kecamatan[1],
                "kelurahan" => $kelurahan[1],
                "detail_alamat" => $request->detailAlamat,
                "longitude" => $request->longitude,
                "latitude" => $request->latitude
            ),
            "no_telepon_lapak" => "0" . $request->no_telepon_lapak,
            "status_lapak" => session('_statusLapak'),
            "catatan_lapak" => session('_catatanLapak')
        ])->collect();

        if ($updateData['success']) {
            session(['_namaLapak' => $request->namaLapak]);

            return redirect()->route('tokoku.index')->with("status_update_lapak", $updateData['message']);
        } else {
            $errorMessage = $updateData->collect();

            return back()->withErrors($errorMessage['message'])->withInput();
        }
    }
}
