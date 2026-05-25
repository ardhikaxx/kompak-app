@extends('layouts.app')
@section('title', 'Edit Pengguna')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-edit me-2 text-accent"></i> Edit Pengguna
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengguna.index') }}">Pengguna</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('pengguna.index') }}" class="btn-glass-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="glass-card p-4">
    <form action="{{ route('pengguna.update', $pengguna->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-8">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-glass-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-glass @error('name') border-danger @enderror" value="{{ old('name', $pengguna->name) }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-glass @error('email') border-danger @enderror" value="{{ old('email', $pengguna->email) }}" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Password Baru (Biarkan kosong jika tidak diubah)</label>
                        <input type="password" name="password" class="form-glass @error('password') border-danger @enderror" minlength="8">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-glass" minlength="8">
                    </div>
                    <div class="col-md-12">
                        <label class="form-glass-label">Role / Hak Akses <span class="text-danger">*</span></label>
                        <select name="role" class="form-glass @error('role') border-danger @enderror" required>
                            <option value="kasir" {{ old('role', $pengguna->role) == 'kasir' ? 'selected' : '' }}>Kasir / Pegawai</option>
                            <option value="pemilik" {{ old('role', $pengguna->role) == 'pemilik' ? 'selected' : '' }}>Pemilik Bisnis</option>
                            <option value="admin" {{ old('role', $pengguna->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="glass-card-blue p-3 rounded mb-3">
                    <label class="form-glass-label">Foto Profil (Ganti baru)</label>
                    <div class="mb-2">
                        @if($pengguna->foto)
                            <img src="{{ asset('storage/' . $pengguna->foto) }}" alt="Preview" style="max-height: 100px; border-radius: var(--radius-md);">
                        @endif
                    </div>
                    <input type="file" name="foto" class="form-glass" accept="image/*">
                    @error('foto') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                
                <div class="glass-card-blue p-3 rounded mb-3">
                    <label class="form-glass-label">Status Akun</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', $pengguna->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label text-white" for="is_active">Akun Aktif</label>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn-glass-primary py-2">
                        <i class="fas fa-save me-2"></i> Perbarui Pengguna
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection