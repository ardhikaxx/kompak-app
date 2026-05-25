<header class="topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn-glass-icon d-lg-none" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="topbar-title d-none d-md-block">
            <h5>@yield('title', 'Dashboard')</h5>
            <small>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</small>
        </div>
    </div>

    <div class="topbar-right">
        <button class="topbar-btn">
            <i class="fas fa-bell"></i>
            <span class="topbar-notif-dot"></span>
        </button>
        <div class="topbar-user">
            @if(auth()->check())
                <img src="{{ auth()->user()->foto ?? asset('img/avatar.png') }}" alt="User Avatar">
            @else
                <img src="https://ui-avatars.com/api/?name=Guest" alt="User Avatar">
            @endif
        </div>
    </div>
</header>