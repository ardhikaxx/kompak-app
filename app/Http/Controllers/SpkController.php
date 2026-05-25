<?php

namespace App\Http\Controllers;

use App\Models\SpkKriteria;
use App\Models\Supplier;
use App\Http\Requests\SpkRequest;
use App\Services\PrometheeService;
use Illuminate\Http\Request;

class SpkController extends Controller
{
    protected $promethee;

    public function __construct(PrometheeService $promethee)
    {
        $this->promethee = $promethee;
    }

    public function index()
    {
        return view('spk.index');
    }

    public function kriteria()
    {
        $kriterias = SpkKriteria::all();
        // Seed default kriteria jika kosong
        if ($kriterias->isEmpty()) {
            SpkKriteria::insert([
                ['nama_kriteria' => 'Harga', 'bobot' => 0.3, 'tipe' => 'min', 'fungsi_preferensi' => 'usual'],
                ['nama_kriteria' => 'Kualitas', 'bobot' => 0.4, 'tipe' => 'max', 'fungsi_preferensi' => 'usual'],
                ['nama_kriteria' => 'Pengiriman', 'bobot' => 0.2, 'tipe' => 'max', 'fungsi_preferensi' => 'usual'],
                ['nama_kriteria' => 'Konsistensi', 'bobot' => 0.1, 'tipe' => 'max', 'fungsi_preferensi' => 'usual'],
            ]);
            $kriterias = SpkKriteria::all();
        }
        return view('spk.kriteria', compact('kriterias'));
    }

    public function simpanKriteria(Request $request)
    {
        try {
            $data = $request->validate([
                'kriteria' => 'required|array',
                'kriteria.*.id' => 'required|exists:spk_kriterias,id',
                'kriteria.*.bobot' => 'required|numeric|min:0',
                'kriteria.*.tipe' => 'required|in:max,min',
                'kriteria.*.fungsi_preferensi' => 'required|string',
                'kriteria.*.p_parameter' => 'nullable|numeric|min:0',
                'kriteria.*.q_parameter' => 'nullable|numeric|min:0',
            ]);

            foreach ($data['kriteria'] as $item) {
                SpkKriteria::where('id', $item['id'])->update([
                    'bobot' => $item['bobot'],
                    'tipe' => $item['tipe'],
                    'fungsi_preferensi' => $item['fungsi_preferensi'],
                    'p_parameter' => $item['p_parameter'],
                    'q_parameter' => $item['q_parameter'],
                ]);
            }

            return redirect()->route('spk.kriteria')->with('success', 'Konfigurasi kriteria SPK berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function hitung()
    {
        $kriterias = SpkKriteria::all();
        $suppliers = Supplier::all();

        if ($suppliers->count() < 2) {
            return redirect()->route('spk.index')->with('warning', 'Minimal dibutuhkan 2 supplier untuk melakukan perhitungan SPK.');
        }

        $hasil = $this->promethee->hitung($suppliers->toArray(), $kriterias->all());
        
        // Simpan hasil ke session agar tidak hilang saat redirect
        session(['hasil_spk' => $hasil]);

        return redirect()->route('spk.hasil')->with('success', 'Perhitungan PROMETHEE berhasil dilakukan.');
    }

    public function hasil()
    {
        $hasil = session('hasil_spk', []);
        
        if (empty($hasil)) {
            return redirect()->route('spk.index')->with('warning', 'Silakan lakukan perhitungan terlebih dahulu.');
        }

        return view('spk.hasil', compact('hasil'));
    }
}