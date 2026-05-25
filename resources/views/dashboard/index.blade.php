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
    <div class="col-md-3">
        <div class="glass-card stat-card">
            <div class="stat-icon blue"><i class="fas fa-box"></i></div>
            <div>
                <div class="stat-value">{{ $totalProduk }}</div>
                <div class="stat-label">Total Produk</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card stat-card">
            <div class="stat-icon green"><i class="fas fa-shopping-cart"></i></div>
            <div>
                <div class="stat-value fs-5">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</div>
                <div class="stat-label">Penjualan Hari Ini</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card stat-card">
            <div class="stat-icon orange"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <div class="stat-value">{{ $stokRendah }}</div>
                <div class="stat-label">Stok Rendah</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card stat-card">
            <div class="stat-icon purple"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-value">{{ $totalPelanggan }}</div>
                <div class="stat-label">Total Pelanggan</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="glass-card p-4 h-100">
            <h5 class="mb-4 text-white"><i class="fas fa-chart-line me-2 text-accent"></i> Tren Penjualan 7 Hari</h5>
            <canvas id="salesChart" height="110"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="glass-card p-4 h-100">
            <h5 class="mb-4 text-white"><i class="fas fa-chart-pie me-2 text-accent"></i> Distribusi Kategori</h5>
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="glass-card p-4 h-100">
            <h5 class="mb-4 text-white"><i class="fas fa-exchange-alt me-2 text-accent"></i> Arus Kas (6 Bulan Terakhir)</h5>
            <canvas id="cashFlowChart" height="110"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="glass-card p-4 h-100">
            <h5 class="mb-4 text-white"><i class="fas fa-receipt me-2 text-accent"></i> Transaksi Terakhir</h5>
            @if($recentTransaksis->isEmpty())
                <div class="text-white text-center py-5">
                    <i class="fas fa-receipt fa-3x mb-3"></i>
                    <p>Belum ada transaksi</p>
                </div>
            @else
                <div class="list-group list-group-flush bg-transparent">
                    @foreach($recentTransaksis as $trx)
                    <div class="list-group-item bg-transparent px-0 border-secondary border-bottom">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 text-white fw-bold small">{{ $trx->pelanggan->nama_pelanggan ?? 'Umum' }}</h6>
                            <small class="text-accent fw-bold">Rp {{ number_format($trx->total, 0, ',', '.') }}</small>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <small class="text-white opacity-50 font-mono" style="font-size:0.65rem;">{{ $trx->kode_transaksi }}</small>
                            <small class="text-white opacity-50" style="font-size:0.65rem;">{{ $trx->tanggal->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Chart
        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#3b82f6'
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        // Category Chart
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($catLabels) !!},
                datasets: [{
                    data: {!! json_encode($catValues) !!},
                    backgroundColor: ['#3b82f6', '#6366f1', '#8b5cf6', '#ec4899', '#ef4444', '#f59e0b', '#22c55e', '#06b6d4'],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, padding: 15 } } }, cutout: '70%' }
        });

        // Cash Flow Chart
        new Chart(document.getElementById('cashFlowChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($cashFlowLabels) !!},
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: {!! json_encode($incomeData) !!},
                        backgroundColor: 'rgba(34, 197, 94, 0.5)',
                        borderColor: '#22c55e',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($expenseData) !!},
                        backgroundColor: 'rgba(239, 68, 68, 0.5)',
                        borderColor: '#ef4444',
                        borderWidth: 1
                    }
                ]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });
    });
</script>
@endpush