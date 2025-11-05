<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Admin\AnalyticsController; // <-- DOKUMENTASI: Import controller baru

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


// GRUP 1: UNTUK SEMUA USER YANG LOGIN (MIDDLEWARE 'auth')
Route::middleware('auth')->group(function () {
    
    // Rute untuk menampilkan halaman daftar buku (index)
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    
    // Rute untuk menampilkan halaman detail satu buku (show)
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');

    // Rute cetak PDF juga aman di sini karena hanya melihat data
    Route::get('/buku/cetak/pdf', [BukuController::class, 'cetakPDF'])->name('buku.cetak.pdf');
});

// GRUP 2: KHUSUS UNTUK ADMIN (MIDDLEWARE 'auth' dan 'isAdmin')
Route::middleware(['auth', 'isAdmin'])->group(function () { 
    
    // --- Rute CRUD Buku (Sudah Ada) ---
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

    // --- DOKUMENTASI: Rute Perangkat Analisis (BARU) ---
    Route::get('/admin/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics.index');
    Route::get('/admin/history/users', [AnalyticsController::class, 'userHistory'])->name('admin.history.users');
    Route::get('/admin/history/activity', [AnalyticsController::class, 'activityHistory'])->name('admin.history.activity');
    Route::get('/admin/reports/buku-excel', [AnalyticsController::class, 'downloadBukuExcel'])->name('admin.reports.buku.excel');
});