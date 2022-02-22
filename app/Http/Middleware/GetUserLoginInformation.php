<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetUserLoginInformation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if ($request->session()->has('_jwtToken')) {
            if ($this->getNewToken($request, $request->session()->get('_jwtToken'))) {
                return $next($request);
            }
        }
        $request->session()->flush();
        return redirect()->route('login.web');
    }

    protected function getNewToken($request, $token)
    {
        $verify = false;
        $newToken = Http::withToken($token)->accept('application/json')->acceptJson()->post('http://ecommerce-api.paroki-gmaklaten.web.id/api/auth/refresh-token')->collect();
        if (isset($newToken['success'])) {
            $request->session()->put('_jwtToken', $newToken['data']['access_token']);
            $verify = true;
        }

        return $verify;
    }
}
