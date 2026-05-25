@extends('layouts.app')
@section('title', 'Katalog Produk')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-box me-2 text-accent"></i> Manajemen Produk
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Produk</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('produk.create') }}" class="btn-glass-primary">
        <i class="fas fa-plus me-2"></i> Tambah Produk
    </a>
</div>

<div class="filter-bar glass-card mb-4">
    <form action="{{ route('produk.index') }}" method="GET" class="row g-2 align-items-center p-3">
        <div class="col-md-4">
            <div class="input-glass-icon">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-glass" placeholder="Cari kode atau nama..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="kategori_id" class="form-glass">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto ms-md-auto">
            <button type="submit" class="btn-glass-secondary">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
            @if(request('search') || request('kategori_id'))
                <a href="{{ route('produk.index') }}" class="btn-glass-danger ms-2">Reset</a>
            @endif
        </div>
    </form>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table-glass">
            <thead>
                <tr>
                    <th>Info Produk</th>
                    <th>Kategori</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produks as $item)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded overflow-hidden" style="width: 48px; height: 48px; background: var(--glass-bg); display: flex; align-items: center; justify-content: center; border: 1px solid var(--glass-border);">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_produk }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="fas fa-box text-muted"></i>
                                @endif
                            </div>
                            <div>
                                <div class="fw-bold text-white">{{ $item->nama_produk }}</div>
                                <div class="text-muted small font-mono">{{ $item->kode_produk }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td class="text-accent fw-bold font-mono">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                    <td>
                        @if($item->stok <= 0)
                            <span class="badge-glass badge-danger">Habis</span>
                        @elseif($item->stok <= $item->stok_minimum)
                            <span class="badge-glass badge-warning">{{ $item->stok }} {{ $item->satuan }}</span>
                        @else
                            <span class="text-white">{{ $item->stok }} {{ $item->satuan }}</span>
                        @endif
                    </td>
                    <td>
                        @if($item->is_active)
                            <span class="badge-glass badge-success">Aktif</span>
                        @else
                            <span class="badge-glass badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('produk.edit', $item->id) }}" class="btn-glass-icon edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn-glass-icon delete" onclick="konfirmasiHapus('form-delete-{{ $item->id }}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="form-delete-{{ $item->id }}" action="{{ route('produk.destroy', $item->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-white">
                        <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
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