<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OngkosKirim extends Model
{
    use HasFactory;

    protected $table = 'ongkos_kirim';

    protected $fillable = [
        'daerah',
        'biaya',
    ];
}
