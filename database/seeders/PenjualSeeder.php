<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Penjual;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenjualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Penjual Satu',
            'email' => 'penjual@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'penjual',
        ]);

        Penjual::create([
            'user_id' => $user->id,
            'nama_user' => $user->name,
            'alamat' => 'Alamat penjual contoh',
            'no_hp' => '081234567890',
        ]);
    }
}
