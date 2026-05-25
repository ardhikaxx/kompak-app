<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\StokLog;
use App\Models\Keuangan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;
use App\Exports\StokExport;
use App\Exports\KeuanganExport;

class LaporanController extends Controller
{
    private function getRange($request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfMonth();
        return [$startDate, $endDate];
    }

    public function penjualan(Request $request)
    {
        [$startDate, $endDate] = $this->getRange($request);

        $transaksis = Transaksi::with(['pelanggan', 'user'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->latest()
            ->get();

        $totalPendapatan = $transaksis->sum('total');
        $totalTransaksi = $transaksis->count();

        $produkLaris = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->join('produks', 'detail_transaksis.produk_id', '=', 'produks.id')
            ->whereBetween('transaksis.tanggal', [$startDate, $endDate])
            ->select('produks.nama_produk', DB::raw('SUM(detail_transaksis.jumlah) as total_terjual'), DB::raw('SUM(detail_transaksis.subtotal) as total_pendapatan'))
            ->groupBy('produks.id', 'produks.nama_produk')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        if ($request->export == 'pdf') {
            $pdf = Pdf::loadView('laporan.exports.penjualan-pdf', compact('transaksis', 'totalPendapatan', 'totalTransaksi', 'produkLaris', 'startDate', 'endDate'));
            return $pdf->download('Laporan-Penjualan-' . $startDate->format('dMY') . '.pdf');
        }

        if ($request->export == 'excel') {
            return Excel::download(new TransaksiExport($transaksis), 'Laporan-Penjualan.xlsx');
        }

        return view('laporan.penjualan', compact('transaksis', 'totalPendapatan', 'totalTransaksi', 'produkLaris', 'startDate', 'endDate'));
    }

    public function stok(Request $request)
    {
        [$startDate, $endDate] = $this->getRange($request);

        $stokLogs = StokLog::with(['produk.kategori', 'user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        $totalMasuk = $stokLogs->where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = $stokLogs->where('jenis', 'keluar')->sum('jumlah');

        $stokRendah = Produk::where('stok', '<=', DB::raw('stok_minimum'))->get();

        if ($request->export == 'pdf') {
            $pdf = Pdf::loadView('laporan.exports.stok-pdf', compact('stokLogs', 'totalMasuk', 'totalKeluar', 'stokRendah', 'startDate', 'endDate'));
            return $pdf->download('Laporan-Stok-' . $startDate->format('dMY') . '.pdf');
        }

        if ($request->export == 'excel') {
            return Excel::download(new StokExport($stokLogs), 'Laporan-Stok.xlsx');
        }

        return view('laporan.stok', compact('stokLogs', 'totalMasuk', 'totalKeluar', 'stokRendah', 'startDate', 'endDate'));
    }

    public function keuangan(Request $request)
    {
        [$startDate, $endDate] = $this->getRange($request);

        $keuangans = Keuangan::with('user')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalPemasukan = $keuangans->where('jenis', 'masuk')->sum('jumlah');
        $totalPengeluaran = $keuangans->where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalPemasukan - $totalPengeluaran;

        if ($request->export == 'pdf') {
            $pdf = Pdf::loadView('laporan.exports.keuangan-pdf', compact('keuangans', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'startDate', 'endDate'));
            return $pdf->download('Laporan-Keuangan-' . $startDate->format('dMY') . '.pdf');
        }

        if ($request->export == 'excel') {
            return Excel::download(new KeuanganExport($keuangans), 'Laporan-Keuangan.xlsx');
        }

        return view('laporan.keuangan', compact('keuangans', 'totalPemasukan', 'totalPengeluaran', 'saldo', 'startDate', 'endDate'));
    }
}