@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-home me-2 text-accent"></i> Dashboard Utama
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Stat 1 -->
    <div class="col-md-3">
        <div class="glass-card stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-box"></i>
            </div>
            <div>
                <div class="stat-value">0</div>
                <div class="stat-label">Total Produk</div>
            </div>
        </div>
    </div>
    <!-- Stat 2 -->
    <div class="col-md-3">
        <div class="glass-card stat-card">
            <div class="stat-icon green">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div>
                <div class="stat-value">0</div>
                <div class="stat-label">Penjualan Hari Ini</div>
            </div>
        </div>
    </div>
    <!-- Stat 3 -->
    <div class="col-md-3">
        <div class="glass-card stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <div class="stat-value">0</div>
                <div class="stat-label">Stok Rendah</div>
            </div>
        </div>
    </div>
    <!-- Stat 4 -->
    <div class="col-md-3">
        <div class="glass-card stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="stat-value">0</div>
                <div class="stat-label">Total Pelanggan</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="glass-card p-4 h-100">
            <h5 class="mb-4 text-white">Grafik Penjualan</h5>
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="glass-card p-4 h-100">
            <h5 class="mb-4 text-white">Transaksi Terakhir</h5>
            <div class="text-muted text-center py-5">
                <i class="fas fa-receipt fa-3x mb-3 opacity-50"></i>
                <p>Belum ada transaksi</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Pendapatan',
                    data: [0, 0, 0, 0, 0, 0, 0],
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
    });
</script>
@endsection