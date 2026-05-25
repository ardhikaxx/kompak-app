@extends('layouts.app')
@section('title', 'Laporan Stok')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-chart-pie me-2 text-accent"></i> Laporan Stok Barang
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Stok</li>
            </ol>
        </nav>
    </div>
</div>

<div class="filter-bar glass-card mb-4">
    <form action="{{ route('laporan.stok') }}" method="GET" class="row g-2 align-items-center p-3">
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
            <div class="btn-group mt-4 ms-2">
                <button type="button" class="btn-glass-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-download me-1"></i> Ekspor Laporan
                </button>
                <ul class="dropdown-menu dropdown-menu-dark glass-card border-0 shadow" style="background: rgba(10, 22, 40, 0.95); backdrop-filter: blur(20px);">
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}"><i class="fas fa-file-pdf me-2 text-danger"></i> Unduh PDF</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"><i class="fas fa-file-excel me-2 text-success"></i> Unduh Excel</a></li>
                </ul>
            </div>
            <button type="button" class="btn-glass-secondary mt-4 ms-2" onclick="window.print()">
                <i class="fas fa-print me-1"></i> Cetak Cepat
            </button>
        </div>
    </form>
</div>

<div class="row g-4 mb-4" id="printableArea">
    <div class="col-md-6">
        <div class="glass-card stat-card">
            <div class="stat-icon green">
                <i class="fas fa-box-open"></i>
            </div>
            <div>
                <div class="stat-label">Total Stok Masuk</div>
                <div class="stat-value fs-3 text-white">{{ $totalMasuk }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="glass-card stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-dolly-flatbed"></i>
            </div>
            <div>
                <div class="stat-label">Total Stok Keluar</div>
                <div class="stat-value fs-3 text-white">{{ $totalKeluar }}</div>
            </div>
        </div>
    </div>

    @if($stokRendah->count() > 0)
    <div class="col-12">
        <div class="glass-card p-4 border border-warning" style="background: rgba(245,158,11,0.05);">
            <h5 class="text-warning mb-3"><i class="fas fa-exclamation-triangle me-2"></i> Peringatan Stok Rendah / Habis</h5>
            <div class="table-responsive">
                <table class="table-glass">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kode</th>
                            <th class="text-center">Stok Sisa</th>
                            <th class="text-center">Batas Minimum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stokRendah as $produk)
                        <tr>
                            <td class="text-white fw-bold">{{ $produk->nama_produk }}</td>
                            <td class="font-mono text-muted">{{ $produk->kode_produk }}</td>
                            <td class="text-center fw-bold text-danger">{{ $produk->stok }} {{ $produk->satuan }}</td>
                            <td class="text-center text-muted">{{ $produk->stok_minimum }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <div class="col-12">
        <div class="glass-card p-4">
            <h5 class="text-white mb-3">Detail Mutasi Stok (Masuk/Keluar)</h5>
            <div class="table-responsive">
                <table class="table-glass">
                    <thead>
                        <tr>
                            <th>Tgl & Waktu</th>
                            <th>Produk</th>
                            <th>Jenis</th>
                            <th class="text-center">Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stokLogs as $log)
                        <tr>
                            <td class="small">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="text-white fw-bold">{{ $log->produk->nama_produk ?? '-' }}</div>
                                <div class="small text-muted">{{ $log->produk->kode_produk ?? '-' }}</div>
                            </td>
                            <td>
                                @if($log->jenis == 'masuk')
                                    <span class="badge-glass badge-success">Masuk</span>
                                @else
                                    <span class="badge-glass badge-warning">Keluar</span>
                                @endif
                            </td>
                            <td class="text-center fw-bold">{{ $log->jumlah }}</td>
                            <td class="small text-muted">{{ $log->keterangan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-white">Belum ada riwayat mutasi stok.</td>
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
    .text-white, .text-muted, .text-accent, .text-success, .text-warning, .text-danger { color: #000 !important; }
}
</style>
@endsection