@extends('layouts.app')
@section('title', 'Penyesuaian Stok')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-plus-circle me-2 text-accent"></i> Penyesuaian Stok Manual
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('stok.index') }}">Stok</a></li>
                <li class="breadcrumb-item active">Penyesuaian</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('stok.index') }}" class="btn-glass-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="glass-card p-4">
            <form action="{{ route('stok.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-glass-label">Pilih Produk <span class="text-danger">*</span></label>
                    <select name="produk_id" class="form-glass @error('produk_id') border-danger @enderror" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produks as $produk)
                            <option value="{{ $produk->id }}" {{ old('produk_id') == $produk->id ? 'selected' : '' }}>
                                {{ $produk->kode_produk }} - {{ $produk->nama_produk }} (Stok: {{ $produk->stok }} {{ $produk->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('produk_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-glass-label">Jenis Penyesuaian <span class="text-danger">*</span></label>
                        <select name="jenis" class="form-glass @error('jenis') border-danger @enderror" required>
                            <option value="masuk" {{ old('jenis') == 'masuk' ? 'selected' : '' }}>Stok Masuk (+)</option>
                            <option value="keluar" {{ old('jenis') == 'keluar' ? 'selected' : '' }}>Stok Keluar (-)</option>
                        </select>
                        @error('jenis') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-glass @error('jumlah') border-danger @enderror" value="{{ old('jumlah') }}" required min="1">
                        @error('jumlah') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-glass-label">Keterangan / Alasan</label>
                    <textarea name="keterangan" class="form-glass @error('keterangan') border-danger @enderror" rows="3" placeholder="Contoh: Barang rusak, retur, atau stok awal">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn-glass-primary">
                        <i class="fas fa-save me-2"></i> Simpan Penyesuaian Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection