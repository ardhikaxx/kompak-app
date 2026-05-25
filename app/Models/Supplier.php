<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'nama_supplier',
        'kode_supplier',
        'alamat',
        'telepon',
        'email',
        'pic_nama',
        'kriteria_harga',
        'kriteria_kualitas',
        'kriteria_pengiriman',
        'kriteria_konsistensi',
    ];
}