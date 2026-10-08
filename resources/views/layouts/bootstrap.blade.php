<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventaris Alat Medis') - RS Medika Alkes</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.15);
        }
        .card-custom {
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }
        .btn-teal {
            background-color: #0d9488;
            color: #ffffff;
            border: none;
        }
        .btn-teal:hover {
            background-color: #0f766e;
            color: #ffffff;
        }
        .badge-location {
            background-color: #ccfbf1;
            color: #0f766e;
            font-weight: 600;
        }
        .badge-year {
            background-color: #e0f2fe;
            color: #0369a1;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex items-center gap-2" href="{{ route('alat.index') }}">
                <span class="fs-4">🩺</span>
                <div>
                    <div>Sistem Inventaris Alat Medis</div>
                    <small class="d-block fw-normal text-white-50 fs-6" style="font-size: 0.75rem !important;">Rumah Sakit & Laboratorium Alkes</small>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('alat.index') ? 'active fw-semibold' : '' }}" href="{{ route('alat.index') }}">
                            <i class="bi bi-list-ul me-1"></i> Data Inventaris
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('alat.create') ? 'active fw-semibold' : '' }}" href="{{ route('alat.create') }}">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Alat
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-light btn-sm rounded-pill px-3 py-1" href="{{ url('/') }}">
                            <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Dashboard Vue
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-4 flex-grow-1">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show card-custom border-success-subtle shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-4 me-2 text-success"></i>
                    <div>
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show card-custom border-danger-subtle shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-start">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-2 text-danger"></i>
                    <div>
                        <strong>Terjadi Kesalahan Input:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top py-3 text-center text-muted small mt-auto">
        <div class="container">
            <span>&copy; {{ date('Y') }} Sistem Inventaris Alat Medis • Modul CRUD Praktikum Laravel & Bootstrap 5</span>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
