<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\SupplierRequest;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->has('search')) {
            $query->where('nama_supplier', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_supplier', 'like', '%' . $request->search . '%')
                  ->orWhere('pic_nama', 'like', '%' . $request->search . '%');
        }

        $suppliers = $query->latest()->paginate(10);
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(SupplierRequest $request)
    {
        try {
            Supplier::create($request->validated());
            return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        try {
            $supplier->update($request->validated());
            return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('supplier.index')->with('error', 'Data tidak dapat dihapus.');
        }
    }
}