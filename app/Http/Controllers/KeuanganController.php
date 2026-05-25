<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Http\Requests\KeuanganRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Keuangan::with('user')->orderBy('tanggal', 'desc')->latest();

        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis', $request->jenis);
        }
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $keuangans = $query->paginate(10);
        
        $totalMasuk = Keuangan::where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = Keuangan::where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return view('keuangan.index', compact('keuangans', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    public function create()
    {
        return view('keuangan.create');
    }

    public function store(KeuanganRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            if ($request->hasFile('bukti')) {
                $data['bukti'] = $request->file('bukti')->store('keuangan', 'public');
            }

            Keuangan::create($data);
            return redirect()->route('keuangan.index')->with('success', 'Catatan keuangan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Keuangan $keuangan)
    {
        return view('keuangan.edit', compact('keuangan'));
    }

    public function update(KeuanganRequest $request, Keuangan $keuangan)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('bukti')) {
                if ($keuangan->bukti && Storage::disk('public')->exists($keuangan->bukti)) {
                    Storage::disk('public')->delete($keuangan->bukti);
                }
                $data['bukti'] = $request->file('bukti')->store('keuangan', 'public');
            }

            $keuangan->update($data);
            return redirect()->route('keuangan.index')->with('success', 'Catatan keuangan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Keuangan $keuangan)
    {
        try {
            if ($keuangan->bukti && Storage::disk('public')->exists($keuangan->bukti)) {
                Storage::disk('public')->delete($keuangan->bukti);
            }
            $keuangan->delete();
            return redirect()->route('keuangan.index')->with('success', 'Catatan keuangan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('keuangan.index')->with('error', 'Data tidak dapat dihapus.');
        }
    }
}