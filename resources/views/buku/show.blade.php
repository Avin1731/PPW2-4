@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $buku->title }}</h5>
        </div>
        <div class="card-body">
            <p class="card-text"><strong>Penulis:</strong> {{ $buku->writer }}</p>
            <p class="card-text"><strong>Harga:</strong> Rp {{ number_format($buku->price, 0, ',', '.') }}</p>
            <p class="card-text"><strong>Tanggal Terbit:</strong> {{ $buku->published_date }}</p>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

@endsection