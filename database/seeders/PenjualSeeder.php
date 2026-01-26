<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Penjual;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenjualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin Penjual',
            'email' => 'penjual@toko.com',
            'password' => Hash::make('password'),
            'role' => 'penjual',
        ]);

        Penjual::create([
            'user_id' => $user->id,
            'nama_user' => 'Admin Penjual',
            'alamat' => 'Jl. Merdeka No. 123',
            'no_hp' => '081234567890',
        ]);
    }
}
