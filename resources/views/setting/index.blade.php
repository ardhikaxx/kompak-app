@extends('layouts.app')
@section('title', 'Pengaturan Toko')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-store me-2 text-accent"></i> Pengaturan Profil Toko
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengaturan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="glass-card p-4">
            <h5 class="text-white mb-4"><i class="fas fa-edit me-2 text-accent"></i> Ubah Profil Bisnis</h5>
            <form action="{{ route('setting.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-glass-label">Nama Toko <span class="text-danger">*</span></label>
                    <input type="text" name="nama_toko" class="form-glass" value="{{ $settings['nama_toko'] }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-glass-label">No. Telepon / HP</label>
                    <input type="text" name="telepon_toko" class="form-glass" value="{{ $settings['telepon_toko'] }}">
                </div>
                <div class="mb-3">
                    <label class="form-glass-label">Email Toko</label>
                    <input type="email" name="email_toko" class="form-glass" value="{{ $settings['email_toko'] }}">
                </div>
                <div class="mb-4">
                    <label class="form-glass-label">Alamat Lengkap</label>
                    <textarea name="alamat_toko" class="form-glass" rows="3">{{ $settings['alamat_toko'] }}</textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn-glass-primary px-4">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-5">
        <div class="glass-card p-4 h-100">
            <h5 class="text-white mb-3"><i class="fas fa-info-circle me-2 text-accent"></i> Informasi Nota</h5>
            <p class="text-white opacity-75 small">Data yang Anda masukkan di sini akan otomatis muncul pada bagian header nota/struk penjualan dan laporan sistem.</p>
            
            <div class="mt-4 p-4 rounded border border-secondary" style="background: rgba(255,255,255,0.02);">
                <div class="text-center">
                    <h6 class="text-white fw-bold mb-1">{{ $settings['nama_toko'] }}</h6>
                    <p class="text-white opacity-50 small mb-0">{{ $settings['alamat_toko'] }}</p>
                    <p class="text-white opacity-50 small mb-0">Telp: {{ $settings['telepon_toko'] }}</p>
                </div>
            </div>
            <div class="mt-3 text-center">
                <small class="text-accent italic">Pratinjau Header Nota</small>
            </div>
        </div>
    </div>
</div>
@endsection