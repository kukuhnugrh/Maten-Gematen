<?php

namespace App\Http\Controllers\Admin\Kategori;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KategoriAdminController extends Controller
{
    //
    public function index()
    {
        $kategori = Http::withToken(session('_jwtToken'))->get('http://ecommerce-api.paroki-gmaklaten.web.id/api/kategori/get')->collect();
        //return $kategori;
        return view('admin/kategori_lapak', ['kategoriProduk' => $kategori['data']]);
    }

    public function createOrUpdate(Request $request)
    {
        if (empty($request->idKategori)) {
            $responseKategori = Http::withToken(session('_jwtToken'))->accept('application/json')->post('http://ecommerce-api.paroki-gmaklaten.web.id/api/kategori/create', [
                "iconName" => $request->namaKategori,
                "iconText" => $request->iconKategori
            ]);
            $kategori = $responseKategori->collect();

            if ($responseKategori->failed()) {
                return response()->json($kategori['errors'], 422);
            } else {
                return $kategori;
            }
        } else {
            $responseKategori = Http::withToken(session('_jwtToken'))->accept('application/json')->put('http://ecommerce-api.paroki-gmaklaten.web.id/api/kategori/update/' . $request->idKategori, [
                "iconName" => $request->namaKategori,
                "iconText" => $request->iconKategori
            ]);
            $kategori = $responseKategori->collect();

            if ($responseKategori->failed()) {
                return response()->json($kategori['message'], 422);
            } else {
                return $kategori;
            }
        }
    }

    public function getKategori()
    {
        $kategori = Http::withToken(session('_jwtToken'))->get('http://ecommerce-api.paroki-gmaklaten.web.id/api/kategori/get')->collect();
        return response()->json($kategori['data']);
    }
}
