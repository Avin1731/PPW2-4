<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // DOKUMENTASI: Ini alias 'isAdmin' yang sudah ada
        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
        ]);

        // DOKUMENTASI: TAMBAHKAN BLOK INI
        // Ini mendaftarkan LogPageVisit ke grup 'web'
        // agar berjalan di setiap request halaman
        $middleware->web(append: [
            \App\Http\Middleware\LogPageVisit::class,
        ]);
        // --- BATAS TAMBAHAN ---

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();