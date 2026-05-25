@extends('layouts.app')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-cash-register me-2 text-accent"></i> Riwayat Transaksi
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Transaksi</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('transaksi.create') }}" class="btn-glass-primary">
        <i class="fas fa-plus me-2"></i> Transaksi Baru (POS)
    </a>
</div>

<div class="filter-bar glass-card mb-4">
    <form action="{{ route('transaksi.index') }}" method="GET" class="row g-2 align-items-center p-3">
        <div class="col-md-5">
            <div class="input-glass-icon">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-glass" placeholder="Cari kode transaksi..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn-glass-secondary">
                <i class="fas fa-search me-1"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('transaksi.index') }}" class="btn-glass-danger ms-2">Reset</a>
            @endif
        </div>
    </form>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table-glass">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Kode Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Total Pembelian</th>
                    <th>Metode</th>
                    <th>Kasir</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $trx)
                <tr>
                    <td>
                        <div class="text-white">{{ $trx->tanggal->format('d/m/Y') }}</div>
                        <div class="small text-muted">{{ $trx->tanggal->format('H:i') }}</div>
                    </td>
                    <td class="fw-bold font-mono text-accent">{{ $trx->kode_transaksi }}</td>
                    <td>{{ $trx->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
                    <td class="fw-bold text-white">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                    <td><span class="badge-glass badge-info">{{ $trx->metode_bayar }}</span></td>
                    <td class="small">{{ $trx->user->name ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('transaksi.show', $trx->id) }}" class="btn-glass-secondary btn-sm" title="Lihat Detail">
                            <i class="fas fa-eye me-1"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-white">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        Belum ada data transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($transaksis->hasPages())
    <div class="card-footer border-0 bg-transparent pt-3 pb-0">
        {{ $transaksis->links() }}
    </div>
    @endif
</div>
@endsection