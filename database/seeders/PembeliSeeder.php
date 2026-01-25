<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pembeli;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PembeliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Pembeli Satu',
            'email' => 'pembeli@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
        ]);

        Pembeli::create([
            'user_id' => $user->id,
            'nama_pembeli' => $user->name,
            'alamat' => 'Alamat pembeli contoh',
            'no_hp' => '089876543210',
        ]);
    }
}
