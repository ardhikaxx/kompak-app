@extends('layouts.app')
@section('title', 'Manajemen Pengguna')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-user-cog me-2 text-accent"></i> Manajemen Pengguna
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengguna</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('pengguna.create') }}" class="btn-glass-primary">
        <i class="fas fa-user-plus me-2"></i> Tambah Pengguna
    </a>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table-glass">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Pengguna</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penggunas as $user)
                <tr>
                    <td>{{ $loop->iteration + $penggunas->firstItem() - 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b82f6&color=fff" alt="{{ $user->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid var(--glass-border);">
                            <div>
                                <div class="fw-bold text-white">{{ $user->name }}</div>
                                <div class="small text-muted">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge-glass badge-primary">Admin</span>
                        @elseif($user->role == 'pemilik')
                            <span class="badge-glass badge-warning">Pemilik</span>
                        @else
                            <span class="badge-glass badge-info">Kasir</span>
                        @endif
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge-glass badge-success">Aktif</span>
                        @else
                            <span class="badge-glass badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('pengguna.edit', $user->id) }}" class="btn-glass-icon edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(auth()->id() !== $user->id)
                            <button type="button" class="btn-glass-icon delete" onclick="konfirmasiHapus('form-delete-{{ $user->id }}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="form-delete-{{ $user->id }}" action="{{ route('pengguna.destroy', $user->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-white">
                        <i class="fas fa-user-slash fa-3x mb-3 d-block"></i>
                        Belum ada data pengguna.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($penggunas->hasPages())
    <div class="card-footer border-0 bg-transparent pt-3 pb-0">
        {{ $penggunas->links() }}
    </div>
    @endif
</div>
@endsection