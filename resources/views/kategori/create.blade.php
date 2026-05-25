@extends('layouts.app')
@section('title', 'Tambah Kategori')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-plus-circle me-2 text-accent"></i> Tambah Kategori
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('kategori.index') }}" class="btn-glass-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="glass-card p-4">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-glass-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kategori" class="form-glass @error('nama_kategori') border-danger @enderror" value="{{ old('nama_kategori') }}" required placeholder="Masukkan nama kategori">
                    @error('nama_kategori') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-glass-label">Deskripsi Kategori</label>
                    <textarea name="deskripsi" class="form-glass @error('deskripsi') border-danger @enderror" rows="4" placeholder="Masukkan deskripsi opsional">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn-glass-primary">
                        <i class="fas fa-save me-2"></i> Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection