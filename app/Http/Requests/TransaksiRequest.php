<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransaksiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
            'produk_id' => 'required|array|min:1',
            'produk_id.*' => 'required|exists:produks,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'diskon' => 'nullable|numeric|min:0',
            'pajak' => 'nullable|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
            'metode_bayar' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'produk_id.required' => 'Minimal pilih satu produk untuk transaksi.',
            'bayar.required' => 'Nominal pembayaran harus diisi.',
        ];
    }
}