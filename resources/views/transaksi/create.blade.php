@extends('layouts.app')
@section('title', 'Point of Sales')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-desktop me-2 text-accent"></i> Point of Sales (POS)
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
                <li class="breadcrumb-item active">POS</li>
            </ol>
        </nav>
    </div>
</div>

<form action="{{ route('transaksi.store') }}" method="POST" id="form-transaksi">
    @csrf
    <input type="hidden" name="kode_transaksi" value="{{ $kodeTransaksi }}">
    
    <div class="row g-4" style="height: calc(100vh - 180px);">
        <!-- Kiri: Pilih Produk (65% width on desktop) -->
        <div class="col-lg-8 h-100">
            <div class="glass-card p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-white mb-0"><i class="fas fa-th-large me-2 text-accent"></i> Pilih Produk</h5>
                    <div style="width: 300px;">
                        <div class="input-glass-icon">
                            <i class="fas fa-search"></i>
                            <input type="text" id="search-produk" class="form-glass" placeholder="Cari nama atau kode...">
                        </div>
                    </div>
                </div>

                <!-- Scrollable Product Grid -->
                <div class="flex-grow-1" style="overflow-y: auto; overflow-x: hidden; padding-right: 5px;">
                    <div class="row g-3" id="produk-list">
                        @foreach($produks as $produk)
                        <div class="col-xl-3 col-md-4 col-sm-6 produk-item mb-2" data-nama="{{ strtolower($produk->nama_produk) }}">
                            <div class="glass-card-blue p-3 text-center h-100 d-flex flex-column justify-content-between position-relative overflow-hidden" 
                                 style="cursor:pointer; transition: transform 0.2s, box-shadow 0.2s; border: 1px solid var(--glass-border);" 
                                 onclick="tambahKeKeranjang({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga_jual }}, {{ $produk->stok }})">
                                
                                @if($produk->stok <= 0)
                                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.6); z-index: 2;">
                                        <span class="badge bg-danger">HABIS</span>
                                    </div>
                                @endif

                                <div class="mb-2">
                                    <i class="fas fa-box fa-2x text-accent mb-2"></i>
                                    <h6 class="text-white mb-1" style="font-size:0.85rem; line-height: 1.3;">{{ Str::limit($produk->nama_produk, 30) }}</h6>
                                    <div class="text-white opacity-75 small font-mono" style="font-size: 0.7rem;">{{ $produk->kode_produk }}</div>
                                </div>
                                
                                <div>
                                    <div class="text-accent fw-bold mb-1">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</div>
                                    <div class="text-white small py-1 rounded" style="background: rgba(255,255,255,0.05); font-size:0.7rem;">
                                        Stok: <span class="{{ $produk->stok <= $produk->stok_minimum ? 'text-warning fw-bold' : '' }}">{{ $produk->stok }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan: Keranjang (35% width on desktop) -->
        <div class="col-lg-4 h-100">
            <div class="glass-card p-3 h-100 d-flex flex-column">
                <h5 class="text-white mb-3 small fw-bold"><i class="fas fa-shopping-cart me-2 text-accent"></i> KERANJANG</h5>
                
                <!-- Pelanggan Selection -->
                <div class="mb-3">
                    <select name="pelanggan_id" class="form-glass form-glass-sm">
                        <option value="">-- Pelanggan Umum --</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama_pelanggan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Scrollable Cart Area -->
                <div class="flex-grow-1 mb-3" style="min-height: 300px; overflow-y: auto; border: 1px solid var(--glass-border); border-radius: var(--radius-md); background: rgba(0,0,0,0.2);">
                    <div id="keranjang-kosong" class="text-center text-white py-4">
                        <i class="fas fa-shopping-basket fa-2x mb-2 opacity-50"></i>
                        <p class="small mb-0">Keranjang masih kosong</p>
                    </div>
                    <table class="table-glass w-100" id="tabel-keranjang" style="display:none;">
                        <thead class="sticky-top" style="background: var(--bg-secondary); z-index: 10;">
                            <tr>
                                <th class="ps-2 py-2 small" style="font-size: 0.65rem;">ITEM</th>
                                <th class="py-2 small text-center" width="60" style="font-size: 0.65rem;">QTY</th>
                                <th class="pe-2 py-2 small text-end" style="font-size: 0.65rem;">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody id="keranjang-body">
                            <!-- Items inserted by JS -->
                        </tbody>
                    </table>
                </div>

                <!-- Calculation & Payment Area -->
                <div class="p-3 rounded mb-2" style="background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border);">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-white opacity-75 small">Subtotal</span>
                        <span class="text-white small" id="lbl-subtotal">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-white opacity-75 small">Diskon</span>
                        <input type="number" name="diskon" id="input-diskon" class="form-glass form-control-sm text-end py-0" style="width: 100px; height: 28px;" value="0" min="0" oninput="hitungTotal()">
                    </div>
                    <div class="d-flex justify-content-between pt-2 border-top border-secondary mb-3">
                        <span class="text-white fw-bold">TOTAL</span>
                        <span class="text-accent fw-bold h5 mb-0" id="lbl-total">Rp 0</span>
                    </div>
                    
                    <div class="mb-2">
                        <label class="form-glass-label mb-1" style="font-size: 0.65rem;">NOMINAL BAYAR</label>
                        <input type="number" name="bayar" id="input-bayar" class="form-glass fs-4 fw-bold text-end text-accent" style="height: 50px;" placeholder="0" required min="0" oninput="hitungKembalian()">
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background: rgba(34, 197, 94, 0.1);">
                        <span class="text-white small">Kembalian</span>
                        <span class="text-success fw-bold" id="lbl-kembalian">Rp 0</span>
                    </div>
                </div>

                <button type="button" class="btn-glass-primary w-100 py-2 fs-6" onclick="prosesTransaksi()">
                    <i class="fas fa-check-circle me-2"></i> PROSES BAYAR
                </button>
            </div>
        </div>
    </div>
</form>

<style>
    /* Custom Scrollbar for Glass Theme */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--glass-border); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--blue-primary); }
    
    .produk-item .glass-card-blue:hover {
        transform: translateY(-5px);
        box-shadow: var(--glass-shadow-blue);
        border-color: var(--blue-primary) !important;
    }
    
    #tabel-keranjang thead th {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>

@push('scripts')
<script>
    let keranjang = [];

    document.getElementById('search-produk').addEventListener('input', function(e) {
        let keyword = e.target.value.toLowerCase();
        let items = document.querySelectorAll('.produk-item');
        items.forEach(item => {
            if(item.dataset.nama.includes(keyword)) item.style.display = 'block';
            else item.style.display = 'none';
        });
    });

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    function tambahKeKeranjang(id, nama, harga, stokMax) {
        if(stokMax <= 0) {
            alertWarning('Stok produk habis!');
            return;
        }

        let index = keranjang.findIndex(item => item.id === id);
        if(index > -1) {
            if(keranjang[index].qty < stokMax) {
                keranjang[index].qty++;
            } else {
                alertWarning('Maksimal stok tercapai!');
            }
        } else {
            keranjang.push({ id, nama, harga, qty: 1, stokMax });
        }
        renderKeranjang();
    }

    function ubahQty(index, delta) {
        let item = keranjang[index];
        let newQty = item.qty + delta;
        if(newQty > 0 && newQty <= item.stokMax) {
            item.qty = newQty;
        } else if (newQty > item.stokMax) {
            alertWarning('Maksimal stok tercapai!');
        }
        renderKeranjang();
    }

    function hapusItem(index) {
        keranjang.splice(index, 1);
        renderKeranjang();
    }

    function renderKeranjang() {
        let tbody = document.getElementById('keranjang-body');
        let emptyDiv = document.getElementById('keranjang-kosong');
        let table = document.getElementById('tabel-keranjang');
        
        tbody.innerHTML = '';
        
        if(keranjang.length === 0) {
            emptyDiv.style.display = 'block';
            table.style.display = 'none';
        } else {
            emptyDiv.style.display = 'none';
            table.style.display = 'table';
            
            keranjang.forEach((item, index) => {
                let subtotal = item.harga * item.qty;
                tbody.innerHTML += `
                    <tr class="border-bottom border-secondary">
                        <td class="ps-3 py-3">
                            <div class="text-white fw-bold small">${item.nama}</div>
                            <div class="text-white opacity-50" style="font-size:0.7rem;">Rp ${formatRupiah(item.harga)}</div>
                            <input type="hidden" name="produk_id[]" value="${item.id}">
                            <input type="hidden" name="jumlah[]" value="${item.qty}">
                        </td>
                        <td class="text-center py-3">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-outline-light border-0 px-1 py-0" onclick="ubahQty(${index}, -1)"><i class="fas fa-minus" style="font-size:0.6rem;"></i></button>
                                <span class="text-white fw-bold small">${item.qty}</span>
                                <button type="button" class="btn btn-sm btn-outline-light border-0 px-1 py-0" onclick="ubahQty(${index}, 1)"><i class="fas fa-plus" style="font-size:0.6rem;"></i></button>
                            </div>
                        </td>
                        <td class="pe-3 text-end py-3">
                            <div class="text-accent fw-bold small">Rp ${formatRupiah(subtotal)}</div>
                            <a href="javascript:void(0)" class="text-danger small" style="text-decoration:none; font-size:0.65rem;" onclick="hapusItem(${index})">Hapus</a>
                        </td>
                    </tr>
                `;
            });
        }
        hitungTotal();
    }

    function hitungTotal() {
        let subtotal = keranjang.reduce((sum, item) => sum + (item.harga * item.qty), 0);
        let diskon = parseInt(document.getElementById('input-diskon').value) || 0;
        
        let total = subtotal - diskon;
        if(total < 0) total = 0;

        document.getElementById('lbl-subtotal').innerText = 'Rp ' + formatRupiah(subtotal);
        document.getElementById('lbl-total').innerText = 'Rp ' + formatRupiah(total);
        document.getElementById('lbl-total').dataset.val = total;
        
        hitungKembalian();
    }

    function hitungKembalian() {
        let total = parseInt(document.getElementById('lbl-total').dataset.val) || 0;
        let bayar = parseInt(document.getElementById('input-bayar').value) || 0;
        
        let kembalian = bayar - total;
        let lblKembalian = document.getElementById('lbl-kembalian');
        
        if(kembalian < 0) {
            lblKembalian.innerText = 'Kurang Rp ' + formatRupiah(Math.abs(kembalian));
            lblKembalian.className = 'text-danger fw-bold mb-0';
        } else {
            lblKembalian.innerText = 'Rp ' + formatRupiah(kembalian);
            lblKembalian.className = 'text-success fw-bold mb-0';
        }
    }

    function prosesTransaksi() {
        if(keranjang.length === 0) {
            alertError('Keranjang belanja masih kosong!');
            return;
        }
        
        let total = parseInt(document.getElementById('lbl-total').dataset.val) || 0;
        let bayar = parseInt(document.getElementById('input-bayar').value) || 0;
        
        if(bayar < total) {
            alertError('Nominal pembayaran kurang dari total tagihan!');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Bayar',
            html: `<div class="text-center">
                    <p class="mb-1">Total Tagihan:</p>
                    <h3 class="text-primary fw-bold mb-3">Rp ${formatRupiah(total)}</h3>
                    <p class="mb-1">Uang Diterima:</p>
                    <h4 class="text-success fw-bold">Rp ${formatRupiah(bayar)}</h4>
                   </div>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Proses Sekarang',
            cancelButtonText: 'Batal',
            background: 'rgba(15, 23, 42, 0.95)',
            color: '#e2e8f0',
            customClass: { popup: 'swal-glassmorphism' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-transaksi').submit();
            }
        });
    }
</script>
@endpush
@endsection