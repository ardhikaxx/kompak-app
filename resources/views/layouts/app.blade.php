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
    
    <!-- KOMPAK Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/kompak.css') }}">
    
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

    {{-- Script Global Chart.js dan SweetAlert helper --}}
    <script>
        if (typeof Chart !== 'undefined') {
            Chart.defaults.color = '#94a3b8';
            Chart.defaults.borderColor = 'rgba(255,255,255,0.06)';
            Chart.defaults.font.family = 'Plus Jakarta Sans';
        }

        // Helper fungsi konfirmasi hapus
        function konfirmasiHapus(formId) {
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
                background: 'rgba(15, 23, 42, 0.95)',
                color: '#e2e8f0',
                backdrop: 'rgba(0,0,0,0.6)',
                customClass: { popup: 'swal-glassmorphism' }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        // Helper logout
        function konfirmasiLogout() {
            Swal.fire({
                title: 'Keluar dari KOMPAK?',
                text: 'Sesi Anda akan diakhiri.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-sign-out-alt me-1"></i> Ya, Keluar',
                cancelButtonText: 'Batal',
                background: 'rgba(15, 23, 42, 0.95)',
                color: '#e2e8f0',
                customClass: { popup: 'swal-glassmorphism' }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-logout').submit();
                }
            });
        }

        // Toggle Sidebar Mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
        }
    </script>

    {{-- Flash Messages → SweetAlert --}}
    @include('layouts.flash-alert')

    @stack('scripts')
</body>
</html>