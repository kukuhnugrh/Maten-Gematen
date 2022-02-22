<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfUser
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
        if ($request->session()->has('_lapakId') || $request->session()->has('role')) {
            if ($request->session()->get('_lapakId') == '') {
                return redirect()->back();
            }
            if ($request->session()->get('role') == 'admin') {
                return redirect()->back();
            }
        }
        return $next($request);
    }
}
