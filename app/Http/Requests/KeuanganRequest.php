<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeuanganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenis' => 'required|in:masuk,keluar',
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}