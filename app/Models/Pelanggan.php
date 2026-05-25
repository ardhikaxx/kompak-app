<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'nama_pelanggan',
        'kode_pelanggan',
        'telepon',
        'alamat',
        'email',
        'total_transaksi',
    ];
}
