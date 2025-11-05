@extends('layouts.app')

@section('title', 'Dashboard Analisis')

@section('content')
    <h4 class="mb-4">Dashboard Analisis</h4>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Total Kunjungan (Page Views)</div>
                <div class="card-body">
                    <h3 class="display-4">{{ $totalVisits }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Total User Terdaftar</div>
                <div class="card-body">
                    <h3 class="display-4">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Total Judul Buku</div>
                <div class="card-body">
                    <h3 class="display-4">{{ $totalBuku }}</h3>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mt-4 mb-3">Pendaftaran User (30 Hari Terakhir)</h4>
    <div class="card">
        <div class="card-body">
            <canvas id="userRegistrationChart"></canvas>
        </div>
    </div>

    <h4 class="mt-4 mb-3">Kunjungan Halaman (30 Hari Terakhir)</h4>
    <div class="card">
        <div class="card-body">
            <canvas id="pageVisitChart"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- GRAFIK 1: PENDAFTARAN USER (LINE CHART) ---
    const labels = @json($chartLabels);
    const data = @json($chartData);
    const ctx = document.getElementById('userRegistrationChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'User Baru',
                data: data,
                backgroundColor: 'rgba(78, 204, 163, 0.2)',
                borderColor: '#4ecca3',
                borderWidth: 2,
                tension: 0.1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });

    // --- DOKUMENTASI: GRAFIK 2: KUNJUNGAN HALAMAN (BAR CHART) ---
    const visitLabels = @json($visitChartLabels);
    const visitData = @json($visitChartData);
    const ctxVisit = document.getElementById('pageVisitChart').getContext('2d');

    new Chart(ctxVisit, {
        type: 'bar', // Tipe grafik (bar)
        data: {
            labels: visitLabels,
            datasets: [{
                label: 'Kunjungan Halaman',
                data: visitData,
                backgroundColor: 'rgba(52, 152, 219, 0.5)', // Warna Biru
                borderColor: '#3498db',
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endpush