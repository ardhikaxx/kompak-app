@extends('layouts.app')
@section('title', 'Edit Produk')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-edit me-2 text-accent"></i> Edit Produk
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('produk.index') }}">Produk</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('produk.index') }}" class="btn-glass-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="glass-card p-4">
    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-8">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-glass-label">Kode Produk <span class="text-danger">*</span></label>
                        <input type="text" name="kode_produk" class="form-glass @error('kode_produk') border-danger @enderror" value="{{ old('kode_produk', $produk->kode_produk) }}" required>
                        @error('kode_produk') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="nama_produk" class="form-glass @error('nama_produk') border-danger @enderror" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                        @error('nama_produk') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-glass-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-glass @error('kategori_id') border-danger @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $produk->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Harga Beli <span class="text-danger">*</span></label>
                        <input type="number" name="harga_beli" class="form-glass @error('harga_beli') border-danger @enderror" value="{{ old('harga_beli', $produk->harga_beli) }}" required min="0">
                        @error('harga_beli') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-glass-label">Harga Jual <span class="text-danger">*</span></label>
                        <input type="number" name="harga_jual" class="form-glass @error('harga_jual') border-danger @enderror" value="{{ old('harga_jual', $produk->harga_jual) }}" required min="0">
                        @error('harga_jual') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-glass-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stok" class="form-glass @error('stok') border-danger @enderror" value="{{ old('stok', $produk->stok) }}" required min="0">
                        @error('stok') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-glass-label">Stok Minimum <span class="text-danger">*</span></label>
                        <input type="number" name="stok_minimum" class="form-glass @error('stok_minimum') border-danger @enderror" value="{{ old('stok_minimum', $produk->stok_minimum) }}" required min="1">
                        @error('stok_minimum') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-glass-label">Satuan <span class="text-danger">*</span></label>
                        <input type="text" name="satuan" class="form-glass @error('satuan') border-danger @enderror" value="{{ old('satuan', $produk->satuan) }}" required>
                        @error('satuan') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-glass-label">Deskripsi Produk</label>
                        <textarea name="deskripsi" class="form-glass @error('deskripsi') border-danger @enderror" rows="3">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card-blue p-3 mb-3 rounded">
                    <label class="form-glass-label">Foto Produk</label>
                    <input type="file" name="foto" class="form-glass mb-2" accept="image/*" onchange="previewImage(event)">
                    <div class="text-center mt-3">
                        @if($produk->foto)
                            <img id="preview" src="{{ asset('storage/' . $produk->foto) }}" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: var(--radius-md);">
                        @else
                            <img id="preview" src="#" alt="Preview" style="max-width: 100%; max-height: 200px; display: none; border-radius: var(--radius-md);">
                        @endif
                    </div>
                    @error('foto') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                
                <div class="glass-card-blue p-3 rounded mb-3">
                    <label class="form-glass-label">Status Produk</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', $produk->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label text-white" for="is_active">Aktifkan Produk</label>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn-glass-primary">
                        <i class="fas fa-save me-2"></i> Perbarui Produk
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
@endsection