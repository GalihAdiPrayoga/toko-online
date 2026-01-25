<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    protected $fillable = [
        'user_id',
        'nama_pembeli',
        'alamat',
        'no_hp',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
