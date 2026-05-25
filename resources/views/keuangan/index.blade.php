@extends('layouts.app')
@section('title', 'Arus Kas Keuangan')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-wallet me-2 text-accent"></i> Manajemen Keuangan
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Keuangan</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('keuangan.create') }}" class="btn-glass-primary">
        <i class="fas fa-plus me-2"></i> Tambah Catatan
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="glass-card stat-card">
            <div class="stat-icon green">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div>
                <div class="stat-label">Total Pemasukan</div>
                <div class="stat-value fs-4 text-success">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div>
                <div class="stat-label">Total Pengeluaran</div>
                <div class="stat-value fs-4 text-warning">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass-card stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <div class="stat-label">Saldo Saat Ini</div>
                <div class="stat-value fs-4 text-white">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="filter-bar glass-card mb-4">
    <form action="{{ route('keuangan.index') }}" method="GET" class="row g-2 align-items-center p-3">
        <div class="col-md-3">
            <select name="jenis" class="form-glass">
                <option value="">Semua Jenis</option>
                <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Pemasukan</option>
                <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="bulan" class="form-glass">
                <option value="">Semua Bulan</option>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                @endfor
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn-glass-secondary">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
            @if(request('jenis') || request('bulan'))
                <a href="{{ route('keuangan.index') }}" class="btn-glass-danger ms-2">Reset</a>
            @endif
        </div>
    </form>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table-glass">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis & Kategori</th>
                    <th>Keterangan</th>
                    <th class="text-end">Jumlah</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($keuangans as $item)
                <tr>
                    <td>{{ $item->tanggal->format('d M Y') }}</td>
                    <td>
                        @if($item->jenis == 'masuk')
                            <span class="badge-glass badge-success mb-1">Masuk</span>
                        @else
                            <span class="badge-glass badge-warning mb-1">Keluar</span>
                        @endif
                        <div class="fw-bold text-white small">{{ $item->kategori }}</div>
                    </td>
                    <td class="text-muted small">{{ Str::limit($item->keterangan, 50) ?? '-' }}</td>
                    <td class="text-end fw-bold font-mono {{ $item->jenis == 'masuk' ? 'text-success' : 'text-warning' }}">
                        {{ $item->jenis == 'masuk' ? '+' : '-' }} Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            @if($item->bukti)
                                <a href="{{ asset('storage/' . $item->bukti) }}" target="_blank" class="btn-glass-icon" title="Lihat Bukti">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
                            @endif
                            <a href="{{ route('keuangan.edit', $item->id) }}" class="btn-glass-icon edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn-glass-icon delete" onclick="konfirmasiHapus('form-delete-{{ $item->id }}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="form-delete-{{ $item->id }}" action="{{ route('keuangan.destroy', $item->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-white">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        Belum ada data keuangan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($keuangans->hasPages())
    <div class="card-footer border-0 bg-transparent pt-3 pb-0">
        {{ $keuangans->links() }}
    </div>
    @endif
</div>
@endsection