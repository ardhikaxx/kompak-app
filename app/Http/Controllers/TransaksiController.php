<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\StokLog;
use App\Models\Keuangan;
use App\Http\Requests\TransaksiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'user'])->latest();

        if ($request->has('search')) {
            $query->where('kode_transaksi', 'like', '%' . $request->search . '%');
        }

        $transaksis = $query->paginate(10);
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $produks = Produk::where('is_active', true)->get();
        $pelanggans = Pelanggan::all();
        // Generate kode transaksi: TRX-YYYYMMDD-XXXX
        $today = Carbon::now()->format('Ymd');
        $lastTrx = Transaksi::where('kode_transaksi', 'like', "TRX-{$today}-%")->orderBy('id', 'desc')->first();
        $nextNum = $lastTrx ? intval(substr($lastTrx->kode_transaksi, -4)) + 1 : 1;
        $kodeTransaksi = "TRX-{$today}-" . str_pad($nextNum, 4, '0', STR_PAD_LEFT);

        return view('transaksi.create', compact('produks', 'pelanggans', 'kodeTransaksi'));
    }

    public function store(TransaksiRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Calculate Subtotal
                $subtotal = 0;
                $produkIds = $request->produk_id;
                $jumlahs = $request->jumlah;
                $items = [];

                for ($i = 0; $i < count($produkIds); $i++) {
                    $produk = Produk::lockForUpdate()->findOrFail($produkIds[$i]);
                    
                    if ($produk->stok < $jumlahs[$i]) {
                        throw new \Exception("Stok {$produk->nama_produk} tidak mencukupi.");
                    }

                    $itemSubtotal = $produk->harga_jual * $jumlahs[$i];
                    $subtotal += $itemSubtotal;

                    $items[] = [
                        'produk' => $produk,
                        'jumlah' => $jumlahs[$i],
                        'harga_satuan' => $produk->harga_jual,
                        'subtotal' => $itemSubtotal
                    ];
                }

                $diskon = $request->diskon ?? 0;
                $pajak = $request->pajak ?? 0;
                $total = $subtotal - $diskon + $pajak;

                if ($request->bayar < $total) {
                    throw new \Exception("Nominal pembayaran kurang dari total tagihan.");
                }

                $kembalian = $request->bayar - $total;

                // Create Transaksi
                $transaksi = Transaksi::create([
                    'kode_transaksi' => $request->kode_transaksi ?? 'TRX-' . time(),
                    'pelanggan_id' => $request->pelanggan_id,
                    'user_id' => Auth::id(),
                    'tanggal' => Carbon::now(),
                    'subtotal' => $subtotal,
                    'diskon' => $diskon,
                    'pajak' => $pajak,
                    'total' => $total,
                    'metode_bayar' => $request->metode_bayar ?? 'Tunai',
                    'bayar' => $request->bayar,
                    'kembalian' => $kembalian,
                    'status' => 'selesai',
                ]);

                // Detail, Stok, & Logs
                foreach ($items as $item) {
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id' => $item['produk']->id,
                        'harga_satuan' => $item['harga_satuan'],
                        'jumlah' => $item['jumlah'],
                        'diskon_item' => 0,
                        'subtotal' => $item['subtotal'],
                    ]);

                    $stokSebelum = $item['produk']->stok;
                    $item['produk']->decrement('stok', $item['jumlah']);

                    StokLog::create([
                        'produk_id' => $item['produk']->id,
                        'jenis' => 'keluar',
                        'jumlah' => $item['jumlah'],
                        'stok_sebelum' => $stokSebelum,
                        'stok_sesudah' => $item['produk']->fresh()->stok,
                        'keterangan' => "Penjualan TRX: {$transaksi->kode_transaksi}",
                        'user_id' => Auth::id(),
                    ]);
                }

                // Update Pelanggan Total Transaksi
                if ($request->pelanggan_id) {
                    Pelanggan::where('id', $request->pelanggan_id)->increment('total_transaksi', $total);
                }

                // Catat di Keuangan (Pemasukan)
                Keuangan::create([
                    'jenis' => 'masuk',
                    'kategori' => 'Penjualan',
                    'jumlah' => $total,
                    'keterangan' => "Penjualan dari transaksi {$transaksi->kode_transaksi}",
                    'tanggal' => Carbon::today(),
                    'user_id' => Auth::id(),
                ]);
            });

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'user', 'detailTransaksis.produk'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }
}