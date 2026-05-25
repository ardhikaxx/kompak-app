<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}