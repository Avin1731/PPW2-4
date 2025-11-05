<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- DOKUMENTASI: Pastikan 'Auth' di-import

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // DOKUMENTASI: Ini adalah logika intinya.
        // 1. Periksa apakah user sudah login (Auth::check())
        // 2. DAN periksa apakah 'role' user tersebut adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') { 
            // Jika ya, izinkan request untuk dilanjutkan
            return $next($request);
        }

        // Jika tidak (dia 'user' biasa atau 'guest'),
        // tendang dia kembali ke halaman utama ('/').
        return redirect('/'); 
    }
}