<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }
}