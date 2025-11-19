@extends('layouts.app')

@section('title', 'Info Lowongan Kerja')

@section('content')

<style>
    /* --- 1. Card Loker Style --- */
    .card-loker {
        background-color: #2c3e50;
        border: 1px solid #4a627a;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card-loker:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        border-color: #4ecca3;
    }
    .badge-status {
        position: absolute; top: 15px; right: 15px; font-size: 0.75rem;
    }

    /* --- 2. Pagination Dark Mode (CENTERED) --- */
    .pagination { margin-bottom: 0; justify-content: center; }
    .pagination .page-item .page-link { background-color: #34495e; border-color: #4a627a; color: #ecf0f1; }
    .pagination .page-item .page-link:hover { background-color: #2c3e50; border-color: #4ecca3; color: #4ecca3; }
    .pagination .page-item.active .page-link { background-color: transparent; border-color: #4ecca3; color: #4ecca3; font-weight: bold; }
    .pagination .page-item.disabled .page-link { background-color: #2c3e50; border-color: #4a627a; color: #6c757d; }
    
    /* --- 3. Modal & Form Styling --- */
    .modal-dark { background-color: #2c3e50; color: white; border: 1px solid #4a627a; }
    
    /* Input File Gelap */
    .form-control-dark {
        background-color: #34495e; color: #ecf0f1; border: 1px solid #4a627a;
    }
    .form-control-dark:focus {
        background-color: #34495e; color: white; border-color: #4ecca3; box-shadow: 0 0 0 0.25rem rgba(78, 204, 163, 0.25);
    }
    .form-control-dark::file-selector-button {
        background-color: #22303f; 
        color: #ecf0f1;
        border: 0;
        border-right: 1px solid #4a627a;
        padding: 0.375rem 0.75rem;
        margin-right: 10px;
        transition: .2s;
    }
    .form-control-dark::file-selector-button:hover {
        background-color: #1a2633; color: #4ecca3; cursor: pointer;
    }

    /* Custom Scrollbar List Posisi */
    .position-list::-webkit-scrollbar { width: 8px; }
    .position-list::-webkit-scrollbar-track { background: #22303f; border-radius: 4px; }
    .position-list::-webkit-scrollbar-thumb { background-color: #4a627a; border-radius: 4px; }
    .position-list::-webkit-scrollbar-thumb:hover { background-color: #4ecca3; }

    /* Radio Button Interaktif */
    .position-item {
        background-color: #34495e;
        border: 1px solid #4a627a;
        transition: all 0.2s ease-in-out;
    }
    .position-item:hover {
        background-color: #3e5871; border-color: #4ecca3;
    }
    .form-check-input:checked + label { color: #4ecca3 !important; font-weight: bold; }
    .form-check-input:checked { background-color: #4ecca3; border-color: #4ecca3; }
</style>

<div class="container-fluid px-5"> 
    
    <div class="row mb-4 align-items-center">
        <div class="col-12 text-center">
            <h2 class="fw-bold text-success mb-1">🚀 Karir Pustaka Buku</h2>
            <p class="text-white-50">Temukan peran yang sesuai dengan minat dan keahlianmu.</p>
        </div>
    </div>

    {{-- GRID 4 KARTU PER BARIS --}}
    <div class="row g-4">
        @forelse($jobs as $job)
        <div class="col-xl-3 col-lg-3 col-md-6 col-12">
            <div class="card h-100 card-loker shadow-sm position-relative">
                <span class="badge bg-info text-dark badge-status rounded-pill px-3">Aktif</span>

                <div class="card-body d-flex flex-column pt-4">
                    <h5 class="card-title fw-bold text-white pe-4 mb-3" style="min-height: 3rem;">
                        {{ $job->title }}
                    </h5>
                    
                    <div class="mb-3 text-white-50 fs-6">
                        <div class="mb-1 text-truncate">📍 {{ $job->location ?? 'Remote / WFH' }}</div>
                        <div>⏳ Deadline: <span class="text-warning">{{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d M Y') : '-' }}</span></div>
                    </div>

                    <p class="card-text text-light small flex-grow-1" style="opacity: 0.8;">
                        {{ Str::limit($job->description, 90) }}
                    </p>
                </div>

                <div class="card-footer bg-transparent border-top border-secondary p-3">
                    <div class="d-flex gap-2">
                        {{-- TOMBOL DETAIL --}}
                        <a href="{{ route('lokers.show', $job->id) }}" class="btn btn-outline-info w-50 fw-bold">
                            🔍 Detail
                        </a>

                        @if(in_array($job->id, $appliedJobs))
                            <button class="btn btn-outline-secondary w-50" disabled>✅ Dilamar</button>
                        @else
                            <button type="button" class="btn btn-success w-50 fw-bold" data-bs-toggle="modal" data-bs-target="#applyModal{{ $job->id }}">
                                📄 Lamar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Upload CV & Pilih Posisi -->
        <div class="modal fade" id="applyModal{{ $job->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-dark">
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title">Lamar: <span class="text-success">{{ $job->title }}</span></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('lokers.apply', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            @if($job->available_positions)
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-info mb-2">Pilih Posisi:</label>
                                    <div class="d-flex flex-column gap-2 position-list pe-2" style="max-height: 250px; overflow-y: auto;">
                                        @foreach(explode(',', $job->available_positions) as $index => $posisi)
                                            @php $posisi = trim($posisi); @endphp
                                            <div class="form-check p-2 rounded position-item d-flex align-items-center" style="cursor: pointer;">
                                                <input class="form-check-input ms-1 mt-0" type="radio" name="position" id="pos_{{ $job->id }}_{{ $index }}" value="{{ $posisi }}" required style="cursor: pointer;">
                                                <label class="form-check-label text-white w-100 ps-2 mb-0" for="pos_{{ $job->id }}_{{ $index }}" style="cursor: pointer; font-size: 0.9rem;">
                                                    {{ $posisi }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="position" value="{{ $job->title }}">
                            @endif

                            <div class="mb-1">
                                <label class="form-label fw-bold">Upload CV (PDF)</label>
                                <input type="file" class="form-control form-control-dark" name="cv" required accept="application/pdf">
                                <div class="form-text text-white-50 mt-1" style="font-size: 0.8rem;">Maksimal ukuran file 2MB.</div>
                            </div>
                        </div>
                        <div class="modal-footer border-secondary">
                            <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success fw-bold">🚀 Kirim Lamaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 py-5 text-center">
            <div style="font-size: 4rem; opacity: 0.5;">📭</div>
            <h4 class="mt-3 text-white">Belum ada lowongan tersedia</h4>
        </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($jobs->count() > 0 && method_exists($jobs, 'hasPages') && $jobs->hasPages())
    <div class="mt-5">
        {{ $jobs->links() }}
    </div>
    @endif
</div>
@endsection