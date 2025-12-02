<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Approval App</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* CSS untuk Sidebar dan Layout */
        body {
            min-height: 100vh;
            background-color: var(--bs-body-bg);
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            transition: all 0.3s;
            background-color: var(--bs-tertiary-bg);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .main-content {
            margin-left: 260px;
            transition: all 0.3s;
            padding: 1.5rem;
        }

        .sidebar-heading {
            padding: 1rem 1.25rem;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--bs-emphasis-color);
        }

        .sidebar .nav-link {
            padding: 0.75rem 1.25rem;
            color: var(--bs-body-color);
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 1rem;
            text-align: center;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--bs-secondary-bg);
            color: var(--bs-emphasis-color);
            border-radius: 0.5rem;
        }

        .navbar.topbar {
            margin-left: 260px;
            background-color: var(--bs-body-bg);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* Dark Mode */
        [data-bs-theme="dark"] .sidebar {
            background-color: var(--bs-tertiary-bg);
            box-shadow: 0 0.125rem 0.25rem rgba(255, 255, 255, 0.075);
        }
        [data-bs-theme="dark"] .navbar.topbar {
            background-color: var(--bs-body-bg);
            box-shadow: 0 0.125rem 0.25rem rgba(255, 255, 255, 0.075);
        }

    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-heading text-center">
                <i class="fa-solid fa-check-double me-2"></i>
                <span>ApprovalApp</span>
            </div>

            <ul class="nav flex-column p-3">
                @auth
                    {{-- MENU ADMIN --}}
                    @if(auth()->user()->role === $UserRole::ADMIN)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}" href="{{ route('dashboard.admin') }}">
                                <i class="fa-solid fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            {{-- UPDATE: Link ke Approval --}}
                            <a class="nav-link"  href="{{ route('admin.approval.index') }}">
                                <i class="fa-solid fa-check-to-slot"></i> Approval
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}" href="{{ route('admin.kategori.index') }}">
                                <i class="fa-solid fa-tags"></i> Kategori
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-users"></i> Manajemen User
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.logs.index') ? 'active' : '' }}" href="{{ route('admin.logs.index') }}">
                                <i class="fa-solid fa-clipboard-list"></i> Log Aktivitas
                            </a>
                        </li>
                    @endif

                    {{-- MENU VERIFIKATOR --}}
                     @if(auth()->user()->role === $UserRole::VERIFIKATOR)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.verifikator') ? 'active' : '' }}" href="{{ route('dashboard.verifikator') }}">
                                <i class="fa-solid fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            {{-- UPDATE: Link ke Verifikasi --}}
                            <a class="nav-link {{ request()->routeIs('verifikator.verifikasi.*') ? 'active' : '' }}" href="{{ route('verifikator.verifikasi.index') }}">
                                <i class="fa-solid fa-check"></i> Verifikasi
                            </a>
                        </li>
                    @endif

                    {{-- MENU USER --}}
                     @if(auth()->user()->role === $UserRole::USER)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.user') ? 'active' : '' }}" href="{{ route('dashboard.user') }}">
                                <i class="fa-solid fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.pengajuan.create') ? 'active' : '' }}" href="{{ route('user.pengajuan.create') }}">
                                <i class="fa-solid fa-file-arrow-up"></i> Buat Pengajuan
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.pengajuan.index') || request()->routeIs('user.pengajuan.show') || request()->routeIs('user.pengajuan.edit') ? 'active' : '' }}" href="{{ route('user.pengajuan.index') }}">
                                <i class="fa-solid fa-history"></i> Riwayat Pengajuan
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="flex-fill">
            <!-- Topbar -->
            <nav class="navbar navbar-expand-lg topbar">
                <div class="container-fluid">
                    <!-- Tombol (jika perlu) -->
                    <button class="btn btn-light d-lg-none">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <!-- Spacer -->
                    <div class="ms-auto"></div>

                    <!-- Dark Mode Toggle -->
                    <div class="nav-item me-3">
                        <button class="btn btn-outline-secondary" id="theme-toggle">
                            <i class="fa-solid fa-moon" id="theme-icon-moon"></i>
                            <i class="fa-solid fa-sun d-none" id="theme-icon-sun"></i>
                        </button>
                    </div>

                    <!-- User Dropdown -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-circle me-1"></i>
                            {{ auth()->user()->name ?? 'User' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="main-content">
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Dark Mode Toggle Script
        (function() {
            const themeToggle = document.getElementById('theme-toggle');
            const sunIcon = document.getElementById('theme-icon-sun');
            const moonIcon = document.getElementById('theme-icon-moon');
            const htmlElement = document.documentElement;

            // Mendapatkan tema dari localStorage
            const getStoredTheme = () => localStorage.getItem('theme');
            // Menyimpan tema ke localStorage
            const setStoredTheme = (theme) => localStorage.setItem('theme', theme);

            // Terapkan tema saat halaman dimuat
            const currentTheme = getStoredTheme();
            if (currentTheme) {
                htmlElement.setAttribute('data-bs-theme', currentTheme);
                if (currentTheme === 'dark') {
                    sunIcon.classList.remove('d-none');
                    moonIcon.classList.add('d-none');
                }
            }

            themeToggle.addEventListener('click', () => {
                const theme = htmlElement.getAttribute('data-bs-theme');
                if (theme === 'dark') {
                    htmlElement.setAttribute('data-bs-theme', 'light');
                    setStoredTheme('light');
                    sunIcon.classList.add('d-none');
                    moonIcon.classList.remove('d-none');
                } else {
                    htmlElement.setAttribute('data-bs-theme', 'dark');
                    setStoredTheme('dark');
                    sunIcon.classList.remove('d-none');
                    moonIcon.classList.add('d-none');
                }
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>