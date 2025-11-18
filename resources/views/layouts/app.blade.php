<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pustaka Buku')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* ==============================
           TEMA GELAP "ADEM" (VERSI FINAL)
        ==============================
        */

        body {
            background-color: #1f2833; 
            color: #ecf0f1 !important; 
        }

        .navbar-brand {
            color: #4ecca3 !important; 
            font-weight: 500;
        }
        .navbar .btn-link.nav-link {
            color: rgba(255, 255, 255, 0.55); padding-left: 0; padding-right: 0;
        }
        .navbar .btn-link.nav-link:hover { color: rgba(255, 255, 255, 0.75); }

        /* DOKUMENTASI: Style untuk dropdown menu baru */
        .dropdown-menu {
            background-color: #2c3e50; /* Latar gelap */
            border: 1px solid #34495e;
        }
        .dropdown-item {
            color: #ecf0f1; /* Teks putih */
        }
        .dropdown-item:hover {
            background-color: #34495e; /* Hover lebih gelap */
            color: #4ecca3; /* Aksen mint */
        }
        .dropdown-divider {
            border-top: 1px solid #34495e;
        }
        /* --- Batas Style Dropdown --- */

        h4, h3, h5 {
            color: #ffffff;
            border-bottom: 1px solid #34495e;
            padding-bottom: 10px;
        }

        .form-control,
        .form-select {
            background-color: #34495e; color: #ecf0f1; border: 1px solid #4a627a;
        }
        .form-control::placeholder { color: #bdc3c7; }
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ecf0f1' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        }

        /* Tombol Aksen (Cari & Tambah) */
        .btn-primary, .btn-success {
            background-color: #4ecca3; border-color: #4ecca3; color: #1f2833; font-weight: 500;
        }
        .btn-primary:hover, .btn-success:hover {
            background-color: #58e0b0; border-color: #58e0b0; color: #1f2833;
        }

        /* --- STYLING TABEL (Rounded) --- */
        .table {
            color: #ecf0f1 !important; 
            border-color: #34495e !important;
            --bs-table-bg: #2c3e50 !important;
            --bs-table-striped-bg: #2c3e50 !important;
            --bs-table-color: #ecf0f1 !important;
            
            border-radius: 8px;
            overflow: hidden; 
        }

        /* Target THEAD (Header) */
        .table > thead,
        .table > thead > tr,
        .table > thead > tr > th {
            background-color: #34495e !important; 
            color: #ffffff !important;
            border-bottom: 2px solid #4ecca3 !important; 
        }
        
        /* Target TBODY (Body) */
        .table > tbody,
        .table > tbody > tr {
            background-color: #2c3e50 !important; 
            color: #ecf0f1 !important;
        }

        /* Target TD (Sel) */
        .table > tbody > tr > td {
             background-color: #2c3e50 !important; 
             color: #ecf0f1 !important;
        }

        /* Target Hover */
        .table > tbody > tr:hover,
        .table > tbody > tr:hover > td {
            background-color: #34495e !important; 
            color: #ffffff !important;
        }
        
        .table-modern tbody tr:nth-child(odd) {
             background-color: #2c3e50 !important; 
        }
        .table-modern tbody tr:hover {
             background-color: #34495e !important; 
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #34495e !important; 
        }
        /* --- BATAS STYLING TABEL --- */

        /* --- Tombol Aksi (Outline) --- */
        .aksi-buttons { display: flex; justify-content: center; gap: 5px; }
        .aksi-buttons .btn { min-width: 70px; text-align: center; }
        
        .btn-info {
            background-color: transparent; border-color: #3498db; color: #3498db;
        }
        .btn-info:hover { background-color: #3498db; color: #ffffff; }
        .btn-warning {
             background-color: transparent; border-color: #f39c12; color: #f39c12;
        }
        .btn-warning:hover { background-color: #f39c12; color: #1f2833; }
        .btn-danger {
             background-color: transparent; border-color: #e74c3c; color: #e74c3c;
        }
         .btn-danger:hover { background-color: #e74c3c; color: #ffffff; }
        .btn-secondary {
            background-color: transparent; border-color: #95a5a6; color: #95a5a6;
        }
        .btn-secondary:hover { background-color: #95a5a6; color: #1f2833; }

        /* --- STYLING KARTU (STATISTIK & DETAIL) --- */
        .card {
            background-color: #2c3e50; border: 1px solid #34495e; color: #ecf0f1;
            border-radius: 8px; /* Sekalian samakan cardnya */
        }
        .card-header {
            background-color: #34495e; border-bottom: 1px solid #4a627a; color: #ffffff;
        }
        .card-body { color: #ecf0f1; }
        .card-footer {
            background-color: #34495e; border-top: 1px solid #4a627a;
        }
        .card.bg-primary, .card.bg-success, .card.bg-info, .card.bg-warning {
            background-color: #2c3e50 !important; border: 1px solid #34495e;
        }
        .card.bg-primary .card-header, 
        .card.bg-success .card-header, 
        .card.bg-info .card-header, 
        .card.bg-warning .card-header {
            background-color: #34495e !important; color: #4ecca3 !important;
        }
        .card.bg-warning .card-header {
             color: #f39c12 !important; 
        }
        .card.bg-primary h3, .card.bg-success h3, .card.bg-info h3, .card.bg-warning h3 {
            color: #ffffff !important;
        }
        
        /* --- STYLING ALERT --- */
        .alert-success {
            background-color: #2c3e50; color: #4ecca3; border-color: #4ecca3;
        }
        .alert-warning {
             background-color: #34495e; color: #f39c12; border-color: #f39c12;
        }

        /* Footer */
        footer.bg-dark {
            background-color: #1a1a2e !important; border-top: 1px solid #34495e;
        }
        .fade-in { opacity: 1; transform: none; animation: none; }

    </style>
    </head>

<body class="d-flex flex-column min-vh-100">

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ Auth::check() ? route('dashboard') : route('welcome') }}">
                📚 Pustaka Buku
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('buku.index') }}">Data Buku</a>
                        </li>

                        {{-- === LOGIC MENU LOKER (BARU) === --}}
                        @if(Auth::user()->role == 'admin')
                            {{-- Menu Admin --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.lokers.*') ? 'active' : '' }}" 
                                   href="{{ route('admin.lokers.index') }}">
                                   Kelola Loker
                                </a>
                            </li>
                        @else
                            {{-- Menu User Biasa --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('lokers.*') ? 'active' : '' }}" 
                                   href="{{ route('lokers.index') }}">
                                   Info Loker
                                </a>
                            </li>
                        @endif
                        {{-- === BATAS LOGIC MENU LOKER === --}}


                        @if(Auth::user()->role == 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="analyticsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Perangkat Analisis
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="analyticsDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.analytics.index') }}">📈 Dashboard Grafik</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.history.users') }}">Riwayat Pendaftaran</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.history.activity') }}">Riwayat Aktivitas</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.reports.buku.excel') }}">Unduh Laporan (Excel)</a></li>
                            </ul>
                        </li>
                        @endif
                        @endauth
                </ul>

                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <span class="nav-link text-white">Halo, {{ Auth::user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- KONTEN --}}
    <main class="flex-fill">
        <div class="container mt-4 fade-in">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            {{-- Tambahan alert untuk error jika import gagal --}}
            @if(session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p class="mb-0">© {{ date('Y') }} Pustaka Buku | Dibuat dengan ❤️ menggunakan Laravel</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>