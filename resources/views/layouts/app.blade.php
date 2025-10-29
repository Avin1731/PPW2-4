<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pustaka Buku')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-modern thead { background-color: #007bff !important; color: white !important; }
        .table-modern tbody tr:nth-child(odd) { background-color: #f8f9fa !important; }
        .table-modern tbody tr:hover { background-color: #e2f4ff !important; }
        .table-bordered thead th { text-align: center; }
        .aksi-buttons { display: flex; justify-content: center; gap: 5px; }
        .aksi-buttons .btn { min-width: 70px; text-align: center; }
        .fade-in { opacity: 0; transform: translateY(10px); animation: fadeIn 0.6s ease-in-out forwards; }
        @keyframes fadeIn { to { opacity: 1; transform: translateY(0); } }
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
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @yield('content')
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p class="mb-0">© {{ date('Y') }} Pustaka Buku | Dibuat dengan ❤️ menggunakan Laravel</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
