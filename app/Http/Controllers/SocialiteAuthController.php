<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class SocialiteAuthController extends Controller
{
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginWithGoogle()
    {
        try {

            $googleUser = Socialite::driver('google')->user();

            $responseData = Http::accept('application/json')->post('https://ecommerce-api.paroki-gmaklaten.web.id/api/auth/login', [
                "email" => $googleUser['email'],
                "type" => "google"
            ]);
            $data = $responseData->collect();
            if ($responseData->failed()) {
                return redirect()->route('login.web')->withErrors(['error' => $data['message']]);
            } else {
                if ($data['data']['user']['role'] == 'user') {
                    if ($data['data']['lapak'] == null) {
                        session(['_userId' => $data['data']['user']['_id'], 'role' => $data['data']['user']['role'], '_jwtToken' => $data['data']['access_token']]);
                        return redirect()->route('new-lapak');
                    } else {
                        session(['_userId' => $data['data']['user']['_id'], 'role' => $data['data']['user']['role'], '_jwtToken' => $data['data']['access_token'], '_lapakId' => $data['data']['lapak']['_id'], '_namaLapak' => $data['data']['lapak']['nama_lapak'], '_statusLapak' => $data['data']['lapak']['status_lapak'], '_catatanLapak' => $data['data']['lapak']['catatan_lapak']]);
                        return redirect()->route('home');
                    }
                } else {
                    //Masuk Halaman User Admin
                    session(['role' => $data['data']['user']['role'], '_userId' => $data['data']['user']['_id'], '_jwtToken' => $data['data']['access_token']]);
                    return redirect()->route('admindashboard.index');
                }
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
