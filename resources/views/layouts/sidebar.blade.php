<aside class="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <div class="logo-icon">
            <i class="fas fa-store"></i>
        </div>
        <div class="logo-text">
            <span class="logo-name">KOMPAK</span>
            <span class="logo-tagline">UMKM System</span>
        </div>
    </div>

    <!-- Nav -->
    <nav class="sidebar-nav">
        <div class="nav-group">
            <span class="nav-group-label">Utama</span>
            <a href="/dashboard" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-home"></i></span>
                <span class="nav-label">Dashboard</span>
            </a>
        </div>

        <div class="nav-group">
            <span class="nav-group-label">Katalog</span>
            <a href="/produk" class="nav-item {{ request()->is('produk*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-box"></i></span>
                <span class="nav-label">Produk</span>
            </a>
            <a href="/kategori" class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-tags"></i></span>
                <span class="nav-label">Kategori</span>
            </a>
            <a href="/stok" class="nav-item {{ request()->is('stok*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-warehouse"></i></span>
                <span class="nav-label">Stok</span>
                {{-- <span class="nav-badge warning">2</span> --}}
            </a>
        </div>

        <div class="nav-group">
            <span class="nav-group-label">Operasional</span>
            <a href="/transaksi" class="nav-item {{ request()->is('transaksi*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-cash-register"></i></span>
                <span class="nav-label">Transaksi</span>
            </a>
            <a href="/pelanggan" class="nav-item {{ request()->is('pelanggan*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-users"></i></span>
                <span class="nav-label">Pelanggan</span>
            </a>
            <a href="/supplier" class="nav-item {{ request()->is('supplier*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-truck"></i></span>
                <span class="nav-label">Supplier</span>
            </a>
            <a href="/keuangan" class="nav-item {{ request()->is('keuangan*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-wallet"></i></span>
                <span class="nav-label">Keuangan</span>
            </a>
        </div>

        <div class="nav-group">
            <span class="nav-group-label">Analitik</span>
            <a href="/laporan/penjualan" class="nav-item {{ request()->is('laporan/penjualan') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
                <span class="nav-label">Lap. Penjualan</span>
            </a>
            <a href="/laporan/stok" class="nav-item {{ request()->is('laporan/stok') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-chart-pie"></i></span>
                <span class="nav-label">Lap. Stok</span>
            </a>
            <a href="/laporan/keuangan" class="nav-item {{ request()->is('laporan/keuangan') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                <span class="nav-label">Lap. Keuangan</span>
            </a>
        </div>

        <div class="nav-group">
            <span class="nav-group-label">Keputusan</span>
            <a href="/spk" class="nav-item spk-item {{ request()->is('spk*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-brain"></i></span>
                <span class="nav-label">SPK PROMETHEE</span>
                <span class="nav-badge blue">AI</span>
            </a>
        </div>

        @if(auth()->check() && auth()->user()->role === 'admin')
        <div class="nav-group">
            <span class="nav-group-label">Sistem</span>
            <a href="/pengguna" class="nav-item {{ request()->is('pengguna*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-user-cog"></i></span>
                <span class="nav-label">Pengguna</span>
            </a>
        </div>
        @endif
    </nav>

    <!-- User Card -->
    <div class="sidebar-user">
        @if(auth()->check())
            <img src="{{ auth()->user()->foto ?? asset('img/avatar.png') }}" alt="avatar" class="sidebar-avatar">
            <div class="sidebar-user-info">
                <p class="sidebar-user-name">{{ auth()->user()->nama }}</p>
                <p class="sidebar-user-role">{{ ucfirst(auth()->user()->role) }}</p>
            </div>
            <button onclick="konfirmasiLogout()" class="btn-glass-icon ms-auto">
                <i class="fas fa-sign-out-alt"></i>
            </button>
            <form id="form-logout" action="/logout" method="POST" class="d-none">
                @csrf
            </form>
        @else
            <img src="https://ui-avatars.com/api/?name=Guest" alt="avatar" class="sidebar-avatar">
            <div class="sidebar-user-info">
                <p class="sidebar-user-name">Guest</p>
                <p class="sidebar-user-role">Silahkan Login</p>
            </div>
        @endif
    </div>
</aside>