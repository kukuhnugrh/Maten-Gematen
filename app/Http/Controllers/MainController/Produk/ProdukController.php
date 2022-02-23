<?php

namespace App\Http\Controllers\MainController\Produk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class ProdukController extends Controller
{

    public function index()
    {
        $responseDetailLapak = Http::withToken(session('_jwtToken'))->get('http://ecommerce-api.paroki-gmaklaten.web.id/api/lapak/detail/' . session('_lapakId') . '/get')->collect();
        $produkArray = array();

        foreach ($responseDetailLapak['data']['produk_lapak'] as $produk) {
            $produk['link_detail'] = route('produkku.viewUpdateProduk', Crypt::encryptString($produk['produk_id']));
            array_push($produkArray, $produk);
        }

        return view("main_pages/produk/produk", ['response_produk' => $produkArray]);
    }

    public function viewCreateProduk()
    {
        $kategoris = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/kategori/get")->collect();

        return view('main_pages/produk/create_produk', ['kategoris' => $kategoris['data']]);
    }

    public function createProduk(Request $request)
    {
        /*
        ---------------------------------------------------------------------------
        Validasi Request

        $validated = $request->validate([
            'namaProduk' => 'required|max:100',
            'deskripsiProduk' => 'required|max:3000',
            'kategoriProduk' => 'required',
            'hargaProduk' => 'required|numeric',
            'stokProduk' => 'required|numeric',
            'beratProduk' => 'required|numeric',
            'merekProduk' => 'max:50'
        ]);
        ---------------------------------------------------------------------------
        */

        if ($request->hasfile('gambarProduk')) {
            $kategori = explode('_', $request->kategoriProduk);

            $data = [
                [
                    'name'     => 'lapak_id',
                    'contents' =>  $request->session()->get('_lapakId')
                ],
                [
                    'name'     => 'kategori_id',
                    'contents' => $kategori[0]
                ],
                [
                    'name'     => 'nama_produk',
                    'contents' => $request->namaProduk
                ],
                [
                    'name'     => 'deskripsi_produk',
                    'contents' => $request->deskripsiProduk
                ],
                [
                    'name'     => 'berat_produk',
                    'contents' => (int) $request->beratProduk
                ],
                [
                    'name'     => 'harga_produk',
                    'contents' => (int) $request->hargaProduk
                ],
                [
                    'name'     => 'stok_produk',
                    'contents' => (int) $request->stokProduk
                ],
                [
                    'name'     => 'kondisi_produk',
                    'contents' => $request->selectKondisiProduk
                ],
                [
                    'name'     => 'keamanan_produk',
                    'contents' => $request->selectKeamananProduk
                ],
                [
                    'name'     => 'merek_produk',
                    'contents' => $request->merekProduk
                ],
                [
                    'name'     => 'variasi_produk[]',
                    'contents' => $this->variasiProduk($request)
                ]
            ];

            $body_request = $this->setGambarProduk($request->file('gambarProduk'), $data);

            $response = $this->getClientHttp()->request('POST', '/api/produk/create', [
                'headers' => [
                    'Authorization' => "Bearer" . session('_jwtToken')
                ],
                'multipart' => $body_request
            ]);

            $storeData = json_decode($response->getBody()->getContents(), true);

            return redirect()->route('produkku.viewUpdateProduk', Crypt::encryptString($storeData['data']['_id']))->with('status_createUpdate_produk', $storeData['message']);
        } else {
            return back()->with('status_gambar', 'Gambar harus Diiisi');
        }
    }

    public function viewUpdateProduk($id_produk)
    {
        $_id = Crypt::decryptString($id_produk);
        $response_detail_produk = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/produk/detail/" . $_id . "/get")->collect();
        $responseKategoris = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/kategori/get")->collect();

        $dataGambar = array(
            0 => "",
            1 => "",
            2 => ""
        );
        for ($i = 0; $i < count($response_detail_produk['data']['gambar_produk']); $i++) {
            $dataGambar[$i] = "https://ecommerce-api.paroki-gmaklaten.web.id/gambar-produk/" . $response_detail_produk['data']['gambar_produk'][$i];
        }

        return view('main_pages/produk/update_produk', ['detail_produk' => $response_detail_produk['data'], 'kategoris' => $responseKategoris['data'], 'assetGambar' => $dataGambar]);
    }

    public function updateProduk(Request $request)
    {
        // dd($request);
        $_id = Crypt::decryptString($request->id_produk);
        $kategori = explode('_', $request->kategoriProduk);

        $data = [
            [
                'name'     => 'kategori_id',
                'contents' => $kategori[0]
            ],
            [
                'name'     => 'nama_produk',
                'contents' => $request->namaProduk
            ],
            [
                'name'     => 'deskripsi_produk',
                'contents' => $request->deskripsiProduk
            ],
            [
                'name'     => 'berat_produk',
                'contents' => (int) $request->beratProduk
            ],
            [
                'name'     => 'harga_produk',
                'contents' => (int) $request->hargaProduk
            ],
            [
                'name'     => 'stok_produk',
                'contents' => (int) $request->stokProduk
            ],
            [
                'name'     => 'kondisi_produk',
                'contents' => $request->selectKondisiProduk
            ],
            [
                'name'     => 'keamanan_produk',
                'contents' => $request->selectKeamananProduk
            ],
            [
                'name'     => 'merek_produk',
                'contents' => $request->merekProduk
            ],
            [
                'name'     => 'variasi_produk[]',
                'contents' => $this->variasiProduk($request)
            ]
        ];

        if ($request->hasfile('gambarProduk')) {
            $data = $this->setGambarProduk($request->file('gambarProduk'), $data);
        }

        $body_request = $this->setHapusGambar($request->gambarInput, $_id, $data);

        try {
            $response = $this->getClientHttp()->request('POST', '/api/produk/update/' . $_id, [
                'headers' => [
                    'Authorization' => "Bearer" . session('_jwtToken')
                ],
                'multipart' => $body_request
            ]);
        } catch (ClientException $e) {
            echo Psr7\Message::toString($e->getRequest());
            echo Psr7\Message::toString($e->getResponse());
        }



        $storeData = json_decode($response->getBody()->getContents(), true);

        return redirect()->route('produkku.viewUpdateProduk', Crypt::encryptString($_id))->with('status_createUpdate_produk', $storeData['message']);
    }

    protected function variasiProduk($request)
    {
        if ($request->has('inputVariasiSize') || $request->has('inputVariasiWarna') || $request->has('inputVariasiMotif')) {
            $variasi = array();
            for ($i = 0; $i < count($request->inputVariasiSize); $i++) {
                if ($request->inputVariasiSize[$i] != null || $request->inputVariasiWarna[$i] != null || $request->inputVariasiMotif[$i] != null) {
                    $variasi[$i]['size'] = $request->inputVariasiSize[$i];
                    $variasi[$i]['warna'] = $request->inputVariasiWarna[$i];
                    $variasi[$i]['motif'] = $request->inputVariasiMotif[$i];
                }
            }
            return $variasi;
        } else {
            $variasi = null;
            return $variasi;
        }
    }

    protected function getClientHttp()
    {
        # code...
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://ecommerce-api.paroki-gmaklaten.web.id',
            // You can set any number of default request options.
            'timeout'  => 20.0,
        ]);

        return $client;
    }

    protected function setGambarProduk($gambarproduk, $body_request)
    {
        $tmp_data = $body_request;
        for ($i = 0; $i < count($gambarproduk); $i++) {
            $datagambar = array(
                "name" => "gambar_produk[]",
                "contents" => file_get_contents($gambarproduk[$i]),
                "filename" => $gambarproduk[$i]->getClientOriginalName()
            );

            array_push($tmp_data, $datagambar);
        }

        return $tmp_data;
    }

    protected function setHapusGambar($gambarInput, $_id, $body_request)
    {
        $hapusGambar = array();
        $tmp_data = $body_request;
        $arrGambarInput = explode('_', $gambarInput);

        $response_detail_produk = Http::withToken(session('_jwtToken'))->get("http://ecommerce-api.paroki-gmaklaten.web.id/api/produk/detail/" . $_id . "/get")->collect();

        foreach ($response_detail_produk['data']['gambar_produk'] as $gambarDb) {
            $counterHapus = true;
            foreach ($arrGambarInput as $gambarInpt) {
                if ($gambarDb == $gambarInpt) {
                    $counterHapus = false;
                }
            }
            if ($counterHapus) {
                array_push($hapusGambar, $gambarDb);
            }
        }

        for ($i = 0; $i < count($hapusGambar); $i++) {
            $dataHapusGambar = array(
                "name" => "hapus_gambar[]",
                "contents" => $hapusGambar[$i]
            );

            array_push($tmp_data, $dataHapusGambar);
        }

        return $tmp_data;
    }
}