# 🚀 KOMPAK — UMKM Management System

**KOMPAK** (*Kontrol Operasional Manajemen Penjualan dan Analisis Keputusan*) adalah platform manajemen bisnis terintegrasi yang dirancang khusus untuk membantu pelaku UMKM mengelola operasional harian, memantau keuangan, hingga mengambil keputusan strategis menggunakan bantuan AI.

Sistem ini hadir dengan antarmuka modern **Glassmorphism Dark Theme** yang memberikan kesan premium, profesional, dan nyaman di mata.

---

## ✨ Fitur Utama

### 📦 1. Manajemen Katalog & Produk
Kelola inventaris barang Anda dengan mudah. Dilengkapi dengan kategori produk, manajemen satuan, stok minimum, serta fitur unggah foto produk.

### 🛒 2. Point of Sales (POS)
Antarmuka kasir yang interaktif dan cepat. Mendukung pemilihan pelanggan, penghitungan diskon, format mata uang otomatis, dan cetak struk belanja secara instan.

### 📉 3. Manajemen Stok & Log
Setiap mutasi barang (masuk/keluar) dicatat secara mendetail. Sistem akan memberikan notifikasi otomatis jika stok barang telah mencapai batas minimum.

### 💰 4. Keuangan & Arus Kas
Pantau kesehatan finansial bisnis Anda. Selain transaksi penjualan otomatis, Anda dapat mencatat pengeluaran operasional (sewa, gaji, listrik) secara manual lengkap dengan bukti transaksi.

### 📊 5. Analitik & Laporan Lanjutan
Sajikan data bisnis Anda dalam bentuk visual yang mudah dimengerti:
- **Tren Penjualan:** Grafik pendapatan harian.
- **Distribusi Kategori:** Komposisi produk berdasarkan kategori.
- **Analisis Laba Rugi:** Perbandingan pemasukan vs pengeluaran.
- **Margin Keuntungan:** Penghitungan laba kotor dan laba bersih secara otomatis berdasarkan Harga Pokok Penjualan (HPP).
- **Ekspor Data:** Unduh laporan dalam format **PDF** atau **Excel (.xlsx)**.

### 🧠 6. SPK PROMETHEE II (Decision Support)
Fitur unggulan yang membantu pemilik bisnis menentukan Supplier terbaik. Menggunakan algoritma **PROMETHEE II**, sistem akan meranking alternatif berdasarkan kriteria Harga, Kualitas, Pengiriman, dan Konsistensi.

### 📜 7. Log Aktivitas (Audit Trail)
Keamanan data terjamin dengan pencatatan otomatis setiap aktivitas krusial (Tambah/Ubah/Hapus). Anda dapat memantau siapa yang melakukan perubahan data, kapan, dan dari perangkat mana.

### 📱 8. Progressive Web App (PWA)
KOMPAK dapat di-install langsung di HP atau Desktop Anda sebagai aplikasi mandiri. Memberikan akses cepat dari layar utama dan performa yang lebih responsif.

---

## 🛠️ Tech Stack

- **Backend:** [Laravel 12](https://laravel.com/) (Latest Version)
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **UI Framework:** [Bootstrap 5.3](https://getbootstrap.com/) (CDN)
- **Database:** MySQL / MariaDB
- **Key Features:**
  - **PWA Ready:** Manifest & Service Worker integration.
  - **Audit Logger:** Automatic activity tracking middleware.
  - **Data Visualization:** Chart.js integration.
- **Libraries:** 
  - [Chart.js](https://www.chartjs.org/) (Data Visualization)
  - [SweetAlert2](https://sweetalert2.github.io/) (Elegant Alerts)
  - [DomPDF](https://github.com/barryvdh/laravel-dompdf) (PDF Export)
  - [Laravel Excel](https://docs.laravel-excel.com/) (Excel Export)

---

## ⚙️ Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal Anda:

1. **Clone Repositori**
   ```bash
   git clone https://github.com/ardhikaxx/kompak-app.git
   cd kompak-app
   ```

2. **Instal Dependensi PHP**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi & Seeding Data**
   Jalankan perintah ini untuk membuat tabel dan mengisi data demo masif (transaksi 30 hari terakhir).
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Hubungkan Storage**
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Server**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di: `http://127.0.0.1:8000`

---

## 🔐 Akun Demo

Semua akun menggunakan password: **`password`**

- **Admin:** `admin@kompak.com` (Akses Penuh + Manajemen User)
- **Pemilik:** `pemilik@kompak.com` (Akses Laporan & SPK)
- **Kasir:** `kasir@kompak.com` (Akses POS & Stok)

---

## 📸 Tampilan UI
Proyek ini menggunakan filosofi **Glassmorphism Dark Theme** dengan efek blur transparan, gradasi warna biru malam, dan elemen interaktif yang responsif.

---

*Dikembangkan dengan ❤️ untuk kemajuan UMKM Indonesia.*