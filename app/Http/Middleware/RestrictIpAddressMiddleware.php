<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictIpAddressMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public $strictedIp = ["127.0.0.1"];

    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->ip(), $this->strictedIp)) {

            return $next($request);
        }
        return response()->json(['message' => "Twoje IP nie mam możliwości wejścia na ten adres"]);
    }
}
