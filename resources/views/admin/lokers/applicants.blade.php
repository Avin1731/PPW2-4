@extends('layouts.app')

@section('title', 'Data Pelamar')

@section('content')

{{-- CSS Khusus Halaman Ini --}}
<style>
    /* Table Hover Dark Mode */
    .table-hover tbody tr:hover {
        background-color: #34495e;
    }
    
    /* Badge Status */
    .badge-status-pending { background-color: #f39c12; color: #fff; }
    .badge-status-accepted { background-color: #4ecca3; color: #1f2833; }
    .badge-status-rejected { background-color: #e74c3c; color: #fff; }

    /* Custom Pagination Dark Mode */
    .pagination { margin-bottom: 0; justify-content: flex-end; }
    .pagination .page-item .page-link { background-color: #34495e; border-color: #4a627a; color: #ecf0f1; }
    .pagination .page-item .page-link:hover { background-color: #2c3e50; border-color: #4ecca3; color: #4ecca3; }
    .pagination .page-item.active .page-link { background-color: transparent; border-color: #4ecca3; color: #4ecca3; font-weight: bold; }
    .pagination .page-item.disabled .page-link { background-color: #2c3e50; border-color: #4a627a; color: #6c757d; }
</style>

<div class="container">
    
    {{-- Header / Breadcrumb --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <div>
            <a href="{{ route('admin.lokers.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
                &larr; Kembali ke Daftar Loker
            </a>
            <h2 class="fw-bold text-white mb-0">
                👨‍💻 Pelamar: <span class="text-info">{{ $loker->title }}</span>
            </h2>
            <p class="text-white-50 mb-0">Total Pelamar Masuk: <strong>{{ $applicants->total() }}</strong> Orang</p>
        </div>
        
        {{-- Tombol Export CSV --}}
        <a href="{{ route('admin.lokers.export', $loker->id) }}" class="btn btn-outline-success fw-bold">
            📥 Export Data (CSV)
        </a>
    </div>

    {{-- Tabel Pelamar --}}
    <div class="card shadow-lg border-0" style="background-color: #2c3e50;">
        <div class="card-body p-0">
            <div class="table-responsive rounded-3">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr style="background-color: #34495e;">
                            <th class="py-3 ps-4 text-white border-bottom border-secondary">No</th>
                            <th class="py-3 text-white border-bottom border-secondary">Nama & Email</th>
                            <th class="py-3 text-white border-bottom border-secondary">Posisi Dilamar</th>
                            <th class="py-3 text-white border-bottom border-secondary">Tanggal Apply</th>
                            <th class="py-3 text-white border-bottom border-secondary">CV</th>
                            <th class="py-3 text-white border-bottom border-secondary">Status</th>
                            <th class="py-3 pe-4 text-white text-end border-bottom border-secondary" style="min-width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applicants as $apply)
                        <tr>
                            <td class="ps-4 text-white-50">{{ $applicants->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="fw-bold text-white">{{ $apply->user->name }}</div>
                                <small class="text-white-50">{{ $apply->user->email }}</small>
                            </td>
                            <td class="text-white">
                                @if($apply->selected_position)
                                    <span class="badge bg-dark border border-secondary">{{ $apply->selected_position }}</span>
                                @else
                                    <span class="text-muted fst-italic">- Umum -</span>
                                @endif
                            </td>
                            <td class="text-white-50">
                                {{ $apply->created_at->format('d M Y') }} <br>
                                <small class="text-muted">{{ $apply->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                <a href="{{ asset('storage/' . $apply->cv_path) }}" target="_blank" class="btn btn-sm btn-info text-dark fw-bold">
                                    📄 Lihat PDF
                                </a>
                            </td>
                            <td>
                                @if($apply->status == 'pending')
                                    <span class="badge badge-status-pending">⏳ Pending</span>
                                @elseif($apply->status == 'accepted')
                                    <span class="badge badge-status-accepted">✅ Diterima</span>
                                @else
                                    <span class="badge badge-status-rejected">❌ Ditolak</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- Tombol Terima --}}
                                    <form action="{{ route('admin.applies.status', $apply->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="accepted">
                                        <button type="submit" class="btn btn-sm btn-success" 
                                            {{ $apply->status == 'accepted' ? 'disabled' : '' }} 
                                            title="Terima Lamaran"
                                            onclick="return confirm('Yakin ingin MENERIMA pelamar ini?')">
                                            ✔
                                        </button>
                                    </form>

                                    {{-- Tombol Tolak --}}
                                    <form action="{{ route('admin.applies.status', $apply->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                            {{ $apply->status == 'rejected' ? 'disabled' : '' }} 
                                            title="Tolak Lamaran"
                                            onclick="return confirm('Yakin ingin MENOLAK pelamar ini?')">
                                            ✖
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div style="font-size: 3rem; opacity: 0.5; color: #6c757d;">📭</div>
                                    <h5 class="text-white mt-3">Belum ada pelamar</h5>
                                    <p class="text-white-50">Pelamar yang masuk akan muncul di tabel ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($applicants->hasPages())
        <div class="card-footer border-top border-secondary bg-transparent py-3">
            <div class="d-flex justify-content-end">
                {{ $applicants->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection