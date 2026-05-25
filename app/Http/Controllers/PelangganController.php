<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Http\Requests\PelangganRequest;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::query();

        if ($request->has('search')) {
            $query->where('nama_pelanggan', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_pelanggan', 'like', '%' . $request->search . '%')
                  ->orWhere('telepon', 'like', '%' . $request->search . '%');
        }

        $pelanggans = $query->latest()->paginate(10);
        return view('pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(PelangganRequest $request)
    {
        try {
            Pelanggan::create($request->validated());
            return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(PelangganRequest $request, Pelanggan $pelanggan)
    {
        try {
            $pelanggan->update($request->validated());
            return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Pelanggan $pelanggan)
    {
        try {
            if ($pelanggan->transaksis()->exists()) {
                return redirect()->route('pelanggan.index')->with('error', 'Pelanggan tidak dapat dihapus karena memiliki riwayat transaksi.');
            }
            $pelanggan->delete();
            return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('pelanggan.index')->with('error', 'Data tidak dapat dihapus.');
        }
    }
}