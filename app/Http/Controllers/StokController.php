<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokLog;
use App\Http\Requests\StokRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with('kategori');

        if ($request->has('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_produk', 'like', '%' . $request->search . '%');
        }

        $stokRendah = Produk::where('stok', '<=', DB::raw('stok_minimum'))->count();
        $produks = $query->paginate(10);
        
        return view('stok.index', compact('produks', 'stokRendah'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('stok.create', compact('produks'));
    }

    public function store(StokRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $produk = Produk::lockForUpdate()->findOrFail($request->produk_id);
                $stokSebelum = $produk->stok;

                if ($request->jenis === 'masuk') {
                    $produk->increment('stok', $request->jumlah);
                } else {
                    if ($produk->stok < $request->jumlah) {
                        throw new \Exception("Stok tidak mencukupi untuk dikeluarkan.");
                    }
                    $produk->decrement('stok', $request->jumlah);
                }

                StokLog::create([
                    'produk_id' => $produk->id,
                    'jenis' => $request->jenis,
                    'jumlah' => $request->jumlah,
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $produk->fresh()->stok,
                    'keterangan' => $request->keterangan ?? 'Penyesuaian stok manual',
                    'user_id' => Auth::id(),
                ]);
            });

            return redirect()->route('stok.index')->with('success', 'Stok berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        $logs = StokLog::where('produk_id', $id)->with('user')->latest()->paginate(15);
        return view('stok.show', compact('produk', 'logs'));
    }
}