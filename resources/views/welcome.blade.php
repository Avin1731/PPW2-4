@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="text-center fade-in">
        <h1 class="mb-3 fw-bold">Selamat Datang di Aplikasi Pustaka Buku 📚</h1>
        <p class="lead">Kelola koleksi buku Anda dengan mudah dan efisien menggunakan Laravel.</p>

        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-success btn-lg me-2">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-person-plus"></i> Register
            </a>
        </div>
    </div>
</div>
@endsection
