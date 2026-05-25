<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'harga_satuan',
        'jumlah',
        'diskon_item',
        'subtotal',
    ];
}
