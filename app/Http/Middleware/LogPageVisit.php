<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // <-- DOKUMENTASI: Kita butuh 'Str' untuk pengecekan

class LogPageVisit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // DOKUMENTASI: Ini adalah perbaikannya.
        // Kita ganti if ($request->isRobot()) dengan pengecekan manual
        // untuk kata 'bot' atau 'crawler' di User Agent.
        $userAgent = strtolower($request->userAgent() ?? '');
        if (Str::contains($userAgent, ['bot', 'crawler', 'spider'])) {
            return $next($request); // Jika bot, jangan dicatat
        }
        // --- BATAS PERBAIKAN ---

        try {
            PageVisit::create([
                'url' => $request->fullUrl(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => Auth::id(), // Ambil ID user (hasilnya null jika guest)
            ]);
        } catch (\Exception $e) {
            // Jika pencatatan gagal, jangan hentikan webnya
            // Cukup catat errornya di log Laravel
            report($e);
        }

        // Lanjutkan request ke halaman yang dituju
        return $next($request);
    }
}