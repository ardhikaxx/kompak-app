@extends('layouts.app')
@section('title', 'Tambah Catatan Keuangan')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-plus-circle me-2 text-accent"></i> Catat Keuangan
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('keuangan.index') }}">Keuangan</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('keuangan.index') }}" class="btn-glass-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="glass-card p-4">
            <form action="{{ route('keuangan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-glass-label">Jenis Arus Kas <span class="text-danger">*</span></label>
                        <select name="jenis" class="form-glass @error('jenis') border-danger @enderror" required>
                            <option value="masuk" {{ old('jenis') == 'masuk' ? 'selected' : '' }}>Pemasukan (Masuk)</option>
                            <option value="keluar" {{ old('jenis') == 'keluar' ? 'selected' : '' }}>Pengeluaran (Keluar)</option>
                        </select>
                        @error('jenis') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="kategori" class="form-glass @error('kategori') border-danger @enderror" value="{{ old('kategori') }}" required placeholder="Contoh: Operasional, Gaji, Tagihan">
                        @error('kategori') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Jumlah (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-glass @error('jumlah') border-danger @enderror" value="{{ old('jumlah') }}" required min="0">
                        @error('jumlah') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-glass @error('tanggal') border-danger @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                        @error('tanggal') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-glass-label">Keterangan Tambahan</label>
                        <textarea name="keterangan" class="form-glass @error('keterangan') border-danger @enderror" rows="3" placeholder="Deskripsi transaksi keuangan">{{ old('keterangan') }}</textarea>
                        @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-glass-label">Bukti Transaksi (Opsional)</label>
                        <input type="file" name="bukti" class="form-glass" accept="image/*">
                        @error('bukti') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn-glass-primary">
                        <i class="fas fa-save me-2"></i> Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection