@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="container">
    <a href="{{ route('lokers.index') }}" class="text-decoration-none text-muted mb-4 d-inline-block">&larr; Kembali ke Lowongan</a>
    
    <div class="card shadow-lg border-0" style="background-color: #2c3e50;">
        <div class="card-body p-5">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h1 class="fw-bold text-white display-6">{{ $job->title }}</h1>
                    <p class="text-info fs-5 mb-0">📍 {{ $job->location ?? 'Remote' }}</p>
                </div>
                <span class="badge bg-success fs-6 px-3 py-2">Aktif</span>
            </div>

            <hr class="border-secondary">

            <div class="row mt-4">
                <div class="col-md-8">
                    <h5 class="text-white fw-bold mb-3">Deskripsi Pekerjaan</h5>
                    <div class="text-light" style="opacity: 0.9; line-height: 1.8; white-space: pre-line;">
                        {{ $job->description }}
                    </div>
                    
                    @if($job->available_positions)
                    <div class="mt-4">
                        <h5 class="text-white fw-bold mb-2">Posisi Dibuka:</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(explode(',', $job->available_positions) as $pos)
                                <span class="badge bg-dark border border-secondary text-warning">{{ trim($pos) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="p-4 rounded border border-secondary" style="background-color: #34495e;">
                        <h5 class="text-white fw-bold mb-3">Ringkasan</h5>
                        <ul class="list-unstyled text-white-50 mb-4">
                            <li class="mb-2">📅 <strong>Deadline:</strong> <br> {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d M Y') : '-' }}</li>
                            <li class="mb-2">🏢 <strong>Tipe:</strong> Full Time</li>
                        </ul>

                        @if($hasApplied)
                            <button class="btn btn-secondary w-100 py-2" disabled>✅ Kamu Sudah Melamar</button>
                        @else
                            {{-- Tombol ini memicu Modal di halaman Index (kita perlu copy modalnya ke sini atau redirect back) --}}
                            {{-- Agar simpel, kita buat tombol Back to Apply --}}
                            <a href="{{ route('lokers.index') }}" class="btn btn-success w-100 py-2 fw-bold">
                                📄 Lamar di Halaman Utama
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection