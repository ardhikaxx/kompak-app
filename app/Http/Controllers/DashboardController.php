<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\Keuangan;
use App\Models\Kategori;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $today = Carbon::today();
        
        $totalProduk = Produk::count();
        $penjualanHariIni = Transaksi::whereDate('tanggal', $today)->sum('total');
        $stokRendah = Produk::where('stok', '<=', DB::raw('stok_minimum'))->count();
        $totalPelanggan = Pelanggan::count();

        // 1. Data Grafik Penjualan (7 Hari Terakhir)
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D');
            $chartData[] = Transaksi::whereDate('tanggal', $date)->sum('total');
        }

        // 2. Data Grafik Arus Kas (6 Bulan Terakhir)
        $cashFlowLabels = [];
        $incomeData = [];
        $expenseData = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $cashFlowLabels[] = $monthDate->translatedFormat('M');
            $incomeData[] = Keuangan::where('jenis', 'masuk')->whereMonth('tanggal', $monthDate->month)->whereYear('tanggal', $monthDate->year)->sum('jumlah');
            $expenseData[] = Keuangan::where('jenis', 'keluar')->whereMonth('tanggal', $monthDate->month)->whereYear('tanggal', $monthDate->year)->sum('jumlah');
        }

        // 3. Analisis Margin Keuntungan
        // Rumus Laba Bersih: Sum ( (Harga Jual - Harga Beli) * Qty ) - Pengeluaran Operasional
        $totalPendapatan = Transaksi::sum('total');
        
        // Hitung total HPP (Harga Pokok Penjualan) dari semua detail transaksi
        $totalHpp = DetailTransaksi::join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
                    ->sum(DB::raw('produks.harga_beli * detail_transaksis.jumlah'));
        
        $labaKotor = $totalPendapatan - $totalHpp;
        $totalPengeluaranOperasional = Keuangan::where('jenis', 'keluar')->sum('jumlah');
        $labaBersih = $labaKotor - $totalPengeluaranOperasional;

        // 4. Data Distribusi Kategori (Pie Chart)
        $categoryData = Kategori::withCount('produks')->get();
        $catLabels = $categoryData->pluck('nama_kategori');
        $catValues = $categoryData->pluck('produks_count');

        // Transaksi Terakhir
        $recentTransaksis = Transaksi::with(['pelanggan', 'user'])->latest()->limit(5)->get();

        return view('dashboard.index', compact(
            'totalProduk', 'penjualanHariIni', 'stokRendah', 'totalPelanggan', 
            'chartLabels', 'chartData', 
            'cashFlowLabels', 'incomeData', 'expenseData',
            'catLabels', 'catValues',
            'recentTransaksis',
            'labaBersih', 'labaKotor', 'totalPengeluaranOperasional'
        ));
    }
}