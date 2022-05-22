<?php

namespace App\Http\Controllers\SignPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sign_page/login');
    }

    /**
     * check user login.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkUserLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        $responseData = Http::accept('application/json')->post('https://ecommerce-api.paroki-gmaklaten.web.id/api/auth/login', [
            "email" => $request->input('email'),
            "password" => $request->input('password'),
            "type" => "manual"
        ]);
        $data = $responseData->collect();

        if ($responseData->failed()) {
            return back()->withErrors(['error' => $data['message']]);
        } else {
            if ($data['data']['user']['role'] == 'user') {
                if ($data['data']['lapak'] == null) {
                    session(['_userId' => $data['data']['user']['_id'], '_namaUser' => $data['data']['user']['nama'], 'role' => $data['data']['user']['role'], '_jwtToken' => $data['data']['access_token']]);
                    return redirect()->route('new-lapak');
                } else {
                    session(['_userId' => $data['data']['user']['_id'], '_namaUser' => $data['data']['user']['nama'], 'role' => $data['data']['user']['role'], '_jwtToken' => $data['data']['access_token'], '_lapakId' => $data['data']['lapak']['_id'], '_namaLapak' => $data['data']['lapak']['nama_lapak'], '_statusLapak' => $data['data']['lapak']['status_lapak'], '_catatanLapak' => $data['data']['lapak']['catatan_lapak']]);
                    return redirect()->route('home');
                }
            } else {
                //Masuk Halaman User Admin
                session(['role' => $data['data']['user']['role'], '_userId' => $data['data']['user']['_id'], '_jwtToken' => $data['data']['access_token']]);
                return redirect()->route('daftar-lapak.index');
            }
        }
    }

    public function logout(Request $request)
    {
        # code...
        $request->session()->flush();
        $logout = Http::post('https://dev-ecommerce-api.paroki-gmaklaten.web.id/api/auth/logout');
        return redirect()->route('login.web');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
