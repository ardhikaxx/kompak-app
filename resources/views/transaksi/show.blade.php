@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-receipt me-2 text-accent"></i> Detail Transaksi
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>
    <div>
        <button onclick="window.print()" class="btn-glass-secondary me-2">
            <i class="fas fa-print me-2"></i> Cetak Struk
        </button>
        <a href="{{ route('transaksi.index') }}" class="btn-glass-primary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Area Print -->
        <div class="glass-card p-5" id="printableArea">
            <div class="text-center mb-4 border-bottom border-secondary pb-4">
                <h4 class="text-white fw-bold mb-1">KOMPAK UMKM</h4>
                <p class="text-muted mb-0 small">Sistem Manajemen Bisnis & Kasir</p>
            </div>

            <div class="row mb-4">
                <div class="col-sm-6">
                    <p class="mb-1 text-muted small">KODE TRANSAKSI</p>
                    <h6 class="text-white fw-bold font-mono">{{ $transaksi->kode_transaksi }}</h6>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <p class="mb-1 text-muted small">TANGGAL TRANSAKSI</p>
                    <h6 class="text-white">{{ $transaksi->tanggal->format('d F Y, H:i') }}</h6>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-sm-6">
                    <p class="mb-1 text-muted small">PELANGGAN</p>
                    <h6 class="text-white">{{ $transaksi->pelanggan->nama_pelanggan ?? 'Pelanggan Umum' }}</h6>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <p class="mb-1 text-muted small">KASIR</p>
                    <h6 class="text-white">{{ $transaksi->user->name ?? '-' }}</h6>
                </div>
            </div>

            <div class="table-responsive mb-4 border-bottom border-secondary pb-2">
                <table class="table table-borderless text-white">
                    <thead class="text-muted small border-bottom border-secondary">
                        <tr>
                            <th>Item</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->detailTransaksis as $detail)
                        <tr>
                            <td>
                                <div>{{ $detail->produk->nama_produk ?? 'Produk Dihapus' }}</div>
                                <div class="small text-muted">{{ $detail->produk->kode_produk ?? '-' }}</div>
                            </td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td class="text-end">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end">
                <div class="col-sm-6 col-md-5">
                    <div class="d-flex justify-content-between mb-2 small text-muted">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($transaksi->diskon > 0)
                    <div class="d-flex justify-content-between mb-2 small text-danger">
                        <span>Diskon</span>
                        <span>- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($transaksi->pajak > 0)
                    <div class="d-flex justify-content-between mb-2 small text-muted">
                        <span>Pajak</span>
                        <span>+ Rp {{ number_format($transaksi->pajak, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between mb-3 mt-3 pt-3 border-top border-secondary">
                        <span class="text-white fw-bold">TOTAL</span>
                        <span class="text-accent fw-bold fs-5">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small text-muted">
                        <span>Bayar ({{ $transaksi->metode_bayar }})</span>
                        <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-0 small text-muted">
                        <span>Kembalian</span>
                        <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5 text-muted small">
                <p>Terima kasih atas kunjungan Anda!</p>
            </div>
        </div>
        <!-- End Area Print -->
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    .sidebar, .topbar, .page-header { display: none; }
    .main-content { margin-left: 0 !important; }
    #printableArea, #printableArea * { visibility: visible; }
    #printableArea {
        position: absolute; left: 0; top: 0;
        width: 100%; border: none !important; box-shadow: none !important;
        background: transparent !important; color: #000 !important;
    }
    .text-white, .text-muted, .text-accent { color: #000 !important; }
}
</style>
@endsection