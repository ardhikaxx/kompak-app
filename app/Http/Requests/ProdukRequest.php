<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $produkId = $this->route('produk') ? $this->route('produk')->id : null;

        return [
            'kategori_id' => 'required|exists:kategoris,id',
            'kode_produk' => [
                'required',
                'string',
                'max:50',
                Rule::unique('produks')->ignore($produkId),
            ],
            'nama_produk' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|gte:harga_beli',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'harga_jual.gte' => 'Harga jual tidak boleh lebih kecil dari harga beli.',
            'kode_produk.unique' => 'Kode produk sudah digunakan.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
        ]);
    }
}