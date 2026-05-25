@extends('layouts.app')
@section('title', 'Laporan Keuangan')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-file-invoice-dollar me-2 text-accent"></i> Laporan Arus Kas Keuangan
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Keuangan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="filter-bar glass-card mb-4">
    <form action="{{ route('laporan.keuangan') }}" method="GET" class="row g-2 align-items-center p-3">
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
    <div class="col-md-4">
        <div class="glass-card stat-card">
            <div class="stat-icon green">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div>
                <div class="stat-label">Total Pemasukan</div>
                <div class="stat-value fs-4 text-success">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div>
                <div class="stat-label">Total Pengeluaran</div>
                <div class="stat-value fs-4 text-warning">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <div class="stat-label">Saldo (Laba Bersih)</div>
                <div class="stat-value fs-4 {{ $saldo >= 0 ? 'text-white' : 'text-danger' }}">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="glass-card p-4">
            <h5 class="text-white mb-3">Detail Arus Kas</h5>
            <div class="table-responsive">
                <table class="table-glass">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis & Kategori</th>
                            <th>Keterangan</th>
                            <th class="text-end">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keuangans as $item)
                        <tr>
                            <td>{{ $item->tanggal->format('d M Y') }}</td>
                            <td>
                                @if($item->jenis == 'masuk')
                                    <span class="badge-glass badge-success mb-1">Masuk</span>
                                @else
                                    <span class="badge-glass badge-warning mb-1">Keluar</span>
                                @endif
                                <div class="fw-bold text-white small">{{ $item->kategori }}</div>
                            </td>
                            <td class="text-muted small">{{ $item->keterangan ?? '-' }}</td>
                            <td class="text-end fw-bold font-mono {{ $item->jenis == 'masuk' ? 'text-success' : 'text-warning' }}">
                                {{ $item->jenis == 'masuk' ? '+' : '-' }} Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada data keuangan untuk periode ini.</td>
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