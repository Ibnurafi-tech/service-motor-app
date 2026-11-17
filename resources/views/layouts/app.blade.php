<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Service Motor App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #111827;
            --sidebar-hover: #1f2937;
            --accent-color: #2563eb;
        }
        body {
            background-color: #f3f4f6;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            color: #f9fafb;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.25s ease;
        }
        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .sidebar .nav-link {
            color: #9ca3af;
            padding: 0.72rem 1.25rem;
            margin: 0.2rem 0.75rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: #ffffff;
        }
        .sidebar .nav-link.active {
            background-color: var(--accent-color);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.9rem 1.75rem;
        }
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebarMenu">
        <div class="sidebar-brand d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-tools fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold text-white lh-1">BengkelPro</div>
                    <small class="text-secondary" style="font-size: 0.75rem;">Service Motor App</small>
                </div>
            </div>
            <button class="btn btn-sm btn-outline-light d-lg-none" id="closeSidebar">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="py-3">
            <div class="px-4 mb-2 text-uppercase text-secondary fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.06em;">Menu Utama</div>
            <nav class="nav flex-column">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('pelanggan.index') }}" class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Data Pelanggan</span>
                </a>
                <a href="{{ route('kendaraan.index') }}" class="nav-link {{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
                    <i class="bi bi-bicycle"></i>
                    <span>Data Kendaraan</span>
                </a>
                <a href="{{ route('daftar-service.index') }}" class="nav-link {{ request()->routeIs('daftar-service.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-plus"></i>
                    <span>Daftar Service</span>
                </a>
                <a href="{{ route('data-service.index') }}" class="nav-link {{ request()->routeIs('data-service.*') ? 'active' : '' }}">
                    <i class="bi bi-wrench-adjustable-circle"></i>
                    <span>Data Service</span>
                </a>
                <a href="{{ route('pembayaran-service.index') }}" class="nav-link {{ request()->routeIs('pembayaran-service.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i>
                    <span>Pembayaran Service</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <header class="topbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary btn-sm d-lg-none" id="toggleSidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h5 class="mb-0 fw-semibold text-dark">@yield('page_title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-2 text-muted small">
                <i class="bi bi-calendar3"></i>
                <span>{{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </header>

        <main class="p-4 flex-grow-1">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Terjadi kesalahan input:</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleSidebar')?.addEventListener('click', function () {
            document.getElementById('sidebarMenu').classList.add('show');
        });
        document.getElementById('closeSidebar')?.addEventListener('click', function () {
            document.getElementById('sidebarMenu').classList.remove('show');
        });
    </script>
    @stack('scripts')
</body>
</html>
