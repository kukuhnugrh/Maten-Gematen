<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
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
        if ($request->session()->has('role') && $request->session()->has('_lapakId')) {
            if ($request->session()->get('_lapakId') == '') {
                return redirect()->route('new-user');
            } elseif ($request->session()->get('role') == 'user') {
                return redirect()->route('home');
            } elseif ($request->session()->get('role') == 'admin') {
                return redirect()->route('daftar-lapak.index');
            }
        }

        return $next($request);
    }
}
