# 🎨 DESIGN-KOMPAK.md
## Panduan Desain UI/UX Sistem KOMPAK
### Glassmorphism Dark Theme — Laravel 12 + Bootstrap CDN

---

## 1. FILOSOFI DESAIN

KOMPAK menggunakan gaya **Glassmorphism Dark** — antarmuka berlapis kaca transparan di atas latar belakang gelap bergradasi. Pendekatan ini memberikan kesan **modern, premium, dan profesional** yang sesuai untuk sistem manajemen bisnis UMKM yang serius namun tetap mudah digunakan.

> **Prinsip utama**: *Kedalaman melalui transparansi, kejelasan melalui kontras, kepercayaan melalui konsistensi.*

---

## 2. PALET WARNA

### 2.1 CSS Custom Properties (Variabel Global)

Letakkan di `<style>` dalam `app.blade.php` atau file `kompak.css`:

```css
:root {
    /* ── Background ───────────────────────────── */
    --bg-primary:        #050d1a;        /* Biru malam sangat gelap */
    --bg-secondary:      #0a1628;        /* Layer kedua */
    --bg-gradient:       linear-gradient(135deg, #050d1a 0%, #0a1628 40%, #0d1f3c 100%);

    /* ── Glass Effect ─────────────────────────── */
    --glass-bg:          rgba(255, 255, 255, 0.05);
    --glass-bg-hover:    rgba(255, 255, 255, 0.09);
    --glass-bg-active:   rgba(59, 130, 246, 0.15);
    --glass-border:      rgba(255, 255, 255, 0.10);
    --glass-border-blue: rgba(59, 130, 246, 0.30);
    --glass-shadow:      0 8px 32px rgba(0, 0, 0, 0.40);
    --glass-shadow-blue: 0 8px 32px rgba(59, 130, 246, 0.20);
    --glass-blur:        blur(12px);
    --glass-blur-heavy:  blur(20px);

    /* ── Accent Colors ────────────────────────── */
    --blue-primary:      #3b82f6;        /* Biru utama */
    --blue-light:        #60a5fa;        /* Biru muda */
    --blue-dark:         #1d4ed8;        /* Biru gelap */
    --blue-glow:         rgba(59, 130, 246, 0.4);

    --indigo:            #6366f1;
    --purple:            #8b5cf6;

    /* ── Semantic Colors ──────────────────────── */
    --success:           #22c55e;
    --success-bg:        rgba(34, 197, 94, 0.15);
    --danger:            #ef4444;
    --danger-bg:         rgba(239, 68, 68, 0.15);
    --warning:           #f59e0b;
    --warning-bg:        rgba(245, 158, 11, 0.15);
    --info:              #06b6d4;
    --info-bg:           rgba(6, 182, 212, 0.15);

    /* ── Text Colors ──────────────────────────── */
    --text-primary:      #f1f5f9;        /* Teks utama */
    --text-secondary:    #94a3b8;        /* Teks sekunder */
    --text-muted:        #64748b;        /* Teks redup */
    --text-accent:       #60a5fa;        /* Teks aksen biru */

    /* ── Border ───────────────────────────────── */
    --border-subtle:     rgba(255, 255, 255, 0.06);
    --border-default:    rgba(255, 255, 255, 0.10);
    --border-strong:     rgba(255, 255, 255, 0.18);

    /* ── Spacing ──────────────────────────────── */
    --radius-sm:         8px;
    --radius-md:         12px;
    --radius-lg:         16px;
    --radius-xl:         20px;
    --radius-2xl:        24px;

    /* ── Transition ───────────────────────────── */
    --transition-fast:   all 0.15s ease;
    --transition-base:   all 0.25s ease;
    --transition-slow:   all 0.4s ease;
}
```

---

## 3. TIPOGRAFI

```css
/* Import di <head> layout utama */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    line-height: 1.6;
    color: var(--text-primary);
    background: var(--bg-gradient);
    min-height: 100vh;
}

/* Kode / angka numerik */
.font-mono { font-family: 'JetBrains Mono', monospace; }

/* Hierarki tipografi */
h1 { font-size: 1.75rem; font-weight: 700; }
h2 { font-size: 1.375rem; font-weight: 600; }
h3 { font-size: 1.125rem; font-weight: 600; }
h4 { font-size: 1rem;     font-weight: 600; }
h5 { font-size: 0.9rem;   font-weight: 500; }

.text-gradient {
    background: linear-gradient(135deg, #60a5fa, #818cf8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
```

---

## 4. KOMPONEN GLASS (KOMPONEN INTI)

### 4.1 Glass Card
```css
.glass-card {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-xl);
    box-shadow: var(--glass-shadow);
    transition: var(--transition-base);
}

.glass-card:hover {
    background: var(--glass-bg-hover);
    border-color: var(--glass-border-blue);
    box-shadow: var(--glass-shadow-blue);
    transform: translateY(-2px);
}

/* Varian dengan border biru */
.glass-card-blue {
    background: rgba(59, 130, 246, 0.08);
    border-color: rgba(59, 130, 246, 0.25);
}

/* Varian header kartu */
.glass-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border-subtle);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
```

### 4.2 Glass Button
```css
/* Tombol Utama */
.btn-glass-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    border: 1px solid rgba(59, 130, 246, 0.5);
    border-radius: var(--radius-md);
    padding: 0.5rem 1.25rem;
    font-weight: 600;
    font-size: 0.875rem;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.30);
    transition: var(--transition-base);
    cursor: pointer;
}
.btn-glass-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.50);
    transform: translateY(-1px);
    color: #fff;
}

/* Tombol Secondary (Ghost) */
.btn-glass-secondary {
    background: var(--glass-bg);
    color: var(--text-primary);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-md);
    padding: 0.5rem 1.25rem;
    font-weight: 500;
    backdrop-filter: var(--glass-blur);
    transition: var(--transition-base);
}
.btn-glass-secondary:hover {
    background: var(--glass-bg-hover);
    border-color: var(--glass-border-blue);
    color: var(--text-accent);
}

/* Tombol Danger */
.btn-glass-danger {
    background: rgba(239, 68, 68, 0.15);
    color: #fca5a5;
    border: 1px solid rgba(239, 68, 68, 0.30);
    border-radius: var(--radius-md);
    padding: 0.5rem 1.25rem;
    font-weight: 500;
    transition: var(--transition-base);
}
.btn-glass-danger:hover {
    background: rgba(239, 68, 68, 0.25);
    color: #fff;
}

/* Tombol Icon Kecil */
.btn-glass-icon {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-sm);
    border: 1px solid var(--glass-border);
    background: var(--glass-bg);
    color: var(--text-secondary);
    transition: var(--transition-fast);
    cursor: pointer;
    text-decoration: none;
}
.btn-glass-icon:hover { color: var(--blue-primary); border-color: var(--glass-border-blue); }
.btn-glass-icon.edit:hover  { color: var(--info); }
.btn-glass-icon.delete:hover { color: var(--danger); }
```

### 4.3 Glass Form Input
```css
.form-glass {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    padding: 0.6rem 1rem;
    font-size: 0.875rem;
    width: 100%;
    transition: var(--transition-base);
    backdrop-filter: blur(4px);
}
.form-glass:focus {
    outline: none;
    border-color: var(--blue-primary);
    background: rgba(59, 130, 246, 0.06);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    color: var(--text-primary);
}
.form-glass::placeholder { color: var(--text-muted); }
.form-glass option       { background: #0a1628; color: var(--text-primary); }

.form-glass-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.375rem;
    display: block;
}
```

### 4.4 Glass Table
```css
.table-glass {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    color: var(--text-primary);
}
.table-glass thead th {
    background: rgba(59, 130, 246, 0.08);
    color: var(--text-accent);
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 0.875rem 1rem;
    border-bottom: 1px solid var(--glass-border-blue);
    white-space: nowrap;
}
.table-glass tbody tr {
    transition: var(--transition-fast);
}
.table-glass tbody td {
    padding: 0.875rem 1rem;
    border-bottom: 1px solid var(--border-subtle);
    font-size: 0.875rem;
    vertical-align: middle;
}
.table-glass tbody tr:hover td {
    background: rgba(255, 255, 255, 0.03);
}
.table-glass tbody tr:last-child td {
    border-bottom: none;
}
```

### 4.5 Badge / Status Label
```css
.badge-glass {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.03em;
    border: 1px solid transparent;
}
.badge-success  { background: var(--success-bg);  color: #86efac; border-color: rgba(34,197,94,0.25); }
.badge-danger   { background: var(--danger-bg);   color: #fca5a5; border-color: rgba(239,68,68,0.25); }
.badge-warning  { background: var(--warning-bg);  color: #fde68a; border-color: rgba(245,158,11,0.25); }
.badge-info     { background: var(--info-bg);     color: #67e8f9; border-color: rgba(6,182,212,0.25); }
.badge-primary  { background: rgba(59,130,246,.15); color: #93c5fd; border-color: rgba(59,130,246,0.25); }
.badge-purple   { background: rgba(139,92,246,.15); color: #c4b5fd; border-color: rgba(139,92,246,0.25); }
```

---

## 5. LAYOUT UTAMA

### 5.1 Struktur HTML Layout (`app.blade.php`)
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOMPAK — @yield('title', 'Dashboard')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ← Semua CSS Variable + Komponen Glass dari section 2 & 4 */
    </style>
    @stack('styles')
</head>
<body>

    <!-- Ambient background blobs -->
    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>
    <div class="bg-blob bg-blob-3"></div>

    <div class="app-wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Topbar -->
            @include('layouts.navbar')

            <!-- Page Content -->
            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Flash Messages → SweetAlert --}}
    @include('layouts.flash-alert')

    @stack('scripts')
</body>
</html>
```

### 5.2 CSS Layout Wrapper
```css
/* Ambient blob decorations */
.bg-blob {
    position: fixed;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.12;
    pointer-events: none;
    z-index: 0;
}
.bg-blob-1 {
    width: 500px; height: 500px;
    background: radial-gradient(circle, #3b82f6, transparent);
    top: -100px; left: -100px;
}
.bg-blob-2 {
    width: 400px; height: 400px;
    background: radial-gradient(circle, #6366f1, transparent);
    top: 50%; right: -100px;
}
.bg-blob-3 {
    width: 350px; height: 350px;
    background: radial-gradient(circle, #0ea5e9, transparent);
    bottom: -100px; left: 40%;
}

/* Layout Wrapper */
.app-wrapper {
    display: flex;
    min-height: 100vh;
    position: relative;
    z-index: 1;
}

/* Sidebar */
.sidebar {
    width: 240px;
    min-height: 100vh;
    background: rgba(5, 13, 26, 0.85);
    backdrop-filter: blur(20px);
    border-right: 1px solid var(--glass-border);
    position: fixed;
    top: 0; left: 0;
    z-index: 100;
    display: flex;
    flex-direction: column;
    transition: var(--transition-base);
}

/* Main */
.main-content {
    margin-left: 240px;
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Topbar */
.topbar {
    height: 64px;
    background: rgba(5, 13, 26, 0.70);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--glass-border);
    position: sticky;
    top: 0;
    z-index: 99;
    padding: 0 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.content-area {
    padding: 1.5rem;
    flex: 1;
}
```

---

## 6. SIDEBAR DESIGN

```html
<!-- layouts/sidebar.blade.php -->
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
            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-home"></i></span>
                <span class="nav-label">Dashboard</span>
            </a>
        </div>

        <div class="nav-group">
            <span class="nav-group-label">Katalog</span>
            <a href="{{ route('produk.index') }}"
               class="nav-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-box"></i></span>
                <span class="nav-label">Produk</span>
            </a>
            <a href="{{ route('kategori.index') }}"
               class="nav-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-tags"></i></span>
                <span class="nav-label">Kategori</span>
            </a>
            <a href="{{ route('stok.index') }}"
               class="nav-item {{ request()->routeIs('stok.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-warehouse"></i></span>
                <span class="nav-label">Stok</span>
                @if($stokRendah > 0)
                    <span class="nav-badge warning">{{ $stokRendah }}</span>
                @endif
            </a>
        </div>

        <div class="nav-group">
            <span class="nav-group-label">Operasional</span>
            <a href="{{ route('transaksi.index') }}" class="nav-item ...">
                <span class="nav-icon"><i class="fas fa-cash-register"></i></span>
                <span class="nav-label">Transaksi</span>
            </a>
            <a href="{{ route('pelanggan.index') }}" class="nav-item ...">
                <span class="nav-icon"><i class="fas fa-users"></i></span>
                <span class="nav-label">Pelanggan</span>
            </a>
            <a href="{{ route('supplier.index') }}" class="nav-item ...">
                <span class="nav-icon"><i class="fas fa-truck"></i></span>
                <span class="nav-label">Supplier</span>
            </a>
            <a href="{{ route('keuangan.index') }}" class="nav-item ...">
                <span class="nav-icon"><i class="fas fa-wallet"></i></span>
                <span class="nav-label">Keuangan</span>
            </a>
        </div>

        <div class="nav-group">
            <span class="nav-group-label">Analitik</span>
            <a href="{{ route('laporan.penjualan') }}" class="nav-item ...">
                <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
                <span class="nav-label">Lap. Penjualan</span>
            </a>
            <a href="{{ route('laporan.stok') }}" class="nav-item ...">
                <span class="nav-icon"><i class="fas fa-chart-pie"></i></span>
                <span class="nav-label">Lap. Stok</span>
            </a>
            <a href="{{ route('laporan.keuangan') }}" class="nav-item ...">
                <span class="nav-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                <span class="nav-label">Lap. Keuangan</span>
            </a>
        </div>

        <div class="nav-group">
            <span class="nav-group-label">Keputusan</span>
            <a href="{{ route('spk.index') }}"
               class="nav-item spk-item {{ request()->routeIs('spk.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-brain"></i></span>
                <span class="nav-label">SPK PROMETHEE</span>
                <span class="nav-badge blue">AI</span>
            </a>
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="nav-group">
            <span class="nav-group-label">Sistem</span>
            <a href="{{ route('pengguna.index') }}" class="nav-item ...">
                <span class="nav-icon"><i class="fas fa-user-cog"></i></span>
                <span class="nav-label">Pengguna</span>
            </a>
        </div>
        @endif
    </nav>

    <!-- User Card di bawah sidebar -->
    <div class="sidebar-user">
        <img src="{{ auth()->user()->foto ?? asset('img/avatar.png') }}"
             alt="avatar" class="sidebar-avatar">
        <div class="sidebar-user-info">
            <p class="sidebar-user-name">{{ auth()->user()->nama }}</p>
            <p class="sidebar-user-role">{{ ucfirst(auth()->user()->role) }}</p>
        </div>
        <button onclick="konfirmasiLogout()" class="btn-glass-icon ms-auto">
            <i class="fas fa-sign-out-alt"></i>
        </button>
    </div>
</aside>
```

```css
/* Sidebar Styles */
.sidebar-logo {
    padding: 1.25rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    border-bottom: 1px solid var(--border-subtle);
}
.logo-icon {
    width: 38px; height: 38px;
    background: linear-gradient(135deg, #3b82f6, #6366f1);
    border-radius: var(--radius-md);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1rem;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
}
.logo-name { display: block; font-weight: 800; font-size: 1rem; color: var(--text-primary); }
.logo-tagline { display: block; font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.08em; }

.sidebar-nav { flex: 1; overflow-y: auto; padding: 1rem 0.75rem; }
.sidebar-nav::-webkit-scrollbar { width: 3px; }
.sidebar-nav::-webkit-scrollbar-thumb { background: var(--glass-border); border-radius: 2px; }

.nav-group { margin-bottom: 1.25rem; }
.nav-group-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 0 0.5rem;
    margin-bottom: 0.375rem;
    display: block;
}

.nav-item {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.55rem 0.75rem;
    border-radius: var(--radius-md);
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: var(--transition-fast);
    margin-bottom: 2px;
    position: relative;
}
.nav-item:hover { background: var(--glass-bg-hover); color: var(--text-primary); }
.nav-item.active {
    background: var(--glass-bg-active);
    color: var(--blue-light);
    border: 1px solid var(--glass-border-blue);
}
.nav-item.active .nav-icon { color: var(--blue-primary); }
.nav-icon { width: 20px; text-align: center; font-size: 0.9rem; }

.nav-badge {
    margin-left: auto;
    padding: 0.1rem 0.45rem;
    border-radius: 999px;
    font-size: 0.65rem;
    font-weight: 700;
}
.nav-badge.warning  { background: var(--warning-bg); color: #fde68a; }
.nav-badge.blue     { background: rgba(59,130,246,.2); color: #93c5fd; }

/* SPK item special */
.nav-item.spk-item { background: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99,102,241,0.20); }
.nav-item.spk-item:hover { background: rgba(99, 102, 241, 0.15); }

.sidebar-user {
    padding: 0.875rem 1rem;
    border-top: 1px solid var(--border-subtle);
    display: flex; align-items: center; gap: 0.625rem;
}
.sidebar-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid var(--glass-border-blue); }
.sidebar-user-name { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); margin: 0; line-height: 1.2; }
.sidebar-user-role { font-size: 0.68rem; color: var(--text-muted); margin: 0; }
```

---

## 7. TOPBAR DESIGN

```css
.topbar-title h5 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0; }
.topbar-title small { font-size: 0.75rem; color: var(--text-muted); }

.topbar-right { display: flex; align-items: center; gap: 0.75rem; }

.topbar-btn {
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
    border-radius: var(--radius-md);
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    color: var(--text-secondary);
    cursor: pointer;
    transition: var(--transition-fast);
    position: relative;
    text-decoration: none;
}
.topbar-btn:hover { background: var(--glass-bg-hover); color: var(--text-primary); }
.topbar-notif-dot {
    position: absolute; top: 6px; right: 6px;
    width: 7px; height: 7px;
    background: var(--danger); border-radius: 50%;
    border: 1.5px solid var(--bg-primary);
}

.topbar-user { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
.topbar-user img { width: 34px; height: 34px; border-radius: 50%; border: 2px solid var(--glass-border-blue); }
```

---

## 8. DASHBOARD STATS CARDS

```css
.stat-card {
    padding: 1.25rem 1.5rem;
    display: flex; align-items: center; gap: 1rem;
}
.stat-icon {
    width: 48px; height: 48px;
    border-radius: var(--radius-lg);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.stat-icon.blue     { background: rgba(59,130,246,.18); color: var(--blue-primary); }
.stat-icon.green    { background: rgba(34,197,94,.18);  color: var(--success); }
.stat-icon.orange   { background: rgba(245,158,11,.18); color: var(--warning); }
.stat-icon.purple   { background: rgba(139,92,246,.18); color: var(--purple); }
.stat-icon.cyan     { background: rgba(6,182,212,.18);  color: var(--info); }

.stat-value { font-size: 1.5rem; font-weight: 800; color: var(--text-primary); line-height: 1; }
.stat-label { font-size: 0.78rem; color: var(--text-secondary); margin-top: 0.25rem; }
.stat-change { font-size: 0.72rem; font-weight: 600; margin-top: 0.375rem; }
.stat-change.up   { color: var(--success); }
.stat-change.down { color: var(--danger); }
```

---

## 9. PAGE HEADER (BREADCRUMB AREA)

```html
<!-- Digunakan di semua halaman -->
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-box me-2 text-accent"></i> Manajemen Produk
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Produk</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('produk.create') }}" class="btn-glass-primary">
        <i class="fas fa-plus me-2"></i> Tambah Produk
    </a>
</div>
```

```css
.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}
.page-title { font-size: 1.2rem; font-weight: 700; color: var(--text-primary); }
.text-accent { color: var(--blue-light); }

.breadcrumb { background: none; padding: 0; }
.breadcrumb-item a { color: var(--text-muted); text-decoration: none; font-size: 0.78rem; }
.breadcrumb-item a:hover { color: var(--text-accent); }
.breadcrumb-item.active, .breadcrumb-item+.breadcrumb-item::before {
    color: var(--text-muted); font-size: 0.78rem;
}
```

---

## 10. SEARCH & FILTER BAR

```html
<div class="filter-bar glass-card mb-4">
    <div class="row g-2 align-items-center p-3">
        <div class="col-md-4">
            <div class="input-glass-icon">
                <i class="fas fa-search"></i>
                <input type="text" class="form-glass" placeholder="Cari produk...">
            </div>
        </div>
        <div class="col-md-2">
            <select class="form-glass">
                <option>Semua Kategori</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-glass">
                <option>Semua Status</option>
            </select>
        </div>
        <div class="col-auto ms-md-auto">
            <button class="btn-glass-secondary">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
        </div>
    </div>
</div>
```

```css
.input-glass-icon { position: relative; }
.input-glass-icon i {
    position: absolute; left: 0.875rem; top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted); font-size: 0.825rem;
    pointer-events: none;
}
.input-glass-icon .form-glass { padding-left: 2.25rem; }
```

---

## 11. MODAL GLASS

```css
.modal-glass .modal-content {
    background: rgba(5, 13, 26, 0.92);
    backdrop-filter: blur(24px);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-2xl);
    color: var(--text-primary);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
}
.modal-glass .modal-header {
    border-bottom: 1px solid var(--border-subtle);
    padding: 1.25rem 1.5rem;
}
.modal-glass .modal-title { font-weight: 700; font-size: 1rem; }
.modal-glass .modal-footer { border-top: 1px solid var(--border-subtle); padding: 1rem 1.5rem; }
.modal-glass .btn-close { filter: invert(1) brightness(0.7); }
```

---

## 12. SPK PROMETHEE — TAMPILAN KHUSUS

```css
/* Card Kriteria SPK */
.spk-kriteria-card {
    padding: 1rem;
    border-radius: var(--radius-lg);
    background: rgba(99, 102, 241, 0.08);
    border: 1px solid rgba(99, 102, 241, 0.20);
    transition: var(--transition-base);
}
.spk-kriteria-card:hover { background: rgba(99, 102, 241, 0.14); }

/* Ranking Table */
.ranking-item {
    display: flex; align-items: center; gap: 1rem;
    padding: 1rem 1.25rem;
    border-radius: var(--radius-lg);
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    margin-bottom: 0.5rem;
    transition: var(--transition-base);
}
.ranking-badge {
    width: 36px; height: 36px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 0.9rem;
    flex-shrink: 0;
}
.rank-1 { background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; box-shadow: 0 4px 12px rgba(245,158,11,.4); }
.rank-2 { background: linear-gradient(135deg, #94a3b8, #64748b); color: #fff; }
.rank-3 { background: linear-gradient(135deg, #cd7c3a, #b45309); color: #fff; }
.rank-other { background: var(--glass-bg-hover); color: var(--text-muted); }

/* Net Flow Bar */
.flow-bar-container { flex: 1; }
.flow-bar-label { font-size: 0.7rem; color: var(--text-muted); margin-bottom: 3px; }
.flow-bar {
    height: 8px;
    border-radius: 4px;
    background: rgba(255,255,255,0.08);
    overflow: hidden;
}
.flow-bar-fill {
    height: 100%;
    border-radius: 4px;
    background: linear-gradient(90deg, #3b82f6, #6366f1);
    transition: width 0.6s ease;
}
```

---

## 13. CHART STYLE (CHART.JS)

```javascript
// Konfigurasi global Chart.js agar match dengan tema glassmorphism
Chart.defaults.color = '#94a3b8';
Chart.defaults.borderColor = 'rgba(255,255,255,0.06)';
Chart.defaults.font.family = 'Plus Jakarta Sans';

// Contoh: Line Chart Penjualan
const grafikPenjualan = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Penjualan',
            data: data,
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.08)',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#3b82f6',
            pointRadius: 4,
            pointHoverRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { labels: { color: '#94a3b8' } },
            tooltip: {
                backgroundColor: 'rgba(5,13,26,0.92)',
                borderColor: 'rgba(255,255,255,0.10)',
                borderWidth: 1,
                titleColor: '#f1f5f9',
                bodyColor: '#94a3b8',
            }
        },
        scales: {
            x: { grid: { color: 'rgba(255,255,255,0.05)' } },
            y: { grid: { color: 'rgba(255,255,255,0.05)' } },
        }
    }
});
```

---

## 14. SWEETALERT2 — GLASS CUSTOM CSS

```css
/* Override SweetAlert2 agar match glassmorphism */
.swal-glassmorphism {
    backdrop-filter: blur(20px) !important;
    border: 1px solid rgba(255,255,255,0.10) !important;
    border-radius: 16px !important;
}
.swal2-popup.swal-glassmorphism { box-shadow: 0 20px 60px rgba(0,0,0,0.6) !important; }
.swal2-title { font-family: 'Plus Jakarta Sans', sans-serif !important; font-weight: 700 !important; }
.swal2-confirm, .swal2-cancel, .swal2-deny {
    border-radius: 10px !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    font-weight: 600 !important;
    font-size: 0.875rem !important;
}
```

---

## 15. LOGIN PAGE

```css
.login-page {
    min-height: 100vh;
    background: var(--bg-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}
.login-card {
    width: 100%;
    max-width: 420px;
    padding: 2.5rem;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(24px);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-2xl);
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
}
.login-logo {
    text-align: center;
    margin-bottom: 2rem;
}
.login-logo .logo-badge {
    width: 56px; height: 56px;
    background: linear-gradient(135deg, #3b82f6, #6366f1);
    border-radius: var(--radius-xl);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 1.4rem; color: #fff;
    box-shadow: 0 8px 20px rgba(59,130,246,.4);
    margin-bottom: 0.875rem;
}
```

---

## 16. RESPONSIF (MOBILE BREAKPOINT)

```css
@media (max-width: 991.98px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    .sidebar.open { transform: translateX(0); }
    .main-content { margin-left: 0; }

    .content-area { padding: 1rem; }
    .stat-value { font-size: 1.25rem; }
    .topbar { padding: 0 1rem; }
}
```

---

## 17. ANIMASI & TRANSISI

```css
/* Fade-in saat halaman dimuat */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
.glass-card { animation: fadeInUp 0.35s ease both; }

/* Stagger untuk stat cards */
.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.10s; }
.stat-card:nth-child(3) { animation-delay: 0.15s; }
.stat-card:nth-child(4) { animation-delay: 0.20s; }

/* Shimmer loading skeleton */
@keyframes shimmer {
    0%   { background-position: -500px 0; }
    100% { background-position: 500px 0; }
}
.skeleton {
    background: linear-gradient(90deg,
        rgba(255,255,255,0.04) 25%,
        rgba(255,255,255,0.08) 50%,
        rgba(255,255,255,0.04) 75%);
    background-size: 1000px 100%;
    animation: shimmer 1.5s infinite;
    border-radius: var(--radius-md);
}
```

---

## 18. RINGKASAN KOMPONEN & PENGGUNAAN

| Komponen | Class Utama | Digunakan Pada |
|---|---|---|
| Kartu konten | `.glass-card` | Semua halaman |
| Tombol utama | `.btn-glass-primary` | Tambah, Simpan, Proses |
| Tombol ghost | `.btn-glass-secondary` | Filter, Batal, Export |
| Tombol hapus | `.btn-glass-danger` | Delete |
| Tombol ikon | `.btn-glass-icon` | Edit, View, Delete di tabel |
| Input form | `.form-glass` | Semua form |
| Tabel data | `.table-glass` | List data semua modul |
| Badge status | `.badge-glass .badge-*` | Status aktif/stok/dsb |
| Stat card | `.stat-card` | Dashboard |
| Modal | `.modal-glass` | Form tambah/edit popup |
| Breadcrumb | `.page-header` | Semua halaman |
| SPK Ranking | `.ranking-item .rank-*` | Halaman SPK |
| Alert SweetAlert | `swal-glassmorphism` | Semua notifikasi |

---

*Design KOMPAK v1.0 — Glassmorphism Dark Theme*
*Laravel 12 | Bootstrap 5 CDN | Font Awesome 6 CDN | SweetAlert2 CDN | Chart.js CDN*
