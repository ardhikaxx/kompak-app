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
    <div class="row g-4" style="height: calc(100vh - 200px); min-height: 500px;">
        <!-- Kiri: Pilih Produk -->
        <div class="col-lg-7 h-100">
            <div class="glass-card p-4 h-100 d-flex flex-column">
                <h5 class="text-white mb-4">Pilih Produk</h5>
                
                <div class="input-glass-icon mb-4">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search-produk" class="form-glass" placeholder="Cari nama produk...">
                </div>

                <div class="row g-3 flex-grow-1" id="produk-list" style="overflow-y: auto;">
                    @foreach($produks as $produk)
                    <div class="col-md-4 col-sm-6 produk-item mb-2" data-nama="{{ strtolower($produk->nama_produk) }}">
                        <div class="glass-card-blue p-3 text-center cursor-pointer" style="cursor:pointer; transition:all 0.2s;" onclick="tambahKeKeranjang({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga_jual }}, {{ $produk->stok }})">
                            <i class="fas fa-box fa-2x text-accent mb-2"></i>
                            <h6 class="text-white mb-1" style="font-size:0.85rem;">{{ Str::limit($produk->nama_produk, 20) }}</h6>
                            <div class="text-accent fw-bold small">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</div>
                            <div class="text-white" style="font-size:0.7rem;">Stok: {{ $produk->stok }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Kanan: Keranjang & Pembayaran -->
        <div class="col-lg-5 h-100">
            <div class="glass-card p-4 d-flex flex-column h-100">
                <h5 class="text-white mb-3">Detail Transaksi</h5>
                
                <div class="mb-3">
                    <select name="pelanggan_id" class="form-glass">
                        <option value="">-- Pelanggan Umum --</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama_pelanggan }} ({{ $pelanggan->telepon ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-grow-1 mb-4" style="min-height: 250px; border: 1px solid var(--glass-border); border-radius: var(--radius-md); padding: 1rem;">
                    <div id="keranjang-kosong" class="text-center text-white py-5">
                        <i class="fas fa-shopping-basket fa-3x mb-3"></i>
                        <p>Keranjang masih kosong</p>
                    </div>
                    <table class="table-glass w-100" id="tabel-keranjang" style="display:none;">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th width="30%">Qty</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="keranjang-body">
                            <!-- Items go here -->
                        </tbody>
                    </table>
                </div>

                <!-- Kalkulasi -->
                <div class="p-3 mb-4 rounded" style="background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border);">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-white">Subtotal</span>
                        <span class="text-white fw-bold" id="lbl-subtotal">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 align-items-center">
                        <span class="text-white">Diskon (Rp)</span>
                        <input type="number" name="diskon" id="input-diskon" class="form-glass form-control-sm w-50 text-end" value="0" min="0" oninput="hitungTotal()">
                    </div>
                    <div class="d-flex justify-content-between mb-3 align-items-center">
                        <span class="text-white">Pajak (Rp)</span>
                        <input type="number" name="pajak" id="input-pajak" class="form-glass form-control-sm w-50 text-end" value="0" min="0" oninput="hitungTotal()">
                    </div>
                    <div class="d-flex justify-content-between pt-3 border-top border-secondary">
                        <h5 class="text-white mb-0">Total</h5>
                        <h4 class="text-accent fw-bold mb-0" id="lbl-total">Rp 0</h4>
                    </div>
                </div>

                <!-- Pembayaran -->
                <div class="mb-3">
                    <label class="form-glass-label">Bayar (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="bayar" id="input-bayar" class="form-glass fs-5 text-end @error('bayar') border-danger @enderror" value="{{ old('bayar') }}" required min="0" oninput="hitungKembalian()">
                    @error('bayar') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="d-flex justify-content-between mb-4 align-items-center">
                    <span class="text-white">Kembalian</span>
                    <h5 class="text-success mb-0" id="lbl-kembalian">Rp 0</h5>
                </div>

                <button type="button" class="btn-glass-primary w-100 py-2 fs-6" onclick="prosesTransaksi()">
                    <i class="fas fa-check-circle me-2"></i> Proses Transaksi
                </button>
            </div>
        </div>
    </div>
</form>

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
                    <tr>
                        <td class="text-white small">
                            ${item.nama}
                            <input type="hidden" name="produk_id[]" value="${item.id}">
                            <input type="hidden" name="jumlah[]" value="${item.qty}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                <button type="button" class="btn btn-sm btn-dark px-2 py-0" onclick="ubahQty(${index}, -1)">-</button>
                                <span class="text-white px-2">${item.qty}</span>
                                <button type="button" class="btn btn-sm btn-dark px-2 py-0" onclick="ubahQty(${index}, 1)">+</button>
                            </div>
                        </td>
                        <td class="text-end text-accent small">Rp ${formatRupiah(subtotal)}</td>
                        <td class="text-end">
                            <button type="button" class="btn-glass-icon delete" style="width:24px;height:24px;font-size:0.7rem;" onclick="hapusItem(${index})"><i class="fas fa-times"></i></button>
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
        let pajak = parseInt(document.getElementById('input-pajak').value) || 0;
        
        let total = subtotal - diskon + pajak;
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
            lblKembalian.className = 'text-danger mb-0';
        } else {
            lblKembalian.innerText = 'Rp ' + formatRupiah(kembalian);
            lblKembalian.className = 'text-success mb-0';
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
            title: 'Proses Transaksi?',
            text: 'Pastikan uang diterima sudah sesuai.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Proses',
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