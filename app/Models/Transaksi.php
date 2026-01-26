<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'pelanggan_id',
        'tanggal_transaksi',
        'daerah',
        'total_bayar',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
    ];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'pelanggan_id');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function ongkosKirim()
    {
        return $this->hasOne(OngkosKirim::class, 'daerah', 'daerah');
    }
}
