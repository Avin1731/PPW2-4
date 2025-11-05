@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@section('content')
    <h4 class="mb-4">Riwayat Aktivitas Sistem</h4>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Log</th>
                            <th>Deskripsi</th>
                            <th>Model</th>
                            <th>Dilakukan Oleh</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                            <tr>
                                <td>{{ $activity->log_name }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>
                                    {{ Str::afterLast($activity->subject_type, '\\') }}
                                </td>
                                <td>
                                    {{ $activity->causer->name ?? 'Sistem' }}
                                </td>
                                <td>{{ $activity->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada aktivitas yang tercatat. Coba buat/edit buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
@endsection