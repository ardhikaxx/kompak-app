@extends('layouts.app')
@section('title', 'Riwayat Stok Produk')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-history me-2 text-accent"></i> Riwayat Stok: {{ $produk->nama_produk }}
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('stok.index') }}">Stok</a></li>
                <li class="breadcrumb-item active">Riwayat</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('stok.index') }}" class="btn-glass-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="glass-card p-4 text-center">
            <h6 class="text-muted mb-2">Sisa Stok Saat Ini</h6>
            <h2 class="text-white fw-bold mb-0">{{ $produk->stok }} <small class="fs-6 text-muted">{{ $produk->satuan }}</small></h2>
        </div>
    </div>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table-glass">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Jenis</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Stok Sebelum</th>
                    <th class="text-center">Stok Sesudah</th>
                    <th>Keterangan</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="small">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($log->jenis == 'masuk')
                            <span class="badge-glass badge-success"><i class="fas fa-arrow-down me-1"></i> Masuk</span>
                        @else
                            <span class="badge-glass badge-danger"><i class="fas fa-arrow-up me-1"></i> Keluar</span>
                        @endif
                    </td>
                    <td class="text-center fw-bold">{{ $log->jumlah }}</td>
                    <td class="text-center text-muted">{{ $log->stok_sebelum }}</td>
                    <td class="text-center text-white">{{ $log->stok_sesudah }}</td>
                    <td class="small">{{ $log->keterangan }}</td>
                    <td class="small">{{ $log->user->name ?? 'Sistem' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-white">Belum ada riwayat stok.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($logs->hasPages())
    <div class="card-footer border-0 bg-transparent pt-3 pb-0">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection