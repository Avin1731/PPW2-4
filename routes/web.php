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


// === DOKUMENTASI PERUBAHAN DI BAWAH INI ===
// Rute CRUD Buku yang lama (Route::resource) kita hapus dan pecah menjadi 2 grup.

// GRUP 1: UNTUK SEMUA USER YANG LOGIN (MIDDLEWARE 'auth')
// Rute di grup ini bisa diakses oleh 'user' biasa DAN 'admin',
// karena keduanya pasti sudah login (lolos middleware 'auth').
// Kita hanya menaruh rute yang sifatnya 'read-only' (melihat data).
Route::middleware('auth')->group(function () {
    
    // Rute untuk menampilkan halaman daftar buku (index)
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    
    // Rute untuk menampilkan halaman detail satu buku (show)
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');

    // Rute cetak PDF juga aman di sini karena hanya melihat data
    Route::get('/buku/cetak/pdf', [BukuController::class, 'cetakPDF'])->name('buku.cetak.pdf');
});

// GRUP 2: KHUSUS UNTUK ADMIN (MIDDLEWARE 'auth' dan 'isAdmin')
// Rute di grup ini HANYA bisa diakses oleh admin.
// User biasa akan diblokir oleh middleware 'isAdmin'.
// Kita menaruh semua rute C-U-D (Create, Update, Delete) di sini.
Route::middleware(['auth', 'isAdmin'])->group(function () { 
    
    // Rute untuk menampilkan form TAMBAH buku
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    
    // Rute untuk memproses penyimpanan buku baru (saat form disubmit)
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    
    // Rute untuk menampilkan form EDIT buku
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    
    // Rute untuk memproses update buku (saat form edit disubmit)
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    
    // Rute untuk menghapus buku
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
});