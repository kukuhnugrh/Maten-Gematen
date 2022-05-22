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
        $responseDetailLapak = Http::withToken(session('_jwtToken'))->get('https://dev-ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/' . session('_lapakId') . '/get')->collect();
        $produk = $responseDetailLapak['data']['produk_lapak'];
        
        if (count($produk) != 0) {
            $produk = collect($produk)->sortByDesc('penjualan_produk')->slice(0, 5);
        }
        return view('main_pages/dashboard/dashboard', ['lapak' => $responseDetailLapak, 'produk' => $produk]);
    }
}
