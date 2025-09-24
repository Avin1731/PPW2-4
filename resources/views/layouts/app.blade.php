<!DOCTYPE html>
<html>
<head>
    <title>Pustaka Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS untuk tabel */
        .table-modern thead {
            background-color: #007bff !important;
            color: white !important;
        }
        .table-modern tbody tr:nth-child(odd) {
            background-color: #f8f9fa !important;
        }
        .table-modern tbody tr:hover {
            background-color: #e2f4ff !important;
        }
        /* CSS baru untuk header tabel */
        .table-bordered thead th {
            text-align: center; /* Rata tengah horizontal */
        }

        /* CSS baru untuk tombol Aksi */
        .aksi-buttons {
            display: flex;
            justify-content: center; /* Rata tengah horizontal */
            gap: 5px; /* Jarak antar tombol */
        }
        .aksi-buttons .btn {
            min-width: 70px; /* Lebar minimum untuk semua tombol */
            text-align: center;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- Header --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">📚 Pustaka Buku</a>
            <div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('buku.index') }}">Data Buku</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <main class="flex-fill">
        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p>© {{ date('Y') }} Pustaka Buku | Laravel Demo</p>
    </footer>

</body>
</html>