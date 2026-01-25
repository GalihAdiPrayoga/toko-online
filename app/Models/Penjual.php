<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjual extends Model
{
    protected $fillable = [
        'user_id',
        'nama_user',
        'alamat',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
