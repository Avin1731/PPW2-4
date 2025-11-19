@extends('layouts.app')

@section('title', 'Edit Loker')

@section('content')

{{-- STYLE KHUSUS HALAMAN INI --}}
<style>
    /* Input Form Dark Mode */
    .form-control-dark {
        background-color: #34495e; 
        color: #ecf0f1;          
        border: 1px solid #4a627a;
    }
    .form-control-dark:focus {
        background-color: #34495e; 
        color: #ffffff;
        border-color: #f39c12; /* Aksen Kuning (Warning) saat fokus karena ini Edit */
        box-shadow: 0 0 0 0.25rem rgba(243, 156, 18, 0.25);
    }
    /* Placeholder agar tidak terlalu gelap */
    .form-control-dark::placeholder {
        color: #95a5a6;
    }
    /* Readonly input (jika ada) */
    .form-control-dark:disabled, .form-control-dark[readonly] {
        background-color: #2c3e50;
        opacity: 1;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('admin.lokers.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block">
                &larr; Kembali ke Daftar
            </a>

            <div class="card shadow-lg border-0" style="background-color: #2c3e50;">
                
                {{-- Header Card --}}
                <div class="card-header border-secondary bg-transparent text-white py-3">
                    <h4 class="mb-0 fw-bold">
                        ✏️ Edit Lowongan Kerja
                    </h4>
                </div>

                <div class="card-body p-4 text-white">
                    <form action="{{ route('admin.lokers.update', $loker->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Judul --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold text-info">Judul Loker</label>
                            <input type="text" name="title" class="form-control form-control-dark" 
                                   value="{{ $loker->title }}" placeholder="Contoh: Senior Backend Engineer" required>
                        </div>

                        {{-- Posisi (Multi) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold text-info">Posisi Tersedia <small class="text-muted fw-normal">(Pisahkan dengan koma)</small></label>
                            <input type="text" name="available_positions" class="form-control form-control-dark" 
                                   value="{{ $loker->available_positions }}" placeholder="Contoh: Frontend, Backend, DevOps">
                        </div>

                        <div class="row">
                            {{-- Lokasi --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-info">Lokasi</label>
                                <input type="text" name="location" class="form-control form-control-dark" 
                                       value="{{ $loker->location }}" placeholder="Contoh: Jakarta Selatan (Hybrid)">
                            </div>

                            {{-- Deadline --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-info">Deadline</label>
                                <input type="date" name="deadline" class="form-control form-control-dark" 
                                       value="{{ $loker->deadline ? \Carbon\Carbon::parse($loker->deadline)->format('Y-m-d') : '' }}">
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-info">Deskripsi Pekerjaan</label>
                            <textarea name="description" rows="6" class="form-control form-control-dark" 
                                      placeholder="Tuliskan deskripsi pekerjaan, kualifikasi, dan benefit..." required>{{ $loker->description }}</textarea>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary">
                            <a href="{{ route('admin.lokers.index') }}" class="btn btn-outline-secondary px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-warning fw-bold px-4 text-dark">
                                💾 Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection