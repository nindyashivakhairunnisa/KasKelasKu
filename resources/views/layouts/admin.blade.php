<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - KasKelasKu</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @yield('head')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="logo-text">
                    <h2>KasKelasKu</h2>
                    <p>Pengelolaan Kas</p>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <span class="nav-section-title">UTAMA</span>
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="nav-section">
                    <span class="nav-section-title">KELAS</span>
                    <a href="{{ route('admin.siswa.index') }}"
                       class="nav-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Daftar Siswa</span>
                    </a>
                    <a href="{{ route('admin.transaksi.index') }}"
                       class="nav-item {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Transaksi Kas</span>
                    </a>
                    <a href="{{ route('admin.pembayaran.index') }}"
                       class="nav-item {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i>
                        <span>Pembayaran</span>
                    </a>
                </div>

                <div class="nav-section">
                    <span class="nav-section-title">LAINNYA</span>
                    <a href="{{ route('admin.laporan.index') }}"
                       class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan</span>
                    </a>
                    <a href="{{ route('admin.pengaturan.index') }}"
                       class="nav-item {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </div>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>