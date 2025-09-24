@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="text-center">
        <h1 class="mb-3">Selamat Datang di Aplikasi Pustaka Buku 📚</h1>
        <p class="lead">Kelola data buku dengan mudah menggunakan Laravel.</p>
        <a href="{{ route('buku.index') }}" class="btn btn-primary btn-lg mt-3">Lihat Pustaka Buku</a>
    </div>
</div>
@endsection
