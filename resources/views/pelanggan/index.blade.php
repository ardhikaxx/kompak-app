@extends('layouts.app')
@section('title', 'Manajemen Pelanggan')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-users me-2 text-accent"></i> Manajemen Pelanggan
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Pelanggan</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('pelanggan.create') }}" class="btn-glass-primary">
        <i class="fas fa-plus me-2"></i> Tambah Pelanggan
    </a>
</div>

<div class="filter-bar glass-card mb-4">
    <form action="{{ route('pelanggan.index') }}" method="GET" class="row g-2 align-items-center p-3">
        <div class="col-md-5">
            <div class="input-glass-icon">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-glass" placeholder="Cari nama, kode, atau telepon..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn-glass-secondary">
                <i class="fas fa-search me-1"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('pelanggan.index') }}" class="btn-glass-danger ms-2">Reset</a>
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
                    <th>Nama Pelanggan</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Total Transaksi</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggans as $item)
                <tr>
                    <td>{{ $loop->iteration + $pelanggans->firstItem() - 1 }}</td>
                    <td>
                        <div class="fw-bold text-white">{{ $item->nama_pelanggan }}</div>
                        <div class="text-muted small font-mono">{{ $item->kode_pelanggan ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="small"><i class="fas fa-phone text-muted me-1"></i> {{ $item->telepon ?? '-' }}</div>
                        <div class="small"><i class="fas fa-envelope text-muted me-1"></i> {{ $item->email ?? '-' }}</div>
                    </td>
                    <td class="text-muted small">{{ Str::limit($item->alamat, 40) ?? '-' }}</td>
                    <td class="text-accent fw-bold font-mono">Rp {{ number_format($item->total_transaksi, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('pelanggan.edit', $item->id) }}" class="btn-glass-icon edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn-glass-icon delete" onclick="konfirmasiHapus('form-delete-{{ $item->id }}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="form-delete-{{ $item->id }}" action="{{ route('pelanggan.destroy', $item->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 opacity-50 d-block"></i>
                        Belum ada data pelanggan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($pelanggans->hasPages())
    <div class="card-footer border-0 bg-transparent pt-3 pb-0">
        {{ $pelanggans->links() }}
    </div>
    @endif
</div>
@endsection