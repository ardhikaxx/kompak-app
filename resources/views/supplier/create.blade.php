@extends('layouts.app')
@section('title', 'Tambah Supplier')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-plus-circle me-2 text-accent"></i> Tambah Supplier
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('supplier.index') }}" class="btn-glass-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="glass-card p-4">
    <form action="{{ route('supplier.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-7">
                <h5 class="text-white mb-3"><i class="fas fa-building text-accent me-2"></i> Profil Perusahaan</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-glass-label">Kode Supplier</label>
                        <input type="text" name="kode_supplier" class="form-glass @error('kode_supplier') border-danger @enderror" value="{{ old('kode_supplier') }}">
                        @error('kode_supplier') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-8">
                        <label class="form-glass-label">Nama Supplier <span class="text-danger">*</span></label>
                        <input type="text" name="nama_supplier" class="form-glass @error('nama_supplier') border-danger @enderror" value="{{ old('nama_supplier') }}" required>
                        @error('nama_supplier') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-glass-label">Nama PIC / Penanggung Jawab</label>
                        <input type="text" name="pic_nama" class="form-glass @error('pic_nama') border-danger @enderror" value="{{ old('pic_nama') }}">
                        @error('pic_nama') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">No. Telepon / WhatsApp</label>
                        <input type="text" name="telepon" class="form-glass @error('telepon') border-danger @enderror" value="{{ old('telepon') }}">
                        @error('telepon') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Email</label>
                        <input type="email" name="email" class="form-glass @error('email') border-danger @enderror" value="{{ old('email') }}">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-glass-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-glass @error('alamat') border-danger @enderror" rows="3">{{ old('alamat') }}</textarea>
                        @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="glass-card-blue p-4 h-100">
                    <h5 class="text-white mb-3"><i class="fas fa-star text-warning me-2"></i> Nilai Kriteria SPK</h5>
                    <p class="text-muted small mb-4">Nilai ini digunakan untuk perhitungan SPK PROMETHEE (skala 1-100).</p>
                    
                    <div class="mb-3">
                        <label class="form-glass-label">Kriteria Harga</label>
                        <input type="number" name="kriteria_harga" class="form-glass" value="{{ old('kriteria_harga') }}" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-glass-label">Kriteria Kualitas</label>
                        <input type="number" name="kriteria_kualitas" class="form-glass" value="{{ old('kriteria_kualitas') }}" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-glass-label">Kriteria Pengiriman</label>
                        <input type="number" name="kriteria_pengiriman" class="form-glass" value="{{ old('kriteria_pengiriman') }}" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-glass-label">Kriteria Konsistensi</label>
                        <input type="number" name="kriteria_konsistensi" class="form-glass" value="{{ old('kriteria_konsistensi') }}" min="0" max="100">
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-4 pt-3 border-top border-secondary">
            <button type="submit" class="btn-glass-primary px-4">
                <i class="fas fa-save me-2"></i> Simpan Supplier
            </button>
        </div>
    </form>
</div>
@endsection