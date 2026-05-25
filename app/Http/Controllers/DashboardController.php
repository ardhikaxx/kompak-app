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
        
        // 1. Stat: Total Produk
        $totalProduk = Produk::count();
        $produkAktif = Produk::where('is_active', true)->count();
        $produkNonaktif = $totalProduk - $produkAktif;

        // 2. Stat: Penjualan Hari Ini
        $penjualanHariIni = Transaksi::whereDate('tanggal', $today)->sum('total');
        $transaksiHariIni = Transaksi::whereDate('tanggal', $today)->count();

        // 3. Stat: Stok Rendah
        $stokRendah = Produk::where('stok', '<=', DB::raw('stok_minimum'))->where('stok', '>', 0)->count();
        $stokHabis = Produk::where('stok', '<=', 0)->count();
        $totalPeringatanStok = $stokRendah + $stokHabis;

        // 4. Stat: Laba
        $totalPendapatan = Transaksi::sum('total');
        $totalHpp = DetailTransaksi::join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
                    ->sum(DB::raw('produks.harga_beli * detail_transaksis.jumlah'));
        $labaKotor = $totalPendapatan - $totalHpp;
        $totalPengeluaranOperasional = Keuangan::where('jenis', 'keluar')->sum('jumlah');
        $labaBersih = $labaKotor - $totalPengeluaranOperasional;

        $totalPelanggan = Pelanggan::count();

        // Data Grafik Penjualan (7 Hari Terakhir)
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D');
            $chartData[] = Transaksi::whereDate('tanggal', $date)->sum('total');
        }

        // Data Grafik Arus Kas (6 Bulan Terakhir)
        $cashFlowLabels = [];
        $incomeData = [];
        $expenseData = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $cashFlowLabels[] = $monthDate->translatedFormat('M');
            $incomeData[] = Keuangan::where('jenis', 'masuk')->whereMonth('tanggal', $monthDate->month)->whereYear('tanggal', $monthDate->year)->sum('jumlah');
            $expenseData[] = Keuangan::where('jenis', 'keluar')->whereMonth('tanggal', $monthDate->month)->whereYear('tanggal', $monthDate->year)->sum('jumlah');
        }

        // Data Distribusi Kategori (Pie Chart)
        $categoryData = Kategori::withCount('produks')->get();
        $catLabels = $categoryData->pluck('nama_kategori');
        $catValues = $categoryData->pluck('produks_count');

        $recentTransaksis = Transaksi::with(['pelanggan', 'user'])->latest()->limit(5)->get();

        return view('dashboard.index', compact(
            'totalProduk', 'produkAktif', 'produkNonaktif',
            'penjualanHariIni', 'transaksiHariIni',
            'totalPeringatanStok', 'stokRendah', 'stokHabis',
            'labaBersih', 'labaKotor', 'totalPengeluaranOperasional',
            'totalPelanggan', 'chartLabels', 'chartData', 
            'cashFlowLabels', 'incomeData', 'expenseData',
            'catLabels', 'catValues',
            'recentTransaksis'
        ));
    }

    public function aktivitas()
    {
        $logs = \App\Models\AktivitasLog::with('user')->latest()->paginate(20);
        return view('pengguna.aktivitas', compact('logs'));
    }
}