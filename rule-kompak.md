# 📋 RULE-KOMPAK.md
## Aturan Pengembangan Sistem KOMPAK
### Kontrol Operasional Manajemen Penjualan dan Analisis Keputusan

---

## 1. IDENTITAS SISTEM

| Atribut | Keterangan |
|---|---|
| **Nama Sistem** | KOMPAK |
| **Kepanjangan** | Kontrol Operasional Manajemen Penjualan dan Analisis Keputusan |
| **Jenis** | Sistem Informasi Operasional UMKM Berbasis Web |
| **Framework** | Laravel 12 |
| **UI Framework** | Bootstrap (CDN) |
| **Icon Library** | Font Awesome (CDN) |
| **Alert Library** | SweetAlert2 (CDN) |
| **Design Style** | Glassmorphism Dark Theme |

---

## 2. TECH STACK & DEPENDENCY

### 2.1 Backend
```
- Framework  : Laravel 12
- PHP        : >= 8.2
- Database   : MySQL / MariaDB
- ORM        : Eloquent
- Auth       : Laravel Breeze / Custom Session Auth
- Migration  : Laravel Migrations
- Seeder     : Laravel Seeders
```

### 2.2 Frontend (CDN Only)
```html
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Chart.js (untuk grafik dashboard) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
```

---

## 3. STRUKTUR FOLDER LARAVEL

```
kompak/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ProdukController.php
│   │   │   ├── KategoriController.php
│   │   │   ├── StokController.php
│   │   │   ├── SupplierController.php
│   │   │   ├── PelangganController.php
│   │   │   ├── TransaksiController.php
│   │   │   ├── KeuanganController.php
│   │   │   ├── LaporanController.php
│   │   │   ├── PenggunaController.php
│   │   │   └── SpkController.php
│   │   ├── Middleware/
│   │   │   ├── RoleMiddleware.php
│   │   │   └── AuthMiddleware.php
│   │   └── Requests/
│   │       ├── ProdukRequest.php
│   │       ├── TransaksiRequest.php
│   │       └── SpkRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Produk.php
│   │   ├── Kategori.php
│   │   ├── Stok.php
│   │   ├── Supplier.php
│   │   ├── Pelanggan.php
│   │   ├── Transaksi.php
│   │   ├── DetailTransaksi.php
│   │   ├── Keuangan.php
│   │   └── SpkKriteria.php
│   └── Services/
│       └── PrometheeService.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php       ← layout utama
│       │   ├── sidebar.blade.php
│       │   └── navbar.blade.php
│       ├── auth/
│       │   └── login.blade.php
│       ├── dashboard/
│       │   └── index.blade.php
│       ├── produk/
│       ├── kategori/
│       ├── stok/
│       ├── supplier/
│       ├── pelanggan/
│       ├── transaksi/
│       ├── keuangan/
│       ├── laporan/
│       ├── pengguna/
│       └── spk/
└── routes/
    └── web.php
```

---

## 4. ROLE & HAK AKSES

### 4.1 Definisi Role
```
Role ID 1 : Admin
Role ID 2 : Pemilik UMKM
Role ID 3 : Kasir / Pegawai
```

### 4.2 Matriks Hak Akses

| Menu / Fitur | Admin | Pemilik | Kasir |
|---|:---:|:---:|:---:|
| Dashboard | ✅ Full | ✅ Full | ✅ Terbatas |
| Manajemen Produk | ✅ CRUD | 👁️ View | 👁️ View |
| Kategori Produk | ✅ CRUD | 👁️ View | ❌ |
| Manajemen Stok | ✅ CRUD | 👁️ View | ✅ Update |
| Supplier | ✅ CRUD | 👁️ View | ❌ |
| Pelanggan | ✅ CRUD | 👁️ View | ✅ CRUD |
| Transaksi Penjualan | ✅ CRUD | 👁️ View | ✅ Create |
| Keuangan (Arus Kas) | ✅ CRUD | 👁️ View | ❌ |
| Laporan Penjualan | ✅ | ✅ | ❌ |
| Laporan Stok | ✅ | ✅ | ❌ |
| Laporan Keuangan | ✅ | ✅ | ❌ |
| SPK PROMETHEE | ✅ | ✅ | ❌ |
| Manajemen Pengguna | ✅ CRUD | ❌ | ❌ |
| Pengaturan Sistem | ✅ | ❌ | ❌ |

### 4.3 Implementasi Middleware
```php
// RoleMiddleware.php
public function handle(Request $request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    if (!in_array(auth()->user()->role, $roles)) {
        abort(403, 'Akses Ditolak');
    }
    
    return $next($request);
}

// Penggunaan di routes/web.php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('pengguna', PenggunaController::class);
});
```

---

## 5. ATURAN DATABASE

### 5.1 Konvensi Penamaan
```
- Nama tabel    : snake_case, plural (produk, detail_transaksi)
- Nama kolom    : snake_case (nama_produk, harga_beli)
- Primary key   : id (auto increment)
- Foreign key   : {tabel}_id (produk_id, supplier_id)
- Timestamps    : created_at, updated_at (wajib semua tabel)
- Soft delete   : deleted_at (opsional, untuk data penting)
```

### 5.2 Skema Tabel Utama

```sql
-- users
id, nama, email, password, role (enum: admin, pemilik, kasir),
foto, is_active, created_at, updated_at

-- kategoris
id, nama_kategori, deskripsi, created_at, updated_at

-- produks
id, kategori_id, kode_produk, nama_produk, deskripsi,
harga_beli, harga_jual, stok, stok_minimum, satuan,
foto, is_active, created_at, updated_at

-- stok_logs
id, produk_id, jenis (masuk|keluar), jumlah,
stok_sebelum, stok_sesudah, keterangan, user_id, created_at

-- suppliers
id, nama_supplier, kode_supplier, alamat, telepon,
email, pic_nama, kriteria_harga, kriteria_kualitas,
kriteria_pengiriman, kriteria_konsistensi, created_at, updated_at

-- pelanggans
id, nama_pelanggan, kode_pelanggan, telepon, alamat,
email, total_transaksi, created_at, updated_at

-- transaksis
id, kode_transaksi, pelanggan_id, user_id (kasir),
tanggal, subtotal, diskon, pajak, total, 
metode_bayar, bayar, kembalian, status, created_at, updated_at

-- detail_transaksis
id, transaksi_id, produk_id, harga_satuan, jumlah,
diskon_item, subtotal, created_at, updated_at

-- keuangans
id, jenis (masuk|keluar), kategori, jumlah, keterangan,
tanggal, bukti, user_id, created_at, updated_at

-- spk_kriterias
id, nama_kriteria, bobot, tipe (max|min), fungsi_preferensi,
p_parameter, q_parameter, created_at, updated_at
```

---

## 6. ATURAN ROUTING

### 6.1 Konvensi URL
```
/login                          → Halaman login
/logout                         → Logout
/dashboard                      → Dashboard utama

/produk                         → List produk
/produk/create                  → Form tambah produk
/produk/{id}                    → Detail produk
/produk/{id}/edit               → Form edit produk

/transaksi                      → List transaksi
/transaksi/create               → Form POS transaksi baru
/transaksi/{id}                 → Detail / nota transaksi

/spk                            → Halaman SPK PROMETHEE
/spk/kriteria                   → Kelola kriteria
/spk/hitung                     → Proses perhitungan
/spk/hasil                      → Hasil ranking

/laporan/penjualan              → Laporan penjualan
/laporan/stok                   → Laporan stok
/laporan/keuangan               → Laporan keuangan
```

### 6.2 Naming Convention Routes
```php
Route::resource('produk', ProdukController::class);
// Menghasilkan: produk.index, produk.create, produk.store,
//               produk.show, produk.edit, produk.update, produk.destroy
```

---

## 7. ATURAN SWEETALERT2

### 7.1 Wajib Digunakan Pada
Semua aksi berikut **WAJIB** menggunakan SweetAlert2:
- ✅ Konfirmasi hapus data
- ✅ Konfirmasi logout
- ✅ Notifikasi sukses (create, update, delete)
- ✅ Notifikasi error / validasi gagal
- ✅ Notifikasi warning (stok minimum, dsb)
- ✅ Konfirmasi proses transaksi
- ✅ Alert hasil SPK

### 7.2 Template SweetAlert Standard

```javascript
// ── KONFIRMASI HAPUS ──────────────────────────────────
function konfirmasiHapus(formId) {
    Swal.fire({
        title: 'Hapus Data?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
        background: 'rgba(15, 23, 42, 0.95)',
        color: '#e2e8f0',
        backdrop: 'rgba(0,0,0,0.6)',
        customClass: {
            popup: 'swal-glassmorphism'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}

// ── NOTIFIKASI SUKSES ─────────────────────────────────
function alertSukses(pesan) {
    Swal.fire({
        title: 'Berhasil!',
        text: pesan,
        icon: 'success',
        timer: 2500,
        timerProgressBar: true,
        showConfirmButton: false,
        background: 'rgba(15, 23, 42, 0.95)',
        color: '#e2e8f0',
        iconColor: '#22c55e',
        customClass: { popup: 'swal-glassmorphism' }
    });
}

// ── NOTIFIKASI ERROR ──────────────────────────────────
function alertError(pesan) {
    Swal.fire({
        title: 'Gagal!',
        text: pesan,
        icon: 'error',
        confirmButtonColor: '#3b82f6',
        background: 'rgba(15, 23, 42, 0.95)',
        color: '#e2e8f0',
        customClass: { popup: 'swal-glassmorphism' }
    });
}

// ── NOTIFIKASI WARNING ────────────────────────────────
function alertWarning(pesan) {
    Swal.fire({
        title: 'Perhatian!',
        text: pesan,
        icon: 'warning',
        confirmButtonColor: '#f59e0b',
        background: 'rgba(15, 23, 42, 0.95)',
        color: '#e2e8f0',
        customClass: { popup: 'swal-glassmorphism' }
    });
}

// ── KONFIRMASI LOGOUT ─────────────────────────────────
function konfirmasiLogout() {
    Swal.fire({
        title: 'Keluar dari KOMPAK?',
        text: 'Sesi Anda akan diakhiri.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-sign-out-alt me-1"></i> Ya, Keluar',
        cancelButtonText: 'Batal',
        background: 'rgba(15, 23, 42, 0.95)',
        color: '#e2e8f0',
        customClass: { popup: 'swal-glassmorphism' }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-logout').submit();
        }
    });
}
```

### 7.3 Flash Message dari Laravel ke SweetAlert
```blade
{{-- Di layout app.blade.php, setelah CDN SweetAlert --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            icon: 'success',
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false,
            background: 'rgba(15, 23, 42, 0.95)',
            color: '#e2e8f0',
            iconColor: '#22c55e',
            customClass: { popup: 'swal-glassmorphism' }
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session("error") }}',
            icon: 'error',
            confirmButtonColor: '#3b82f6',
            background: 'rgba(15, 23, 42, 0.95)',
            color: '#e2e8f0',
            customClass: { popup: 'swal-glassmorphism' }
        });
    });
</script>
@endif

@if(session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Perhatian!',
            text: '{{ session("warning") }}',
            icon: 'warning',
            confirmButtonColor: '#f59e0b',
            background: 'rgba(15, 23, 42, 0.95)',
            color: '#e2e8f0',
            customClass: { popup: 'swal-glassmorphism' }
        });
    });
</script>
@endif
```

---

## 8. ATURAN SPK PROMETHEE

### 8.1 Alur Perhitungan PROMETHEE II
```
1. Input Alternatif     → Data supplier / produk
2. Input Kriteria       → Bobot + Tipe (max/min) + Fungsi Preferensi
3. Hitung Deviasi       → d(a,b) = f(a) - f(b)
4. Fungsi Preferensi    → P(a,b) berdasarkan jenis fungsi (usual, linear, level, dsb)
5. Indeks Preferensi    → π(a,b) = Σ [wj × Pj(a,b)]
6. Leaving Flow         → Φ⁺(a) = 1/(n-1) × Σ π(a,x)
7. Entering Flow        → Φ⁻(a) = 1/(n-1) × Σ π(x,a)
8. Net Flow             → Φ(a) = Φ⁺(a) - Φ⁻(a)
9. Ranking              → Urutkan berdasarkan Φ(a) tertinggi
```

### 8.2 Fungsi Preferensi yang Didukung
```
Type I   : Usual         → P = 0 jika d≤0, P = 1 jika d>0
Type II  : U-Shape       → Gunakan threshold q
Type III : V-Shape       → Gunakan threshold p (linear)
Type IV  : Level         → Gunakan threshold q dan p
Type V   : Linear        → Gunakan threshold q dan p
Type VI  : Gaussian      → Gunakan parameter s
```

### 8.3 PrometheeService.php Skeleton
```php
namespace App\Services;

class PrometheeService
{
    public function hitung(array $alternatif, array $kriteria): array
    {
        $n = count($alternatif);
        $pi = [];  // indeks preferensi
        
        // 1. Hitung deviasi & preferensi untuk setiap pasang
        foreach ($alternatif as $i => $a) {
            foreach ($alternatif as $j => $b) {
                if ($i === $j) continue;
                $pi[$i][$j] = $this->hitungIndeksPreferensi($a, $b, $kriteria);
            }
        }
        
        // 2. Hitung leaving, entering, net flow
        $hasil = [];
        foreach ($alternatif as $i => $a) {
            $leaving  = array_sum($pi[$i]) / ($n - 1);
            $entering = 0;
            foreach ($alternatif as $j => $b) {
                if ($i === $j) continue;
                $entering += $pi[$j][$i] ?? 0;
            }
            $entering /= ($n - 1);
            $hasil[$i] = [
                'alternatif' => $a,
                'leaving'    => $leaving,
                'entering'   => $entering,
                'net_flow'   => $leaving - $entering,
            ];
        }
        
        // 3. Sort berdasarkan net flow descending
        usort($hasil, fn($x, $y) => $y['net_flow'] <=> $x['net_flow']);
        
        return $hasil;
    }
    
    private function hitungIndeksPreferensi($a, $b, $kriteria): float { ... }
    private function fungsiPreferensi(float $d, array $k): float { ... }
}
```

---

## 9. ATURAN VALIDASI

### 9.1 Form Request Laravel
Semua form **WAJIB** menggunakan Form Request class terpisah.

```php
// ProdukRequest.php
public function rules(): array
{
    return [
        'nama_produk'  => 'required|string|max:100',
        'kategori_id'  => 'required|exists:kategoris,id',
        'harga_beli'   => 'required|numeric|min:0',
        'harga_jual'   => 'required|numeric|gte:harga_beli',
        'stok'         => 'required|integer|min:0',
        'stok_minimum' => 'required|integer|min:1',
    ];
}

public function messages(): array
{
    return [
        'harga_jual.gte' => 'Harga jual tidak boleh lebih kecil dari harga beli.',
    ];
}
```

### 9.2 Tampilkan Error Validasi
```blade
@if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Validasi Gagal!',
                html: `<ul class="text-start">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>`,
                icon: 'error',
                confirmButtonColor: '#3b82f6',
                background: 'rgba(15, 23, 42, 0.95)',
                color: '#e2e8f0',
                customClass: { popup: 'swal-glassmorphism' }
            });
        });
    </script>
@endif
```

---

## 10. ATURAN CONTROLLER

### 10.1 Pola Standar Controller
```php
public function store(ProdukRequest $request)
{
    try {
        Produk::create($request->validated());
        return redirect()->route('produk.index')
                         ->with('success', 'Produk berhasil ditambahkan.');
    } catch (\Exception $e) {
        return redirect()->back()
                         ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                         ->withInput();
    }
}

public function destroy(Produk $produk)
{
    try {
        $produk->delete();
        return redirect()->route('produk.index')
                         ->with('success', 'Produk berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->route('produk.index')
                         ->with('error', 'Data tidak dapat dihapus.');
    }
}
```

---

## 11. ATURAN STOK

```
ATURAN OTOMATIS:
1. Setiap transaksi penjualan WAJIB mengurangi stok produk secara otomatis.
2. Setiap pengurangan / penambahan stok WAJIB dicatat di tabel stok_logs.
3. Jika stok produk ≤ stok_minimum → tampilkan badge "Stok Rendah" (warning).
4. Jika stok produk = 0 → tampilkan badge "Habis" (danger) & blokir di transaksi.
5. Update stok menggunakan DB transaction untuk menghindari race condition.
```

```php
// Contoh pengurangan stok saat transaksi
DB::transaction(function() use ($detail) {
    $produk = Produk::lockForUpdate()->find($detail['produk_id']);
    
    if ($produk->stok < $detail['jumlah']) {
        throw new \Exception("Stok {$produk->nama_produk} tidak mencukupi.");
    }
    
    $stokSebelum = $produk->stok;
    $produk->decrement('stok', $detail['jumlah']);
    
    StokLog::create([
        'produk_id'     => $produk->id,
        'jenis'         => 'keluar',
        'jumlah'        => $detail['jumlah'],
        'stok_sebelum'  => $stokSebelum,
        'stok_sesudah'  => $produk->stok,
        'keterangan'    => 'Transaksi penjualan',
        'user_id'       => auth()->id(),
    ]);
});
```

---

## 12. ATURAN LAPORAN

```
- Semua laporan mendukung filter: periode (harian, mingguan, bulanan, custom)
- Laporan bisa diekspor ke: PDF (menggunakan DomPDF / Barryvdh)
- Laporan penjualan menampilkan: total transaksi, total pendapatan, produk terlaris
- Laporan stok menampilkan: stok masuk, stok keluar, saldo stok, produk low-stock
- Laporan keuangan menampilkan: total pemasukan, total pengeluaran, saldo bersih
```

---

## 13. ATURAN KEAMANAN

```
1. Semua route selain login WAJIB menggunakan middleware auth.
2. Setiap aksi sesuai role menggunakan middleware role.
3. Password WAJIB di-hash menggunakan bcrypt (Hash::make).
4. Form WAJIB menyertakan @csrf token.
5. Input user WAJIB di-sanitasi / di-validasi sebelum disimpan.
6. Jangan tampilkan pesan error detail di production.
7. Gunakan .env untuk semua konfigurasi sensitif.
```

---

## 14. KONVENSI KODE

```php
// Gunakan bahasa Indonesia untuk:
// - Nama variabel yang berhubungan dengan domain bisnis
// - Pesan error/success
// - Komentar kode

// Gunakan bahasa Inggris untuk:
// - Nama method standar Laravel (store, index, update, destroy)
// - Variabel teknis umum ($data, $query, $result)

// Contoh penamaan yang baik:
$totalPendapatan = Transaksi::where(...)->sum('total');
$produkLaris = Produk::withCount('detailTransaksi')->...;
$stokRendah = Produk::where('stok', '<=', DB::raw('stok_minimum'))->get();
```

---

*Rule KOMPAK v1.0 — Laravel 12 | Bootstrap CDN | Font Awesome CDN | SweetAlert2 CDN*
