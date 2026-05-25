@extends('layouts.app')
@section('title', 'Manajemen Supplier')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-truck me-2 text-accent"></i> Manajemen Supplier
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Supplier</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('supplier.create') }}" class="btn-glass-primary">
        <i class="fas fa-plus me-2"></i> Tambah Supplier
    </a>
</div>

<div class="filter-bar glass-card mb-4">
    <form action="{{ route('supplier.index') }}" method="GET" class="row g-2 align-items-center p-3">
        <div class="col-md-5">
            <div class="input-glass-icon">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-glass" placeholder="Cari nama, kode, atau PIC..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn-glass-secondary">
                <i class="fas fa-search me-1"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('supplier.index') }}" class="btn-glass-danger ms-2">Reset</a>
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
                    <th>Nama Supplier</th>
                    <th>Kontak PIC</th>
                    <th>Alamat</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $item)
                <tr>
                    <td>{{ $loop->iteration + $suppliers->firstItem() - 1 }}</td>
                    <td>
                        <div class="fw-bold text-white">{{ $item->nama_supplier }}</div>
                        <div class="text-muted small font-mono">{{ $item->kode_supplier ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="fw-bold text-accent">{{ $item->pic_nama ?? '-' }}</div>
                        <div class="small"><i class="fas fa-phone text-muted me-1"></i> {{ $item->telepon ?? '-' }}</div>
                        <div class="small"><i class="fas fa-envelope text-muted me-1"></i> {{ $item->email ?? '-' }}</div>
                    </td>
                    <td class="text-muted small">{{ Str::limit($item->alamat, 40) ?? '-' }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('supplier.edit', $item->id) }}" class="btn-glass-icon edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn-glass-icon delete" onclick="konfirmasiHapus('form-delete-{{ $item->id }}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="form-delete-{{ $item->id }}" action="{{ route('supplier.destroy', $item->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 opacity-50 d-block"></i>
                        Belum ada data supplier.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($suppliers->hasPages())
    <div class="card-footer border-0 bg-transparent pt-3 pb-0">
        {{ $suppliers->links() }}
    </div>
    @endif
</div>
@endsection