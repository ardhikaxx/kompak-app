<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kriteria' => 'required|string|max:100',
            'bobot' => 'required|numeric|min:0',
            'tipe' => 'required|in:max,min',
            'fungsi_preferensi' => 'required|string',
            'p_parameter' => 'nullable|numeric|min:0',
            'q_parameter' => 'nullable|numeric|min:0',
        ];
    }
}