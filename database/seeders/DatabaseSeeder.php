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
        $admin = User::create([
            'name' => 'Budi Administrator',
            'email' => 'admin@kompak.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $pemilik = User::create([
            'name' => 'Ibu Hajah Siti',
            'email' => 'pemilik@kompak.com',
            'password' => Hash::make('password123'),
            'role' => 'pemilik',
            'is_active' => true,
        ]);

        $kasir = User::create([
            'name' => 'Agus Kasir',
            'email' => 'kasir@kompak.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
            'is_active' => true,
        ]);

        // 3. Kategori
        $katSembako = Kategori::create(['nama_kategori' => 'Sembako', 'deskripsi' => 'Kebutuhan pokok sehari-hari']);
        $katMinuman = Kategori::create(['nama_kategori' => 'Minuman', 'deskripsi' => 'Minuman kemasan dan sachet']);
        $katSnack = Kategori::create(['nama_kategori' => 'Makanan Ringan', 'deskripsi' => 'Camilan dan snack anak']);
        $katSabun = Kategori::create(['nama_kategori' => 'Perawatan Tubuh', 'deskripsi' => 'Sabun, sampo, dan odol']);

        // 4. Produk
        $produks = [
            ['kategori_id' => $katSembako->id, 'kode_produk' => 'Beras-01', 'nama_produk' => 'Beras Rojolele 5kg', 'harga_beli' => 65000, 'harga_jual' => 75000, 'stok' => 20, 'stok_minimum' => 5, 'satuan' => 'Karung'],
            ['kategori_id' => $katSembako->id, 'kode_produk' => 'Minyak-01', 'nama_produk' => 'Minyak Goreng Bimoli 2L', 'harga_beli' => 32000, 'harga_jual' => 38000, 'stok' => 15, 'stok_minimum' => 4, 'satuan' => 'Pouch'],
            ['kategori_id' => $katMinuman->id, 'kode_produk' => 'Aqua-600', 'nama_produk' => 'Aqua Botol 600ml', 'harga_beli' => 3000, 'harga_jual' => 5000, 'stok' => 48, 'stok_minimum' => 12, 'satuan' => 'Botol'],
            ['kategori_id' => $katMinuman->id, 'kode_produk' => 'Teh-Pucuk', 'nama_produk' => 'Teh Pucuk Harum 350ml', 'harga_beli' => 2800, 'harga_jual' => 4000, 'stok' => 3, 'stok_minimum' => 10, 'satuan' => 'Botol'],
            ['kategori_id' => $katSnack->id, 'kode_produk' => 'Chitato-L', 'nama_produk' => 'Chitato Sapi Panggang 68g', 'harga_beli' => 9500, 'harga_jual' => 12500, 'stok' => 10, 'stok_minimum' => 5, 'satuan' => 'Bks'],
            ['kategori_id' => $katSabun->id, 'kode_produk' => 'Lifebuoy-R', 'nama_produk' => 'Sabun Lifebuoy Merah 110g', 'harga_beli' => 4000, 'harga_jual' => 5500, 'stok' => 24, 'stok_minimum' => 6, 'satuan' => 'Pcs'],
        ];

        foreach ($produks as $p) {
            $item = Produk::create($p);
            // Log stok awal
            StokLog::create([
                'produk_id' => $item->id,
                'jenis' => 'masuk',
                'jumlah' => $p['stok'],
                'stok_sebelum' => 0,
                'stok_sesudah' => $p['stok'],
                'keterangan' => 'Stok awal sistem',
                'user_id' => $admin->id
            ]);
        }

        // 5. Suppliers
        Supplier::create([
            'nama_supplier' => 'PT Indomarco Adi Prima',
            'kode_supplier' => 'SUP-001',
            'pic_nama' => 'Bapak Joko',
            'telepon' => '021-55667788',
            'alamat' => 'Kawasan Industri Jababeka, Bekasi',
            'kriteria_harga' => 85, 'kriteria_kualitas' => 90, 'kriteria_pengiriman' => 80, 'kriteria_konsistensi' => 95
        ]);
        Supplier::create([
            'nama_supplier' => 'Grosir Sumber Makmur',
            'kode_supplier' => 'SUP-002',
            'pic_nama' => 'Ibu Lani',
            'telepon' => '081299001122',
            'alamat' => 'Pasar Induk Kramat Jati, Jakarta Timur',
            'kriteria_harga' => 95, 'kriteria_kualitas' => 75, 'kriteria_pengiriman' => 85, 'kriteria_konsistensi' => 70
        ]);

        // 6. Pelanggan
        Pelanggan::create(['nama_pelanggan' => 'Andi Wijaya', 'kode_pelanggan' => 'PLG-001', 'telepon' => '081122334455', 'alamat' => 'Jl. Merdeka No. 10']);
        Pelanggan::create(['nama_pelanggan' => 'Budi Santoso', 'kode_pelanggan' => 'PLG-002', 'telepon' => '081233445566', 'alamat' => 'Perumahan Griya Indah Blok C']);

        // 7. Transaksi & Detail (Simulasi 3 hari terakhir)
        for ($i = 2; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->addHours(rand(9, 20));
            $subtotal = 75000;
            $total = 75000;

            $trx = Transaksi::create([
                'kode_transaksi' => 'TRX-' . $date->format('Ymd') . '-000' . (3-$i),
                'pelanggan_id' => ($i == 0) ? 1 : null,
                'user_id' => $kasir->id,
                'tanggal' => $date,
                'subtotal' => $subtotal,
                'total' => $total,
                'bayar' => 100000,
                'kembalian' => 25000,
                'metode_bayar' => 'Tunai',
                'status' => 'selesai'
            ]);

            DetailTransaksi::create([
                'transaksi_id' => $trx->id,
                'produk_id' => 1, // Beras
                'harga_satuan' => 75000,
                'jumlah' => 1,
                'subtotal' => 75000
            ]);

            // Catat Keuangan
            Keuangan::create([
                'jenis' => 'masuk',
                'kategori' => 'Penjualan',
                'jumlah' => $total,
                'tanggal' => $date,
                'keterangan' => 'Penjualan retail ' . $trx->kode_transaksi,
                'user_id' => $kasir->id
            ]);
        }

        // 8. Keuangan Pengeluaran
        Keuangan::create([
            'jenis' => 'keluar',
            'kategori' => 'Operasional',
            'jumlah' => 500000,
            'tanggal' => Carbon::now()->subDays(5),
            'keterangan' => 'Bayar Listrik Toko Bulan Mei',
            'user_id' => $admin->id
        ]);

        // 9. SPK Kriteria
        SpkKriteria::insert([
            ['nama_kriteria' => 'Harga', 'bobot' => 0.35, 'tipe' => 'min', 'fungsi_preferensi' => 'linear', 'p_parameter' => 20, 'q_parameter' => 5],
            ['nama_kriteria' => 'Kualitas', 'bobot' => 0.30, 'tipe' => 'max', 'fungsi_preferensi' => 'usual', 'p_parameter' => null, 'q_parameter' => null],
            ['nama_kriteria' => 'Pengiriman', 'bobot' => 0.20, 'tipe' => 'max', 'fungsi_preferensi' => 'v-shape', 'p_parameter' => 15, 'q_parameter' => null],
            ['nama_kriteria' => 'Konsistensi', 'bobot' => 0.15, 'tipe' => 'max', 'fungsi_preferensi' => 'usual', 'p_parameter' => null, 'q_parameter' => null],
        ]);
    }
}