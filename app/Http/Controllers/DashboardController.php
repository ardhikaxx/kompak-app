<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Transaksi;
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

        // Data Grafik 7 Hari Terakhir
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D');
            $chartData[] = Transaksi::whereDate('tanggal', $date)->sum('total');
        }

        // Transaksi Terakhir
        $recentTransaksis = Transaksi::with(['pelanggan', 'user'])->latest()->limit(5)->get();

        return view('dashboard.index', compact('totalProduk', 'penjualanHariIni', 'stokRendah', 'totalPelanggan', 'chartLabels', 'chartData', 'recentTransaksis'));
    }
}