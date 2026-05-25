<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $fillable = [
        'jenis',
        'kategori',
        'jumlah',
        'keterangan',
        'tanggal',
        'bukti',
        'user_id',
    ];
}
