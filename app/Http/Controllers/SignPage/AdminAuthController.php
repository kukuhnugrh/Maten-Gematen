<?php

namespace App\Http\Controllers\SignPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sign_page/login-admin');
    }

    public function redirectDaftarAdmin()
    {
        return view('sign_page/daftar-admin');
    }

    public function createAdmin(Request $request) {
        $validator = $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'confirmpassword' => 'required|string|min:6|same:password',
        ]);

        $responseData = Http::accept('application/json')->post('https://ecommerce-api.paroki-gmaklaten.web.id/api/auth/register', [
            "nama" => $request->input('nama'),
            "email" => $request->input('email'),
            "password" => $request->input('password'),
            "confirmpassword" => $request->input('confirmpassword'),
        ]);
        $data = $responseData->collect();

        if ($responseData->failed()) {
            return back()->withErrors(['error' => $data['message']]);
        } else {
            return redirect()->route('daftar-lapak.index')->with('message', 'Berhasil Menambahkan Akun Admin Baru!');
        }
    }

    public function changePassword(Request $request){
        $validator = $request->validate([
            'oldpassword' => 'required|string|min:6',
            'newpassword' => 'required|string|min:6',
            'confirmpassword' => 'required|string|min:6|same:newpassword',
        ]);
        $responseData = Http::accept('application/json')->post('https://ecommerce-api.paroki-gmaklaten.web.id/api/auth/update/password', [
            "oldpassword" => $request->input('email'),
            "newpassword" => $request->input('password'),
            "confirmpassword" => $request->input('confirmpassword'),
        ]);
        $data = $responseData->collect();

        if ($responseData->failed()) {
            return back()->withErrors(['error' => $data['message']]);
        } else {
            return back()->with('message', 'Berhasil Mengupdate Password!');
        }
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
