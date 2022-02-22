<?php

namespace App\Http\Controllers\MainController\Toko;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        return view('main_pages/pesanan/pesanan_semua');
    }

    public function statusPesanan($status)
    {
        return view('main_pages/pesanan/pesanan_' . $status);
    }
}
