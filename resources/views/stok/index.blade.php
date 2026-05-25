@extends('layouts.app')
@section('title', 'Manajemen Stok')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-warehouse me-2 text-accent"></i> Manajemen Stok
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Stok</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('stok.create') }}" class="btn-glass-primary">
        <i class="fas fa-plus me-2"></i> Penyesuaian Stok
    </a>
</div>

@if($stokRendah > 0)
<div class="alert alert-warning d-flex align-items-center mb-4" style="background: var(--warning-bg); border-color: rgba(245,158,11,0.25); color: #fde68a;">
    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
    <div>
        <strong>Perhatian!</strong> Ada {{ $stokRendah }} produk yang stoknya telah mencapai batas minimum atau habis. Segera lakukan restock.
    </div>
</div>
@endif

<div class="filter-bar glass-card mb-4">
    <form action="{{ route('stok.index') }}" method="GET" class="row g-2 align-items-center p-3">
        <div class="col-md-5">
            <div class="input-glass-icon">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-glass" placeholder="Cari nama atau kode produk..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn-glass-secondary">
                <i class="fas fa-search me-1"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('stok.index') }}" class="btn-glass-danger ms-2">Reset</a>
            @endif
        </div>
    </form>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table-glass">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Info Produk</th>
                    <th>Kategori</th>
                    <th>Stok Tersedia</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produks as $item)
                <tr>
                    <td>{{ $loop->iteration + $produks->firstItem() - 1 }}</td>
                    <td>
                        <div class="fw-bold text-white">{{ $item->nama_produk }}</div>
                        <div class="text-muted small font-mono">{{ $item->kode_produk }}</div>
                    </td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td>
                        @if($item->stok <= 0)
                            <span class="badge-glass badge-danger"><i class="fas fa-times-circle me-1"></i>Habis</span>
                        @elseif($item->stok <= $item->stok_minimum)
                            <span class="badge-glass badge-warning"><i class="fas fa-exclamation-circle me-1"></i>{{ $item->stok }} {{ $item->satuan }}</span>
                        @else
                            <span class="badge-glass badge-success"><i class="fas fa-check-circle me-1"></i>{{ $item->stok }} {{ $item->satuan }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('stok.show', $item->id) }}" class="btn-glass-secondary btn-sm">
                            <i class="fas fa-history me-1"></i> Riwayat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-white">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        Belum ada data produk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($produks->hasPages())
    <div class="card-footer border-0 bg-transparent pt-3 pb-0">
        {{ $produks->links() }}
    </div>
    @endif
</div>
@endsection