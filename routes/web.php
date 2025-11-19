<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Admin\AnalyticsController; 
use App\Http\Controllers\Admin\LokerController as AdminLokerController; 
use App\Http\Controllers\LokerController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard'); 
    }
    return view('welcome'); 
})->name('welcome');

// --- Auth Routes ---
Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->middleware('auth')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});


// ====================================================
// GRUP 1: UNTUK SEMUA USER YANG LOGIN (MIDDLEWARE 'auth')
// ====================================================
Route::middleware('auth')->group(function () {
    
    // --- Rute Buku ---
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
    Route::get('/buku/cetak/pdf', [BukuController::class, 'cetakPDF'])->name('buku.cetak.pdf');

    // --- Rute Loker untuk User (Pelamar) ---
    
    // 1. List Loker
    Route::get('/loker', [LokerController::class, 'index'])->name('lokers.index'); 
    
    // 2. [DITAMBAHKAN] Detail Loker
    Route::get('/loker/{id}', [LokerController::class, 'show'])->name('lokers.show'); 

    // 3. Proses Apply
    Route::post('/loker/{id}/apply', [LokerController::class, 'store'])->name('lokers.apply'); 
});


// ====================================================
// GRUP 2: KHUSUS UNTUK ADMIN (MIDDLEWARE 'auth' & 'isAdmin')
// ====================================================
Route::middleware(['auth', 'isAdmin'])->group(function () { 
    
    // --- Rute CRUD Buku ---
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

    // --- Rute Perangkat Analisis ---
    Route::get('/admin/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics.index');
    Route::get('/admin/history/users', [AnalyticsController::class, 'userHistory'])->name('admin.history.users');
    Route::get('/admin/history/activity', [AnalyticsController::class, 'activityHistory'])->name('admin.history.activity');
    Route::get('/admin/reports/buku-excel', [AnalyticsController::class, 'downloadBukuExcel'])->name('admin.reports.buku.excel');

    // --- Rute Manajemen Loker (Admin) ---
    
    // 1. Halaman Utama Kelola Loker
    Route::get('/admin/lokers', [AdminLokerController::class, 'index'])->name('admin.lokers.index');
    
    // 2. [DITAMBAHKAN] Edit Loker
    Route::get('/admin/lokers/{id}/edit', [AdminLokerController::class, 'edit'])->name('admin.lokers.edit');
    Route::put('/admin/lokers/{id}', [AdminLokerController::class, 'update'])->name('admin.lokers.update');
    
    // 3. Download Template & Import
    Route::get('/admin/lokers/template', [AdminLokerController::class, 'downloadTemplate'])->name('admin.lokers.template');
    Route::post('/admin/lokers/import', [AdminLokerController::class, 'import'])->name('admin.lokers.import');
    
    // 4. Export Data Pelamar (CSV)
    Route::get('/admin/lokers/{id}/export', [AdminLokerController::class, 'exportApplicants'])->name('admin.lokers.export');

    // 5. Lihat Daftar Pelamar per Loker
    Route::get('/admin/lokers/{id}/applicants', [AdminLokerController::class, 'showApplicants'])->name('admin.lokers.applicants');
    
    // 6. Aksi Terima / Tolak Pelamar
    Route::post('/admin/applies/{id}/status', [AdminLokerController::class, 'updateStatus'])->name('admin.applies.status');
});