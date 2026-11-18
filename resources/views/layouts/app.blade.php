<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MotorCare â€“ Sistem Manajemen Servis Motor')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --mc-navy: #172554;
            --mc-navy-light: #1e3a8a;
            --mc-navy-hover: rgba(255, 255, 255, 0.08);
            --mc-orange: #F97316;
            --mc-orange-hover: #EA580C;
            --mc-orange-soft: #FFF7ED;
            --mc-bg: #F8FAFC;
            --mc-surface: #FFFFFF;
            --mc-text-primary: #1E293B;
            --mc-text-secondary: #64748B;
            --mc-border: #E2E8F0;
            --mc-success: #16A34A;
            --mc-warning: #F59E0B;
            --mc-danger: #EF4444;
            --sidebar-width: 268px;
        }

        * {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--mc-bg);
            color: var(--mc-text-primary);
            font-size: 0.9375rem;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background-color: var(--mc-navy);
            color: #F8FAFC;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease;
            box-shadow: 4px 0 24px rgba(15, 23, 42, 0.08);
        }

        .sidebar-brand {
            padding: 1.35rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background-color: var(--mc-orange);
            color: #FFFFFF;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .sidebar-section-label {
            padding: 0 1.5rem;
            margin-bottom: 0.45rem;
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(203, 213, 225, 0.55);
        }

        .sidebar .nav-link {
            color: #CBD5E1;
            padding: 0.72rem 1.15rem;
            margin: 0.15rem 0.85rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.18s ease;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            opacity: 0.85;
        }

        .sidebar .nav-link:hover {
            background-color: var(--mc-navy-hover);
            color: #FFFFFF;
        }

        .sidebar .nav-link.active {
            background-color: var(--mc-orange);
            color: #FFFFFF;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.35);
        }

        .sidebar .nav-link.active i {
            opacity: 1;
        }

        /* Main Layout */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background-color: var(--mc-surface);
            border-bottom: 1px solid var(--mc-border);
            padding: 0.85rem 1.75rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* Cards & Tables */
        .card {
            background-color: var(--mc-surface);
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
        }

        .card-header {
            background-color: var(--mc-surface);
            border-bottom: 1px solid var(--mc-border);
            border-top-left-radius: 14px !important;
            border-top-right-radius: 14px !important;
        }

        .table thead th {
            background-color: #F8FAFC;
            color: var(--mc-text-secondary);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--mc-border);
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
        }

        .table tbody td {
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
            border-bottom: 1px solid #F1F5F9;
            color: var(--mc-text-primary);
        }

        .table-hover tbody tr:hover {
            background-color: #F8FAFC;
        }

        /* MotorCare Buttons & Utilities */
        .btn-mc-orange {
            background-color: var(--mc-orange);
            border-color: var(--mc-orange);
            color: #FFFFFF;
            font-weight: 600;
        }

        .btn-mc-orange:hover, .btn-mc-orange:focus {
            background-color: var(--mc-orange-hover);
            border-color: var(--mc-orange-hover);
            color: #FFFFFF;
        }

        .btn-mc-navy {
            background-color: var(--mc-navy);
            border-color: var(--mc-navy);
            color: #FFFFFF;
            font-weight: 600;
        }

        .btn-mc-navy:hover, .btn-mc-navy:focus {
            background-color: var(--mc-navy-light);
            border-color: var(--mc-navy-light);
            color: #FFFFFF;
        }

        .text-mc-navy { color: var(--mc-navy) !important; }
        .text-mc-orange { color: var(--mc-orange) !important; }
        .bg-mc-navy { background-color: var(--mc-navy) !important; }
        .bg-mc-orange { background-color: var(--mc-orange) !important; }

        .badge-soft-success {
            background-color: #DCFCE7;
            color: #15803D;
            font-weight: 600;
        }

        .badge-soft-warning {
            background-color: #FEF3C7;
            color: #B45309;
            font-weight: 600;
        }

        .badge-soft-danger {
            background-color: #FEE2E2;
            color: #B91C1C;
            font-weight: 600;
        }

        .badge-soft-navy {
            background-color: #DBEAFE;
            color: #1E3A8A;
            font-weight: 600;
        }

        .badge-soft-orange {
            background-color: #FFEDD5;
            color: #C2410C;
            font-weight: 600;
        }

        .form-control, .form-select {
            border-color: var(--mc-border);
            border-radius: 8px;
            padding: 0.55rem 0.85rem;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--mc-orange);
            box-shadow: 0 0 0 0.2rem rgba(249, 115, 22, 0.16);
        }

        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.15);
        }

        .modal-header {
            border-bottom: 1px solid var(--mc-border);
            padding: 1.25rem 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid var(--mc-border);
            padding: 1rem 1.5rem;
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            z-index: 1025;
        }

        .sidebar-backdrop.show {
            display: block;
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

        @media print {
            .sidebar, .topbar, .no-print, .sidebar-backdrop {
                display: none !important;
            }
            .main-wrapper {
                margin-left: 0 !important;
            }
            body {
                background-color: #FFFFFF !important;
            }
            .card {
                border: 1px solid #CBD5E1 !important;
                box-shadow: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebarMenu">
        <div class="sidebar-brand d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2.5 text-decoration-none">
                <div class="brand-icon me-2">
                    <i class="bi bi-gear-wide-connected"></i>
                </div>
                <div>
                    <div class="fw-bold text-white fs-5 lh-1 tracking-tight">Motor<span style="color: var(--mc-orange);">Care</span></div>
                    <small class="text-white-50" style="font-size: 0.72rem;">Workshop Management</small>
                </div>
            </a>
            <button class="btn btn-sm btn-outline-light d-lg-none" id="closeSidebar" type="button">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="py-3 flex-grow-1 overflow-y-auto">
            <div class="sidebar-section-label">Operasional Bengkel</div>
            <nav class="nav flex-column mb-3">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('pelanggan.index') }}" class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Data Pelanggan</span>
                </a>
                <a href="{{ route('kendaraan.index') }}" class="nav-link {{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
                    <i class="bi bi-bicycle"></i>
                    <span>Data Kendaraan</span>
                </a>
                <a href="{{ route('daftar-service.index') }}" class="nav-link {{ request()->routeIs('daftar-service.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-plus-fill"></i>
                    <span>Daftar Servis</span>
                </a>
                <a href="{{ route('data-service.index') }}" class="nav-link {{ request()->routeIs('data-service.*') ? 'active' : '' }}">
                    <i class="bi bi-wrench-adjustable-circle-fill"></i>
                    <span>Data Servis</span>
                </a>
                <a href="{{ route('pembayaran-service.index') }}" class="nav-link {{ request()->routeIs('pembayaran-service.*') ? 'active' : '' }}">
                    <i class="bi bi-credit-card-2-front-fill"></i>
                    <span>Pembayaran Servis</span>
                </a>
            </nav>

            <div class="sidebar-section-label">Sistem & Akun</div>
            <nav class="nav flex-column">
                <a href="{{ route('profil.index') }}" class="nav-link {{ request()->routeIs('profil.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>Profil & Pengaturan</span>
                </a>
            </nav>
        </div>

        <div class="p-3 border-top border-white border-opacity-10">
            <div class="d-flex align-items-center gap-2 px-2 py-1 rounded-3" style="background: rgba(255,255,255,0.05);">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0" style="width: 34px; height: 34px; background-color: var(--mc-orange); font-size: 0.85rem;">
                    {{ strtoupper(substr(session('mc_user.name', 'Admin Bengkel'), 0, 2)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-white fw-semibold text-truncate" style="font-size: 0.82rem;">{{ session('mc_user.name', 'Admin Bengkel') }}</div>
                    <div class="text-white-50 text-truncate" style="font-size: 0.7rem;">{{ session('mc_user.role', 'Kepala Administrasi') }}</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <header class="topbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary btn-sm d-lg-none" id="toggleSidebar" type="button">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div>
                    <h5 class="mb-0 fw-bold text-mc-navy">@yield('page_title', 'Dashboard')</h5>
                    @hasSection('page_subtitle')
                        <div class="text-muted small">@yield('page_subtitle')</div>
                    @endif
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-md-flex align-items-center gap-2 px-3 py-1.5 rounded-pill border bg-light text-secondary small">
                    <i class="bi bi-calendar3 text-mc-orange"></i>
                    <span>{{ now()->translatedFormat('d M Y') }}</span>
                </div>

                <!-- Notifikasi Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light border position-relative rounded-circle p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 38px; height: 38px;">
                        <i class="bi bi-bell text-mc-navy"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-mc-orange border border-light rounded-circle"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow border-0 p-0" style="width: 310px; border-radius: 12px;">
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-mc-navy small">Notifikasi Bengkel</span>
                            <span class="badge badge-soft-orange">Aktif</span>
                        </div>
                        <div class="p-3 small text-secondary">
                            <div class="d-flex gap-2 mb-2 pb-2 border-bottom">
                                <i class="bi bi-tools text-mc-orange mt-1"></i>
                                <div>
                                    <div class="fw-semibold text-dark">Pantau Antrean Servis</div>
                                    <div>Cek status pengerjaan mekanik & pembayaran di Dashboard.</div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <i class="bi bi-check-circle text-success mt-1"></i>
                                <div>
                                    <div class="fw-semibold text-dark">Sistem MotorCare Siap</div>
                                    <div>Database & REST API terhubung normal.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profil Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light border d-flex align-items-center gap-2 rounded-pill py-1 px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white" style="width: 28px; height: 28px; background-color: var(--mc-navy); font-size: 0.75rem;">
                            {{ strtoupper(substr(session('mc_user.name', 'Admin Bengkel'), 0, 1)) }}
                        </div>
                        <span class="d-none d-sm-inline small fw-semibold text-dark">{{ session('mc_user.name', 'Admin Bengkel') }}</span>
                        <i class="bi bi-chevron-down small text-muted"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="border-radius: 12px; min-width: 200px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-bold small text-mc-navy">{{ session('mc_user.name', 'Admin Bengkel') }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ session('mc_user.email', 'admin@motorcare.id') }}</div>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 small" href="{{ route('profil.index') }}">
                                <i class="bi bi-person-gear me-2 text-mc-orange"></i>Profil & Pengaturan
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form action="{{ route('profil.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 small text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar / Reset Sesi
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="p-3 p-md-4 flex-grow-1">
            @if(session('success'))
                <div class="alert alert-success border-0 border-start border-success border-4 alert-dismissible fade show shadow-sm bg-white" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-5 me-2"></i>
                        <div class="fw-medium text-dark">{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 border-start border-danger border-4 alert-dismissible fade show shadow-sm bg-white" role="alert">
                    <div class="fw-bold text-danger mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Terjadi kesalahan input:</div>
                    <ul class="mb-0 ps-3 small text-dark">
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
        const sidebar = document.getElementById('sidebarMenu');
        const backdrop = document.getElementById('sidebarBackdrop');
        document.getElementById('toggleSidebar')?.addEventListener('click', function () {
            sidebar.classList.add('show');
            backdrop.classList.add('show');
        });
        function closeMobileSidebar() {
            sidebar.classList.remove('show');
            backdrop.classList.remove('show');
        }
        document.getElementById('closeSidebar')?.addEventListener('click', closeMobileSidebar);
        backdrop?.addEventListener('click', closeMobileSidebar);
    </script>
    @stack('scripts')
</body>
</html>
