@extends('layouts.app')
@section('title', 'Laporan Penjualan')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-chart-bar me-2 text-accent"></i> Laporan Penjualan
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Penjualan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="filter-bar glass-card mb-4">
    <form action="{{ route('laporan.penjualan') }}" method="GET" class="row g-2 align-items-center p-3">
        <div class="col-md-4">
            <label class="form-glass-label">Tanggal Mulai</label>
            <input type="date" name="start_date" class="form-glass" value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
        </div>
        <div class="col-md-4">
            <label class="form-glass-label">Tanggal Akhir</label>
            <input type="date" name="end_date" class="form-glass" value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
        </div>
        <div class="col-auto mt-auto">
            <button type="submit" class="btn-glass-primary mt-4">
                <i class="fas fa-filter me-1"></i> Terapkan Filter
            </button>
            <button type="button" class="btn-glass-secondary mt-4 ms-2" onclick="window.print()">
                <i class="fas fa-print me-1"></i> Cetak PDF
            </button>
        </div>
    </form>
</div>

<div class="row g-4 mb-4" id="printableArea">
    <div class="col-md-6">
        <div class="glass-card stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div>
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value fs-3 text-white">{{ $totalTransaksi }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="glass-card stat-card">
            <div class="stat-icon green">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value fs-3 text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="glass-card p-4">
            <h5 class="text-white mb-3">Top 5 Produk Terlaris</h5>
            <div class="table-responsive">
                <table class="table-glass">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Produk</th>
                            <th class="text-center">Total Terjual</th>
                            <th class="text-end">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produkLaris as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-white fw-bold">{{ $produk->nama_produk }}</td>
                            <td class="text-center">{{ $produk->total_terjual }}</td>
                            <td class="text-end text-accent">Rp {{ number_format($produk->total_pendapatan, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-white py-3">Belum ada data penjualan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="glass-card p-4">
            <h5 class="text-white mb-3">Detail Transaksi Penjualan</h5>
            <div class="table-responsive">
                <table class="table-glass">
                    <thead>
                        <tr>
                            <th>Tgl & Waktu</th>
                            <th>Kode Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Metode Bayar</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $trx)
                        <tr>
                            <td class="small">{{ $trx->tanggal->format('d/m/Y H:i') }}</td>
                            <td class="font-mono text-accent">{{ $trx->kode_transaksi }}</td>
                            <td>{{ $trx->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
                            <td>{{ $trx->metode_bayar }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">Belum ada data transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    .sidebar, .topbar, .page-header, .filter-bar { display: none; }
    .main-content { margin-left: 0 !important; }
    #printableArea, #printableArea * { visibility: visible; }
    #printableArea {
        position: absolute; left: 0; top: 0; width: 100%;
    }
    .glass-card { background: transparent !important; border: 1px solid #ddd; box-shadow: none; color: #000; }
    .text-white, .text-muted, .text-accent, .text-success { color: #000 !important; }
}
</style>
@endsection