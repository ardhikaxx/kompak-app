@extends('layouts.app')
@section('title', 'Kategori Produk')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-tags me-2 text-accent"></i> Manajemen Kategori
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Kategori</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('kategori.create') }}" class="btn-glass-primary">
        <i class="fas fa-plus me-2"></i> Tambah Kategori
    </a>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table-glass">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $kategori)
                <tr>
                    <td>{{ $loop->iteration + $kategoris->firstItem() - 1 }}</td>
                    <td class="fw-bold text-white">{{ $kategori->nama_kategori }}</td>
                    <td class="text-muted">{{ Str::limit($kategori->deskripsi, 50) ?? '-' }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn-glass-icon edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn-glass-icon delete" onclick="konfirmasiHapus('form-delete-{{ $kategori->id }}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="form-delete-{{ $kategori->id }}" action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 opacity-50 d-block"></i>
                        Belum ada data kategori.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($kategoris->hasPages())
    <div class="card-footer border-0 bg-transparent pt-3 pb-0">
        {{ $kategoris->links() }}
    </div>
    @endif
</div>
@endsection