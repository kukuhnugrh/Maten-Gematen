<?php

namespace App\Http\Controllers\MainController\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $responseDetailLapak = Http::withToken(session('_jwtToken'))->get('http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/' . session('_lapakId') . '/get')->collect();
        $produk = $responseDetailLapak['data']['produk_lapak'];
        if (count($produk) != 0){
            $produk = collect($produk)->sortBy('penjualan_produk')->all();
        }
        return view('main_pages/dashboard/dashboard', ['lapak' => $responseDetailLapak, 'produk' => $produk]);
    }
}
