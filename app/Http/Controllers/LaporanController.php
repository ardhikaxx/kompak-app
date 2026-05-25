<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\StokLog;
use App\Models\Keuangan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function penjualan(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfMonth();

        $transaksis = Transaksi::with(['pelanggan', 'user'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->latest()
            ->get();

        $totalPendapatan = $transaksis->sum('total');
        $totalTransaksi = $transaksis->count();

        // Produk Terlaris
        $produkLaris = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
            ->whereBetween('transaksis.tanggal', [$startDate, $endDate])
            ->select('produks.nama_produk', DB::raw('SUM(detail_transaksis.jumlah) as total_terjual'), DB::raw('SUM(detail_transaksis.subtotal) as total_pendapatan'))
            ->groupBy('produks.id', 'produks.nama_produk')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        return view('laporan.penjualan', compact('transaksis', 'totalPendapatan', 'totalTransaksi', 'produkLaris', 'startDate', 'endDate'));
    }

    public function stok(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfMonth();

        $stokLogs = StokLog::with(['produk.kategori', 'user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        $totalMasuk = $stokLogs->where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = $stokLogs->where('jenis', 'keluar')->sum('jumlah');

        $stokRendah = Produk::where('stok', '<=', DB::raw('stok_minimum'))->get();

        return view('laporan.stok', compact('stokLogs', 'totalMasuk', 'totalKeluar', 'stokRendah', 'startDate', 'endDate'));
    }

    public function keuangan(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfMonth();

        $keuangans = Keuangan::with('user')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalPemasukan = $keuangans->where('jenis', 'masuk')->sum('jumlah');
        $totalPengeluaran = $keuangans->where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('laporan.keuangan', compact('keuangans', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'startDate', 'endDate'));
    }
}