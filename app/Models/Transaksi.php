<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'pelanggan_id',
        'user_id',
        'tanggal',
        'subtotal',
        'diskon',
        'pajak',
        'total',
        'metode_bayar',
        'bayar',
        'kembalian',
        'status',
    ];
}
