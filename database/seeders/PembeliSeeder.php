<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pembeli;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PembeliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Pembeli Demo',
            'email' => 'pembeli@toko.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
        ]);

        Pembeli::create([
            'user_id' => $user->id,
            'nama_pembeli' => 'Pembeli Demo',
            'alamat' => 'Jl. Sudirman No. 456',
            'no_hp' => '081298765432',
        ]);
    }
}
