@extends('layouts.app')

@section('title', 'Kelola Loker')

@section('content')

{{-- STYLE KHUSUS HALAMAN INI --}}
<style>
    /* Style Input File Gelap */
    .form-control-dark {
        background-color: #34495e; 
        color: #ecf0f1;          
        border: 1px solid #4a627a;
    }
    .form-control-dark::file-selector-button {
        background-color: #2c3e50; 
        color: #ecf0f1;          
        border: 0;
        border-right: 1px solid #4a627a;
        padding: 0.375rem 0.75rem;
        margin-right: 10px;
        transition: .2s;
    }
    .form-control-dark::file-selector-button:hover {
        background-color: #1f2833;
        cursor: pointer;
        color: #4ecca3;
    }
    .empty-state-icon {
        font-size: 4rem;
        color: #4a627a; 
        margin-bottom: 15px;
    }

    /* CUSTOM PAGINATION DARK MODE */
    .pagination { margin-bottom: 0; justify-content: flex-end; }
    .pagination .page-item .page-link {
        background-color: #34495e; border-color: #4a627a; color: #ecf0f1; transition: all 0.3s ease;
    }
    .pagination .page-item .page-link:hover {
        background-color: #2c3e50; border-color: #4ecca3; color: #4ecca3; z-index: 2;
    }
    .pagination .page-item.active .page-link {
        background-color: transparent; border-color: #4ecca3; color: #4ecca3; font-weight: bold;
    }
    .pagination .page-item.disabled .page-link {
        background-color: #2c3e50; border-color: #4a627a; color: #6c757d;
    }
</style>

<div class="container">
    
    {{-- HEADER SECTION --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-white mb-0">
                💼 Kelola Lowongan Kerja
            </h2>
            <p class="text-light mb-0" style="opacity: 0.8;">Import data loker via Excel atau kelola pelamar.</p>
        </div>
        
        <div class="d-flex flex-column align-items-end gap-2">
            
            {{-- TOMBOL DOWNLOAD TEMPLATE --}}
            <a href="{{ route('admin.lokers.template') }}" class="btn btn-sm btn-outline-info text-decoration-none">
                📄 Download Template Excel
            </a>

            {{-- Form Import Excel --}}
            <form action="{{ route('admin.lokers.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                @csrf
                <div class="input-group shadow-sm">
                    <input type="file" name="file" class="form-control form-control-dark" required accept=".csv, .xls, .xlsx">
                    <button type="submit" class="btn btn-success text-dark fw-bold">
                        📥 Import Excel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL DALAM CARD --}}
    <div class="card shadow-lg border-0" style="background-color: #2c3e50;">
        <div class="card-body p-0">
            <div class="table-responsive rounded-3">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr style="background-color: #34495e;">
                            <th class="py-3 ps-4 text-white border-bottom border-secondary" width="5%">No</th>
                            <th class="py-3 text-white border-bottom border-secondary" width="30%">Posisi (Title)</th>
                            <th class="py-3 text-white border-bottom border-secondary">Lokasi</th>
                            <th class="py-3 text-white border-bottom border-secondary">Deadline</th>
                            <th class="py-3 text-white border-bottom border-secondary">Pelamar</th>
                            <th class="py-3 pe-4 text-white text-end border-bottom border-secondary">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lokers as $loker)
                        <tr>
                            <td class="ps-4 text-white-50">{{ $lokers->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="fw-bold text-white">{{ $loker->title }}</div>
                                <small class="text-light" style="opacity: 0.7;">{{ Str::limit($loker->description, 50) }}</small>
                            </td>
                            <td class="text-white-50">
                                📍 {{ $loker->location ?? 'Remote' }}
                            </td>
                            <td>
                                @if($loker->deadline)
                                    <span class="badge bg-dark border border-secondary text-warning">
                                        {{ \Carbon\Carbon::parse($loker->deadline)->format('d M Y') }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $loker->applies_count > 0 ? 'bg-info text-dark' : 'bg-secondary text-white-50' }}">
                                    👥 {{ $loker->applies_count }} Orang
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                @if($loker->applies_count > 0)
                                    <div class="btn-group" role="group">
                                        {{-- Tombol Detail Pelamar --}}
                                        <a href="{{ route('admin.lokers.applicants', $loker->id) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail Pelamar">
                                            👁 Detail
                                        </a>
                                        
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.lokers.edit', $loker->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Loker">
                                            ✏️ Edit
                                        </a>
                                    </div>
                                @else
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-secondary" disabled>
                                            ❌ Kosong
                                        </button>
                                        
                                        {{-- Tombol Edit (Tetap muncul meski pelamar kosong) --}}
                                        <a href="{{ route('admin.lokers.edit', $loker->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Loker">
                                            ✏️ Edit
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        {{-- EMPTY STATE --}}
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="empty-state-icon">📂</div> 
                                    <h5 class="mt-2 text-white fw-bold">Belum ada data loker</h5>
                                    <p class="text-light mb-0" style="opacity: 0.8;">
                                        Silakan import file Excel untuk menambahkan lowongan.
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- PAGINATION --}}
        @if($lokers->hasPages())
        <div class="card-footer border-top border-secondary bg-transparent py-3">
            <div class="d-flex justify-content-end">
                {{ $lokers->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection