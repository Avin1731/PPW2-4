@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="text-center fade-in">
        <h1 class="mb-3 fw-bold">Selamat Datang, {{ Auth::user()->name }} 🎉</h1>
        <p class="lead">Anda telah berhasil login ke <strong>Aplikasi Pustaka Buku</strong>.</p>
        <a href="{{ route('buku.index') }}" class="btn btn-primary btn-lg mt-3">
            <i class="bi bi-book"></i> Kelola Data Buku
        </a>
    </div>
</div>
@endsection
