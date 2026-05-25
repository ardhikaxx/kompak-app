<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'nama_toko' => Setting::get('nama_toko', 'KOMPAK UMKM'),
            'alamat_toko' => Setting::get('alamat_toko', 'Jl. Contoh No. 123, Indonesia'),
            'telepon_toko' => Setting::get('telepon_toko', '08123456789'),
            'email_toko' => Setting::get('email_toko', 'halo@kompak.com'),
            'logo_toko' => Setting::get('logo_toko'),
        ];
        return view('setting.index', compact('settings'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nama_toko' => 'required|string|max:100',
                'alamat_toko' => 'nullable|string',
                'telepon_toko' => 'nullable|string|max:20',
                'email_toko' => 'nullable|email|max:100',
            ]);

            foreach ($data as $key => $value) {
                Setting::set($key, $value);
            }

            return redirect()->back()->with('success', 'Pengaturan toko berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }
}