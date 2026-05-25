<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'kategori_id',
        'kode_produk',
        'nama_produk',
        'deskripsi',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimum',
        'satuan',
        'foto',
        'is_active',
    ];
}
