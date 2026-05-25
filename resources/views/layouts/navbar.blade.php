<header class="topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn-glass-icon d-lg-none" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="topbar-title d-none d-md-block">
            <h5>@yield('title', 'Dashboard')</h5>
            <small class="text-white opacity-75">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</small>
        </div>
    </div>

    <div class="topbar-right">
        <!-- Notifikasi Stok -->
        <div class="dropdown">
            <button class="topbar-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell"></i>
                @if($stokRendahCount > 0)
                    <span class="topbar-notif-dot"></span>
                @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end glass-card p-0 mt-2 border-0 shadow-lg" style="width: 320px; background: rgba(10, 22, 40, 0.95); backdrop-filter: blur(24px);">
                <div class="px-3 py-3 border-bottom border-secondary d-flex justify-content-between align-items-center">
                    <h6 class="text-white mb-0 small fw-bold">Notifikasi Stok</h6>
                    <span class="badge bg-danger rounded-pill" style="font-size: 0.65rem;">{{ $stokRendahCount }} Penting</span>
                </div>
                <div style="max-height: 350px; overflow-y: auto;">
                    @forelse($stokRendahItems as $item)
                    <a href="{{ route('stok.index') }}" class="dropdown-item px-3 py-3 border-bottom border-secondary d-flex align-items-center gap-3" style="white-space: normal;">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <div class="text-white small fw-bold mb-1">{{ $item->nama_produk }}</div>
                            <div class="text-white opacity-50 small" style="font-size: 0.7rem;">
                                Sisa stok: <span class="text-danger fw-bold">{{ $item->stok }}</span> {{ $item->satuan }} (Min: {{ $item->stok_minimum }})
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="px-3 py-5 text-center text-white opacity-50">
                        <i class="fas fa-check-circle fa-2x mb-3 text-success"></i>
                        <p class="small mb-0">Semua stok aman</p>
                    </div>
                    @endforelse
                </div>
                @if($stokRendahCount > 0)
                <a href="{{ route('stok.index') }}" class="dropdown-item text-center py-2 small text-accent border-top border-secondary">
                    Lihat Semua Inventori
                </a>
                @endif
            </div>
        </div>

        <div class="topbar-user">
            @if(auth()->check())
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff" alt="User Avatar">
            @else
                <img src="https://ui-avatars.com/api/?name=Guest&background=64748b&color=fff" alt="User Avatar">
            @endif
        </div>
    </div>
</header>

<style>
    .dropdown-item { transition: all 0.2s; }
    .dropdown-item:hover { background: rgba(255, 255, 255, 0.05) !important; }
    .dropdown-item:active { background: var(--blue-primary) !important; }
</style>