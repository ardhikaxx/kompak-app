<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpkKriteria extends Model
{
    protected $fillable = [
        'nama_kriteria',
        'bobot',
        'tipe',
        'fungsi_preferensi',
        'p_parameter',
        'q_parameter',
    ];
}
