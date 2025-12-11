<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0d1117">
    <title>@yield('title', 'Pungut-In Admin')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <!-- Chart CSS -->
    <link rel="stylesheet" href="{{ asset('css/chart.css') }}">

</head>

<body>

<div class="admin-wrapper">

    {{-- ============ SIDEBAR ============ --}}
    <aside class="sidebar" id="sidebar">

        {{-- Brand --}}
        <div class="sidebar-brand">
            <i class="bi bi-recycle brand-icon"></i>
            <span class="brand-text">Pungut-in</span>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">

            {{-- Dashboard --}}
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>

            {{-- Master Data --}}
            <div class="nav-section">
                <div class="nav-section-title">Master Data</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="bi bi-people"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.petugas.*') ? 'active' : '' }}" href="{{ route('admin.petugas.index') }}">
                            <i class="bi bi-person-badge"></i>
                            <span>Petugas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.teams.*') ? 'active' : '' }}" href="{{ route('admin.teams.index') }}">
                            <i class="bi bi-people-fill"></i>
                            <span>Teams</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.trucks.*') ? 'active' : '' }}" href="{{ route('admin.trucks.index') }}">
                            <i class="bi bi-truck"></i>
                            <span>Trucks</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}" href="{{ route('admin.kategori.index') }}">
                            <i class="bi bi-tags"></i>
                            <span>Kategori Sampah</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Operasional --}}
            <div class="nav-section">
                <div class="nav-section-title">Operasional</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}" href="{{ route('admin.transaksi.index') }}">
                            <i class="bi bi-box-seam"></i>
                            <span>Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.batches.*') ? 'active' : '' }}" href="{{ route('admin.batches.index') }}">
                            <i class="bi bi-collection"></i>
                            <span>Batch</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- System --}}
            <div class="nav-section">
                <div class="nav-section-title">System</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-gear"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-clock-history"></i>
                            <span>Activity Logs</span>
                        </a>
                    </li>
                </ul>
            </div>

        </nav>

        {{-- Logout --}}
        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

    </aside>

    {{-- ============ MAIN CONTENT ============ --}}
    <main class="main-content">

        {{-- Top Header Bar --}}
        <header class="top-header">
            <div class="header-left">
                <button class="btn-menu-toggle d-lg-none" type="button" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="header-right">
                <div class="user-dropdown">
                    <span class="user-name">{{ auth('admin')->user()->nama ?? 'Admin' }}</span>
                    <div class="user-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <div class="page-content">
            @yield('content')
        </div>

    </main>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<!-- Custom Chart JS -->
<script src="{{ asset('js/chart.js') }}"></script>

<script>
// Sidebar toggle for mobile
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.querySelector('.btn-menu-toggle');
    if (window.innerWidth < 992 && sidebar.classList.contains('show') &&
        !sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
        sidebar.classList.remove('show');
    }
});

// Calendar interactivity
document.addEventListener('DOMContentLoaded', function() {
    const cells = document.querySelectorAll('.cal-cell');
    const today = new Date().getDate();

    cells.forEach(cell => {
        // Mark today
        if (cell.textContent.trim() == today) {
            cell.classList.add('is-today');
        }

        // Click to select
        cell.addEventListener('click', function() {
            if (this.textContent.trim()) {
                cells.forEach(c => c.classList.remove('is-selected'));
                this.classList.add('is-selected');
            }
        });
    });
});
</script>

@stack('scripts')
</body>
</html>
