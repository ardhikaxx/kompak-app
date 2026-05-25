@extends('layouts.app')
@section('title', 'Hasil SPK')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-trophy me-2 text-warning"></i> Hasil Rekomendasi SPK
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('spk.index') }}">SPK</a></li>
                <li class="breadcrumb-item active">Hasil</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn-glass-secondary me-2" onclick="window.print()">
            <i class="fas fa-print me-2"></i> Cetak Hasil
        </button>
        <a href="{{ route('spk.index') }}" class="btn-glass-primary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
</div>

<div class="row mb-4" id="printableArea">
    <div class="col-12">
        <div class="glass-card p-5">
            <div class="text-center mb-5">
                <h4 class="text-white fw-bold">Peringkat Supplier Terbaik</h4>
                <p class="text-muted small">Berdasarkan Perhitungan PROMETHEE II</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @foreach($hasil as $index => $item)
                        @php
                            $rank = $index + 1;
                            $rankClass = 'rank-other';
                            if ($rank == 1) $rankClass = 'rank-1';
                            elseif ($rank == 2) $rankClass = 'rank-2';
                            elseif ($rank == 3) $rankClass = 'rank-3';
                            
                            // Normalisasi flow untuk bar (dari -1 sampai 1 menjadi 0 sampai 100%)
                            $percent = (($item['net_flow'] + 1) / 2) * 100;
                        @endphp
                        <div class="ranking-item">
                            <div class="ranking-badge {{ $rankClass }}">
                                {{ $rank }}
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <div class="d-flex justify-content-between align-items-end mb-1">
                                    <h6 class="text-white fw-bold mb-0">{{ $item['alternatif']['nama_supplier'] }}</h6>
                                    <span class="badge-glass badge-primary" style="font-size:0.65rem;">Net Flow: {{ number_format($item['net_flow'], 4) }}</span>
                                </div>
                                <div class="flow-bar-container">
                                    <div class="d-flex justify-content-between flow-bar-label">
                                        <span>Leaving (+): {{ number_format($item['leaving'], 4) }}</span>
                                        <span>Entering (-): {{ number_format($item['entering'], 4) }}</span>
                                    </div>
                                    <div class="flow-bar">
                                        <div class="flow-bar-fill" style="width: {{ max(0, min(100, $percent)) }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-5 text-muted small text-center">
                <i class="fas fa-info-circle me-1"></i> Supplier dengan peringkat ke-1 adalah rekomendasi utama sistem berdasarkan kriteria yang telah ditentukan.
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    .sidebar, .topbar, .page-header { display: none; }
    .main-content { margin-left: 0 !important; }
    #printableArea, #printableArea * { visibility: visible; }
    #printableArea {
        position: absolute; left: 0; top: 0; width: 100%;
    }
}
</style>
@endsection