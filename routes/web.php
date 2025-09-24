<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// CRUD Buku
Route::resource('buku', BukuController::class);
