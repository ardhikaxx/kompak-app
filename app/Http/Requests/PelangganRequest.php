<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PelangganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pelangganId = $this->route('pelanggan') ? $this->route('pelanggan')->id : null;

        return [
            'kode_pelanggan' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('pelanggans')->ignore($pelangganId),
            ],
            'nama_pelanggan' => 'required|string|max:100',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
        ];
    }
}