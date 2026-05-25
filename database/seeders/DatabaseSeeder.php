<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\StokLog;
use App\Models\Keuangan;
use App\Models\SpkKriteria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan Data Lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Kategori::truncate();
        Produk::truncate();
        Supplier::truncate();
        Pelanggan::truncate();
        Transaksi::truncate();
        DetailTransaksi::truncate();
        StokLog::truncate();
        Keuangan::truncate();
        SpkKriteria::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Users
        $admin = User::create(['name' => 'Budi Administrator', 'email' => 'admin@kompak.com', 'password' => Hash::make('password123'), 'role' => 'admin', 'is_active' => true]);
        $pemilik = User::create(['name' => 'Ibu Hajah Siti', 'email' => 'pemilik@kompak.com', 'password' => Hash::make('password123'), 'role' => 'pemilik', 'is_active' => true]);
        $kasir1 = User::create(['name' => 'Agus Kasir', 'email' => 'kasir@kompak.com', 'password' => Hash::make('password123'), 'role' => 'kasir', 'is_active' => true]);
        $kasir2 = User::create(['name' => 'Sari Pegawai', 'email' => 'sari@kompak.com', 'password' => Hash::make('password123'), 'role' => 'kasir', 'is_active' => true]);

        // 3. Kategori
        $kats = [
            'Sembako' => 'Kebutuhan pokok pangan',
            'Minuman' => 'Aneka minuman segar',
            'Makanan Ringan' => 'Snack dan camilan',
            'Perawatan Tubuh' => 'Sabun, sampo, dll',
            'Kebutuhan Rumah' => 'Pembersih lantai, deterjen',
            'Alat Tulis' => 'Pena, buku, kertas',
            'Obat-obatan' => 'Obat umum dan vitamin',
            'Bumbu Dapur' => 'Garam, gula, lada, micin'
        ];
        $katModels = [];
        foreach ($kats as $nama => $desc) {
            $katModels[$nama] = Kategori::create(['nama_kategori' => $nama, 'deskripsi' => $desc]);
        }

        // 4. Produk (30+ Produk)
        $produkData = [
            ['kat' => 'Sembako', 'kd' => 'BRS-5', 'nm' => 'Beras Rojolele 5kg', 'hb' => 65000, 'hj' => 75000, 'st' => 30, 'sm' => 5, 'sat' => 'Karung'],
            ['kat' => 'Sembako', 'kd' => 'MYK-2L', 'nm' => 'Minyak Bimoli 2L', 'hb' => 32000, 'hj' => 38000, 'st' => 20, 'sm' => 4, 'sat' => 'Pouch'],
            ['kat' => 'Sembako', 'kd' => 'GLA-1', 'nm' => 'Gula Pasir Gulaku 1kg', 'hb' => 14000, 'hj' => 17000, 'st' => 50, 'sm' => 10, 'sat' => 'Bks'],
            ['kat' => 'Sembako', 'kd' => 'TLR-1', 'nm' => 'Telur Ayam 1kg', 'hb' => 24000, 'hj' => 28000, 'st' => 100, 'sm' => 15, 'sat' => 'Kg'],
            
            ['kat' => 'Minuman', 'kd' => 'AQ-600', 'nm' => 'Aqua 600ml', 'hb' => 2800, 'hj' => 4500, 'st' => 120, 'sm' => 24, 'sat' => 'Botol'],
            ['kat' => 'Minuman', 'kd' => 'TP-350', 'nm' => 'Teh Pucuk 350ml', 'hb' => 2500, 'hj' => 4000, 'st' => 48, 'sm' => 12, 'sat' => 'Botol'],
            ['kat' => 'Minuman', 'kd' => 'CC-250', 'nm' => 'Coca Cola 250ml', 'hb' => 4500, 'hj' => 6000, 'st' => 24, 'sm' => 6, 'sat' => 'Kaleng'],
            ['kat' => 'Minuman', 'kd' => 'SDA-1', 'nm' => 'Susu Beruang (Bear Brand)', 'hb' => 9000, 'hj' => 11500, 'st' => 36, 'sm' => 12, 'sat' => 'Kaleng'],

            ['kat' => 'Makanan Ringan', 'kd' => 'CHT-68', 'nm' => 'Chitato 68g', 'hb' => 9000, 'hj' => 12500, 'st' => 20, 'sm' => 5, 'sat' => 'Bks'],
            ['kat' => 'Makanan Ringan', 'kd' => 'OR-137', 'nm' => 'Oreo 137g', 'hb' => 7500, 'hj' => 10000, 'st' => 15, 'sm' => 5, 'sat' => 'Bks'],
            ['kat' => 'Makanan Ringan', 'kd' => 'GR-S', 'nm' => 'Garuda Kacang Atom', 'hb' => 6000, 'hj' => 8500, 'st' => 30, 'sm' => 5, 'sat' => 'Bks'],
            ['kat' => 'Makanan Ringan', 'kd' => 'QT-L', 'nm' => 'Qtela Singkong 185g', 'hb' => 12000, 'hj' => 15000, 'st' => 12, 'sm' => 4, 'sat' => 'Bks'],

            ['kat' => 'Perawatan Tubuh', 'kd' => 'LB-M', 'nm' => 'Lifebuoy Merah 110g', 'hb' => 3800, 'hj' => 5500, 'st' => 48, 'sm' => 12, 'sat' => 'Pcs'],
            ['kat' => 'Perawatan Tubuh', 'kd' => 'CL-S', 'nm' => 'Clear Sampo 160ml', 'hb' => 22000, 'hj' => 28000, 'st' => 10, 'sm' => 3, 'sat' => 'Botol'],
            ['kat' => 'Perawatan Tubuh', 'kd' => 'PS-190', 'nm' => 'Pepsodent 190g', 'hb' => 11000, 'hj' => 14500, 'st' => 20, 'sm' => 5, 'sat' => 'Pcs'],
            ['kat' => 'Perawatan Tubuh', 'kd' => 'RX-W', 'nm' => 'Rexona Men Roll-On', 'hb' => 16500, 'hj' => 21000, 'st' => 8, 'sm' => 2, 'sat' => 'Pcs'],

            ['kat' => 'Kebutuhan Rumah', 'kd' => 'RN-800', 'nm' => 'Rinso Molto 800g', 'hb' => 24000, 'hj' => 29000, 'st' => 15, 'sm' => 5, 'sat' => 'Bks'],
            ['kat' => 'Kebutuhan Rumah', 'kd' => 'SL-755', 'nm' => 'Sunlight Jeruk Nipis', 'hb' => 13500, 'hj' => 17000, 'st' => 20, 'sm' => 5, 'sat' => 'Pouch'],
            ['kat' => 'Kebutuhan Rumah', 'kd' => 'WP-750', 'nm' => 'Wipol Karbol 750ml', 'hb' => 15000, 'hj' => 19000, 'st' => 10, 'sm' => 3, 'sat' => 'Pouch'],

            ['kat' => 'Alat Tulis', 'kd' => 'SN-01', 'nm' => 'Pulpen Snowman Black', 'hb' => 2500, 'hj' => 4000, 'st' => 50, 'sm' => 12, 'sat' => 'Pcs'],
            ['kat' => 'Alat Tulis', 'kd' => 'SK-A4', 'nm' => 'Kertas A4 Sinar Dunia', 'hb' => 48000, 'hj' => 55000, 'st' => 5, 'sm' => 2, 'sat' => 'Rim'],
            ['kat' => 'Alat Tulis', 'kd' => 'BK-Q', 'nm' => 'Buku Tulis Kiky 38lbr', 'hb' => 3500, 'hj' => 5500, 'st' => 40, 'sm' => 10, 'sat' => 'Pcs'],

            ['kat' => 'Obat-obatan', 'kd' => 'PN-500', 'nm' => 'Panadol Biru 10s', 'hb' => 9500, 'hj' => 12000, 'st' => 20, 'sm' => 5, 'sat' => 'Strip'],
            ['kat' => 'Obat-obatan', 'kd' => 'TLG-A', 'nm' => 'Tolak Angin Cair', 'hb' => 3200, 'hj' => 4500, 'st' => 60, 'sm' => 12, 'sat' => 'Sachet'],
            ['kat' => 'Obat-obatan', 'kd' => 'HPS-5', 'nm' => 'Hansaplast Plester 10s', 'hb' => 5500, 'hj' => 8000, 'st' => 15, 'sm' => 5, 'sat' => 'Box'],

            ['kat' => 'Bumbu Dapur', 'kd' => 'G-R', 'nm' => 'Garam Cap Kapal 250g', 'hb' => 2000, 'hj' => 3500, 'st' => 40, 'sm' => 10, 'sat' => 'Bks'],
            ['kat' => 'Bumbu Dapur', 'kd' => 'K-B', 'nm' => 'Kecap Bango 550ml', 'hb' => 22000, 'hj' => 26000, 'st' => 12, 'sm' => 4, 'sat' => 'Pouch'],
            ['kat' => 'Bumbu Dapur', 'kd' => 'S-T', 'nm' => 'Sasa Santan Kelapa', 'hb' => 2800, 'hj' => 4000, 'st' => 48, 'sm' => 12, 'sat' => 'Pcs'],
            ['kat' => 'Bumbu Dapur', 'kd' => 'AJI-S', 'nm' => 'Ajinomoto 100g', 'hb' => 4500, 'hj' => 6000, 'st' => 30, 'sm' => 10, 'sat' => 'Bks'],
        ];

        $produkModels = [];
        foreach ($produkData as $p) {
            $item = Produk::create([
                'kategori_id' => $katModels[$p['kat']]->id,
                'kode_produk' => $p['kd'],
                'nama_produk' => $p['nm'],
                'harga_beli' => $p['hb'],
                'harga_jual' => $p['hj'],
                'stok' => $p['st'],
                'stok_minimum' => $p['sm'],
                'satuan' => $p['sat'],
                'is_active' => true,
            ]);
            $produkModels[] = $item;
            
            StokLog::create([
                'produk_id' => $item->id,
                'jenis' => 'masuk',
                'jumlah' => $p['st'],
                'stok_sebelum' => 0,
                'stok_sesudah' => $p['st'],
                'keterangan' => 'Stok awal sistem (Demo)',
                'user_id' => $admin->id
            ]);
        }

        // 5. Suppliers (7 Supplier)
        $suppliers = [
            ['nm' => 'PT Indomarco Adi Prima', 'kd' => 'SUP-001', 'pic' => 'Bapak Joko', 'tlp' => '021-55667788', 'alm' => 'Jababeka, Bekasi', 'h' => 85, 'k' => 90, 'p' => 80, 's' => 95],
            ['nm' => 'Grosir Sumber Makmur', 'kd' => 'SUP-002', 'pic' => 'Ibu Lani', 'tlp' => '081299001122', 'alm' => 'Pasar Induk Kramat Jati', 'h' => 95, 'k' => 75, 'p' => 85, 's' => 70],
            ['nm' => 'Distributor Wings Sayap', 'kd' => 'SUP-003', 'pic' => 'Bapak Hendra', 'tlp' => '021-88776655', 'alm' => 'Cakung, Jakarta Utara', 'h' => 88, 'k' => 85, 'p' => 90, 's' => 88],
            ['nm' => 'Cahaya ATK Grosir', 'kd' => 'SUP-004', 'pic' => 'Ibu Maya', 'tlp' => '087811223344', 'alm' => 'Mangga Dua, Jakarta', 'h' => 92, 'k' => 80, 'p' => 70, 's' => 75],
            ['nm' => 'Agen Sembako Berkah', 'kd' => 'SUP-005', 'pic' => 'Haji Mansur', 'tlp' => '081344556677', 'alm' => 'Tanah Abang, Jakarta', 'h' => 98, 'k' => 70, 'p' => 75, 's' => 60],
            ['nm' => 'PT Unilever Indonesia Tbk', 'kd' => 'SUP-006', 'pic' => 'Bapak Kevin', 'tlp' => '021-33221100', 'alm' => 'BSD City, Tangerang', 'h' => 75, 'k' => 98, 'p' => 95, 's' => 98],
            ['nm' => 'Grosir Plastik Maju', 'kd' => 'SUP-007', 'pic' => 'Bapak Adi', 'tlp' => '085212345678', 'alm' => 'Senen, Jakarta Pusat', 'h' => 90, 'k' => 82, 'p' => 88, 's' => 80],
        ];

        foreach ($suppliers as $s) {
            Supplier::create([
                'nama_supplier' => $s['nm'], 'kode_supplier' => $s['kd'], 'pic_nama' => $s['pic'], 'telepon' => $s['tlp'], 'alamat' => $s['alm'],
                'kriteria_harga' => $s['h'], 'kriteria_kualitas' => $s['k'], 'kriteria_pengiriman' => $s['p'], 'kriteria_konsistensi' => $s['s']
            ]);
        }

        // 6. Pelanggan (15 Pelanggan)
        $namaPelanggan = ['Andi Wijaya', 'Budi Santoso', 'Cici Lestari', 'Dedi Kurniawan', 'Eka Saputra', 'Fanny Amelia', 'Gani Ramadhan', 'Hani Fitria', 'Iwan Setiawan', 'Julia Putri', 'Kevin Sanjaya', 'Lina Marlina', 'Maman Suherman', 'Nina Zatulini', 'Oscar Lawalata'];
        $pelangganModels = [];
        foreach ($namaPelanggan as $idx => $name) {
            $pelangganModels[] = Pelanggan::create([
                'nama_pelanggan' => $name,
                'kode_pelanggan' => 'PLG-' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT),
                'telepon' => '081' . rand(10000000, 99999999),
                'alamat' => 'Alamat Pelanggan Ke-' . ($idx + 1),
                'total_transaksi' => 0
            ]);
        }

        // 7. Transaksi & Detail (Simulasi 30 hari terakhir, rata-rata 3-5 transaksi per hari)
        for ($day = 30; $day >= 0; $day--) {
            $numTrx = rand(2, 5);
            for ($t = 1; $t <= $numTrx; $t++) {
                $date = Carbon::today()->subDays($day)->addHours(rand(8, 21))->addMinutes(rand(0, 59));
                $pelanggan = (rand(0, 10) > 3) ? $pelangganModels[array_rand($pelangganModels)] : null;
                $user = (rand(0, 1) == 0) ? $kasir1 : $kasir2;

                // Pilih 1-4 produk acak
                $numItems = rand(1, 4);
                $selectedItems = array_rand($produkModels, $numItems);
                if (!is_array($selectedItems)) $selectedItems = [$selectedItems];

                $subtotal = 0;
                $lineItems = [];

                foreach ($selectedItems as $pIdx) {
                    $prod = $produkModels[$pIdx];
                    $qty = rand(1, 5);
                    $lineTotal = $prod->harga_jual * $qty;
                    $subtotal += $lineTotal;
                    $lineItems[] = ['id' => $prod->id, 'hj' => $prod->harga_jual, 'q' => $qty, 'st' => $lineTotal];
                }

                $diskon = (rand(0, 10) > 8) ? (floor($subtotal * 0.05 / 100) * 100) : 0;
                $total = $subtotal - $diskon;
                $bayar = ceil($total / 5000) * 5000;
                if ($bayar < $total) $bayar += 5000;

                $trx = Transaksi::create([
                    'kode_transaksi' => 'TRX-' . $date->format('Ymd') . '-' . str_pad($t, 3, '0', STR_PAD_LEFT),
                    'pelanggan_id' => $pelanggan ? $pelanggan->id : null,
                    'user_id' => $user->id,
                    'tanggal' => $date,
                    'subtotal' => $subtotal,
                    'diskon' => $diskon,
                    'total' => $total,
                    'bayar' => $bayar,
                    'kembalian' => $bayar - $total,
                    'metode_bayar' => (rand(0, 5) > 2) ? 'Tunai' : 'QRIS',
                    'status' => 'selesai'
                ]);

                foreach ($lineItems as $li) {
                    DetailTransaksi::create([
                        'transaksi_id' => $trx->id,
                        'produk_id' => $li['id'],
                        'harga_satuan' => $li['hj'],
                        'jumlah' => $li['q'],
                        'subtotal' => $li['st']
                    ]);
                    // Jangan kurangi stok di seeder agar stok awal tetap terjaga untuk demo tampilan
                }

                if ($pelanggan) $pelanggan->increment('total_transaksi', $total);

                Keuangan::create(['jenis' => 'masuk', 'kategori' => 'Penjualan', 'jumlah' => $total, 'tanggal' => $date, 'keterangan' => 'Retail ' . $trx->kode_transaksi, 'user_id' => $user->id]);
            }
        }

        // 8. Keuangan Pengeluaran (Gaji, Listrik, Sewa)
        $bulanLalu = Carbon::now()->subMonth();
        Keuangan::create(['jenis' => 'keluar', 'kategori' => 'Sewa', 'jumlah' => 2000000, 'tanggal' => $bulanLalu->startOfMonth(), 'keterangan' => 'Sewa ruko bulan ini', 'user_id' => $admin->id]);
        Keuangan::create(['jenis' => 'keluar', 'kategori' => 'Gaji', 'jumlah' => 1500000, 'tanggal' => $bulanLalu->endOfMonth(), 'keterangan' => 'Gaji Agus Kasir', 'user_id' => $admin->id]);
        Keuangan::create(['jenis' => 'keluar', 'kategori' => 'Gaji', 'jumlah' => 1500000, 'tanggal' => $bulanLalu->endOfMonth(), 'keterangan' => 'Gaji Sari Pegawai', 'user_id' => $admin->id]);
        Keuangan::create(['jenis' => 'keluar', 'kategori' => 'Operasional', 'jumlah' => 450000, 'tanggal' => Carbon::today()->subDays(10), 'keterangan' => 'Bayar tagihan listrik & air', 'user_id' => $admin->id]);

        // 9. SPK Kriteria (Real-weight)
        SpkKriteria::insert([
            ['nama_kriteria' => 'Harga', 'bobot' => 0.35, 'tipe' => 'min', 'fungsi_preferensi' => 'linear', 'p_parameter' => 20, 'q_parameter' => 5],
            ['nama_kriteria' => 'Kualitas', 'bobot' => 0.30, 'tipe' => 'max', 'fungsi_preferensi' => 'usual', 'p_parameter' => null, 'q_parameter' => null],
            ['nama_kriteria' => 'Pengiriman', 'bobot' => 0.20, 'tipe' => 'max', 'fungsi_preferensi' => 'v-shape', 'p_parameter' => 15, 'q_parameter' => null],
            ['nama_kriteria' => 'Konsistensi', 'bobot' => 0.15, 'tipe' => 'max', 'fungsi_preferensi' => 'usual', 'p_parameter' => null, 'q_parameter' => null],
        ]);
    }
}