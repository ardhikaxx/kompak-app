@extends('layouts.app')
@section('title', 'SPK PROMETHEE')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-brain me-2 text-accent"></i> SPK PROMETHEE II
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">SPK PROMETHEE</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="glass-card p-5 h-100 d-flex flex-column justify-content-center text-center">
            <i class="fas fa-robot fa-4x text-accent mb-4"></i>
            <h4 class="text-white fw-bold mb-3">Sistem Pendukung Keputusan</h4>
            <p class="text-muted mb-4 px-lg-5">Sistem ini menggunakan metode PROMETHEE II untuk membantu Anda menentukan supplier terbaik berdasarkan kriteria Harga, Kualitas, Pengiriman, dan Konsistensi yang telah Anda tentukan.</p>
            
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('spk.hitung') }}" class="btn-glass-primary px-4 py-2 fs-6">
                    <i class="fas fa-play me-2"></i> Mulai Perhitungan
                </a>
                <a href="{{ route('spk.hasil') }}" class="btn-glass-secondary px-4 py-2 fs-6">
                    <i class="fas fa-trophy me-2"></i> Lihat Hasil Terakhir
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card p-4 h-100">
            <h5 class="text-white mb-4"><i class="fas fa-cogs text-warning me-2"></i> Pengaturan</h5>
            <p class="small text-muted mb-4">Pastikan kriteria preferensi dan bobot sudah disesuaikan dengan kebutuhan bisnis Anda sebelum melakukan perhitungan.</p>
            <a href="{{ route('spk.kriteria') }}" class="btn-glass-secondary w-100 mb-3">
                <i class="fas fa-sliders-h me-2"></i> Atur Bobot & Kriteria
            </a>
            <a href="{{ route('supplier.index') }}" class="btn-glass-secondary w-100">
                <i class="fas fa-truck me-2"></i> Kelola Data Supplier
            </a>
        </div>
    </div>
</div>
@endsection