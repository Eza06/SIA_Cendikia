<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Guru Matematika',
            'email' => 'guru@example.com',
            'password' => Hash::make('password'),
            'role' => 'GURU',
        ]);

        // Buat guru-nya
        Guru::create([
            'users_id' => $user->id,
            'kode_guru' => 'G2025001', 
            'mapel_id' => 1, 
            'jenjang' => 'SMP',
            'kelas' => '9',
            'jenis_kelamin' => 'laki-laki',
            'no_telpon' => '084477064154',
            'alamat' => '8844 Deborah Circle, Suite 408, 32769, Port Scottyfort, Nevada, United States',
        ]);//
    }
}
