@extends('layouts.app')
@section('title', 'Tambah Pelanggan')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-plus-circle me-2 text-accent"></i> Tambah Pelanggan
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('pelanggan.index') }}" class="btn-glass-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="glass-card p-4">
            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-glass-label">Kode Pelanggan</label>
                        <input type="text" name="kode_pelanggan" class="form-glass @error('kode_pelanggan') border-danger @enderror" value="{{ old('kode_pelanggan') }}" placeholder="Opsional (Otomatis jika kosong)">
                        @error('kode_pelanggan') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Nama Pelanggan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pelanggan" class="form-glass @error('nama_pelanggan') border-danger @enderror" value="{{ old('nama_pelanggan') }}" required placeholder="Masukkan nama lengkap">
                        @error('nama_pelanggan') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">No. Telepon / WhatsApp</label>
                        <input type="text" name="telepon" class="form-glass @error('telepon') border-danger @enderror" value="{{ old('telepon') }}" placeholder="Contoh: 08123456789">
                        @error('telepon') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Email</label>
                        <input type="email" name="email" class="form-glass @error('email') border-danger @enderror" value="{{ old('email') }}" placeholder="Contoh: pelanggan@email.com">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-glass-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-glass @error('alamat') border-danger @enderror" rows="3" placeholder="Masukkan alamat domisili">{{ old('alamat') }}</textarea>
                        @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn-glass-primary">
                        <i class="fas fa-save me-2"></i> Simpan Pelanggan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection