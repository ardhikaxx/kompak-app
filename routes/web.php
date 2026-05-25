<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SpkController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('produk', ProdukController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('stok', StokController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('keuangan', KeuanganController::class);
    Route::resource('pengguna', PenggunaController::class)->middleware('role:admin');
    
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/penjualan', [LaporanController::class, 'penjualan'])->name('penjualan');
        Route::get('/stok', [LaporanController::class, 'stok'])->name('stok');
        Route::get('/keuangan', [LaporanController::class, 'keuangan'])->name('keuangan');
    });

    Route::prefix('spk')->name('spk.')->group(function () {
        Route::get('/', [SpkController::class, 'index'])->name('index');
        Route::get('/kriteria', [SpkController::class, 'kriteria'])->name('kriteria');
        Route::post('/kriteria', [SpkController::class, 'simpanKriteria'])->name('kriteria.store');
        Route::get('/hitung', [SpkController::class, 'hitung'])->name('hitung');
        Route::get('/hasil', [SpkController::class, 'hasil'])->name('hasil');
    });
});