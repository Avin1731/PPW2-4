<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\Auth\LoginRegisterController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard'); // kalau sudah login, ke dashboard
    }
    return view('welcome'); // kalau guest, tampilkan welcome
})->name('welcome');

// Auth Routes
Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->middleware('auth')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});

// CRUD Buku (harus login)
Route::middleware('auth')->group(function () {
    Route::resource('buku', BukuController::class);
    Route::get('/buku/cetak/pdf', [BukuController::class, 'cetakPDF'])->name('buku.cetak.pdf');
});
