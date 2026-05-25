<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\PenggunaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $penggunas = $query->latest()->paginate(10);
        return view('pengguna.index', compact('penggunas'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(PenggunaRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('pengguna', 'public');
            }

            User::create($data);
            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(User $pengguna)
    {
        return view('pengguna.edit', compact('pengguna'));
    }

    public function update(PenggunaRequest $request, User $pengguna)
    {
        try {
            $data = $request->validated();

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            if ($request->hasFile('foto')) {
                if ($pengguna->foto && Storage::disk('public')->exists($pengguna->foto)) {
                    Storage::disk('public')->delete($pengguna->foto);
                }
                $data['foto'] = $request->file('foto')->store('pengguna', 'public');
            }

            $pengguna->update($data);
            return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(User $pengguna)
    {
        try {
            if ($pengguna->id === auth()->id()) {
                return redirect()->route('pengguna.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            }
            if ($pengguna->foto && Storage::disk('public')->exists($pengguna->foto)) {
                Storage::disk('public')->delete($pengguna->foto);
            }
            $pengguna->delete();
            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('pengguna.index')->with('error', 'Data tidak dapat dihapus.');
        }
    }
}