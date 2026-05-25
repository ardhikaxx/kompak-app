@extends('layouts.app')
@section('title', 'Kriteria SPK')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-sliders-h me-2 text-accent"></i> Pengaturan Kriteria SPK
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('spk.index') }}">SPK</a></li>
                <li class="breadcrumb-item active">Kriteria</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('spk.index') }}" class="btn-glass-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="glass-card p-4">
    <div class="alert alert-info" style="background: var(--info-bg); border-color: rgba(6,182,212,0.25); color: #67e8f9;">
        <i class="fas fa-info-circle me-2"></i> <strong>Informasi:</strong> Pastikan total seluruh bobot adalah <strong>1.00</strong> (100%).
    </div>

    <form action="{{ route('spk.kriteria.store') }}" method="POST">
        @csrf
        <div class="table-responsive">
            <table class="table-glass">
                <thead>
                    <tr>
                        <th>Nama Kriteria</th>
                        <th width="15%">Bobot</th>
                        <th width="15%">Tipe (Max/Min)</th>
                        <th width="20%">Fungsi Preferensi</th>
                        <th width="12%">Parameter P</th>
                        <th width="12%">Parameter Q</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kriterias as $index => $k)
                    <tr>
                        <td class="fw-bold text-white">
                            {{ $k->nama_kriteria }}
                            <input type="hidden" name="kriteria[{{ $index }}][id]" value="{{ $k->id }}">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="kriteria[{{ $index }}][bobot]" class="form-glass form-control-sm" value="{{ $k->bobot }}" required>
                        </td>
                        <td>
                            <select name="kriteria[{{ $index }}][tipe]" class="form-glass form-control-sm" required>
                                <option value="max" {{ $k->tipe == 'max' ? 'selected' : '' }}>Benefit (Max)</option>
                                <option value="min" {{ $k->tipe == 'min' ? 'selected' : '' }}>Cost (Min)</option>
                            </select>
                        </td>
                        <td>
                            <select name="kriteria[{{ $index }}][fungsi_preferensi]" class="form-glass form-control-sm" required>
                                <option value="usual" {{ $k->fungsi_preferensi == 'usual' ? 'selected' : '' }}>Type I: Usual</option>
                                <option value="u-shape" {{ $k->fungsi_preferensi == 'u-shape' ? 'selected' : '' }}>Type II: U-Shape</option>
                                <option value="v-shape" {{ $k->fungsi_preferensi == 'v-shape' ? 'selected' : '' }}>Type III: V-Shape</option>
                                <option value="level" {{ $k->fungsi_preferensi == 'level' ? 'selected' : '' }}>Type IV: Level</option>
                                <option value="linear" {{ $k->fungsi_preferensi == 'linear' ? 'selected' : '' }}>Type V: Linear</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" step="0.01" name="kriteria[{{ $index }}][p_parameter]" class="form-glass form-control-sm" value="{{ $k->p_parameter }}">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="kriteria[{{ $index }}][q_parameter]" class="form-glass form-control-sm" value="{{ $k->q_parameter }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="text-end mt-4">
            <button type="submit" class="btn-glass-primary px-4">
                <i class="fas fa-save me-2"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection