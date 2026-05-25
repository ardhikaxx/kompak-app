<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $supplierId = $this->route('supplier') ? $this->route('supplier')->id : null;

        return [
            'kode_supplier' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('suppliers')->ignore($supplierId),
            ],
            'nama_supplier' => 'required|string|max:100',
            'pic_nama' => 'nullable|string|max:100',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
            'kriteria_harga' => 'nullable|numeric|min:0|max:100',
            'kriteria_kualitas' => 'nullable|numeric|min:0|max:100',
            'kriteria_pengiriman' => 'nullable|numeric|min:0|max:100',
            'kriteria_konsistensi' => 'nullable|numeric|min:0|max:100',
        ];
    }
}