<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Aulia Ramadhan',
                'jenis_kelamin' => 'Laki-laki',
                'asal_sekolah' => 'SMP Negeri 4 Tangerang Selatan',
                'alamat' => 'Jl. Cendrawasih No.12, Ciputat, Tangsel',
                'no_telpon' => '081234567810',
            ],
            [
                'name' => 'Nabila Salsabila',
                'jenis_kelamin' => 'Perempuan',
                'asal_sekolah' => 'SMP Islam Al Azhar BSD',
                'alamat' => 'Jl. Taman Tekno BSD, Setu, Tangsel',
                'no_telpon' => '082111234455',
            ],
            [
                'name' => 'Fikri Alamsyah',
                'jenis_kelamin' => 'Laki-laki',
                'asal_sekolah' => 'SMP Taruna Bangsa',
                'alamat' => 'Jl. Raya Serpong KM 8, Tangsel',
                'no_telpon' => '081387653245',
            ],
            [
                'name' => 'Zahra Amalia',
                'jenis_kelamin' => 'Perempuan',
                'asal_sekolah' => 'SMPIT Auliya',
                'alamat' => 'Jl. Jombang Raya No.51, Pondok Aren, Tangsel',
                'no_telpon' => '085211339001',
            ],
            [
                'name' => 'Raka Pratama',
                'jenis_kelamin' => 'Laki-laki',
                'asal_sekolah' => 'SMP Negeri 5 Tangerang Selatan',
                'alamat' => 'Jl. Jombang, Ciputat, Tangsel',
                'no_telpon' => '081988902234',
            ],
            [
                'name' => 'Sekar Ayu Larasati',
                'jenis_kelamin' => 'Perempuan',
                'asal_sekolah' => 'SMP Labschool Cirendeu',
                'alamat' => 'Jl. Cirendeu Raya No.1, Tangsel',
                'no_telpon' => '087766773344',
            ],
            [
                'name' => 'Aldi Nugroho',
                'jenis_kelamin' => 'Laki-laki',
                'asal_sekolah' => 'SMP Global Islamic School 2 Serpong',
                'alamat' => 'Jl. Raya Serpong, Tangsel',
                'no_telpon' => '082277669911',
            ],
            [
                'name' => 'Dian Maharani',
                'jenis_kelamin' => 'Perempuan',
                'asal_sekolah' => 'SMP Santa Ursula BSD',
                'alamat' => 'Jl. Taman BSD Barat No.1, Serpong, Tangsel',
                'no_telpon' => '083822334477',
            ],
            [
                'name' => 'Bayu Setiawan',
                'jenis_kelamin' => 'Laki-laki',
                'asal_sekolah' => 'SMP Negeri 115 Jakarta',
                'alamat' => 'Jl. Tebet Timur IV H, Jakarta Selatan',
                'no_telpon' => '081255447880',
            ],
            [
                'name' => 'Melati Rachmawati',
                'jenis_kelamin' => 'Perempuan',
                'asal_sekolah' => 'SMP Labschool Jakarta',
                'alamat' => 'Jl. Pemuda No.1, Rawamangun, Jakarta Timur',
                'no_telpon' => '085733559912',
            ],
            [
                'name' => 'Akbar Nugraha',
                'jenis_kelamin' => 'Laki-laki',
                'asal_sekolah' => 'SMP Negeri 41 Jakarta',
                'alamat' => 'Jl. H. Nawi Raya No.1, Gandaria Selatan, Jakarta',
                'no_telpon' => '089922113344',
            ],
            [
                'name' => 'Intan Permatasari',
                'jenis_kelamin' => 'Perempuan',
                'asal_sekolah' => 'SMP Al Azhar 1 Jakarta',
                'alamat' => 'Jl. Sisingamangaraja, Kebayoran Baru, Jakarta',
                'no_telpon' => '087899928821',
            ],
            [
                'name' => 'Rafi Alfarizi',
                'jenis_kelamin' => 'Laki-laki',
                'asal_sekolah' => 'SMP Muhammadiyah 1 Jakarta',
                'alamat' => 'Jl. KH Mas Mansyur, Tanah Abang, Jakarta',
                'no_telpon' => '082310101212',
            ],
            [
                'name' => 'Salsabila Nuraini',
                'jenis_kelamin' => 'Perempuan',
                'asal_sekolah' => 'SMP Kanisius Jakarta',
                'alamat' => 'Jl. Menteng Raya No.64, Jakarta Pusat',
                'no_telpon' => '085377889900',
            ],
            [
                'name' => 'Andika Prasetyo',
                'jenis_kelamin' => 'Laki-laki',
                'asal_sekolah' => 'SMP Negeri 19 Jakarta',
                'alamat' => 'Jl. Sawo Manila No.6, Jakarta Selatan',
                'no_telpon' => '081455667823',
            ],
        ];

        foreach ($data as $item) {
            // Buat user
            $user = User::create([
                'name' => $item['name'],
                'email' => strtolower(str_replace(' ', '', $item['name'])) . '@example.com',
                'password' => Hash::make('password'), // default password
                'role' => 'MURID'
            ]);

            // Buat kode siswa seperti "S20250001"
            $latest = Siswa::where('kode_siswa', 'like', 'S2025%')->orderBy('id', 'desc')->first();
            $lastNumber = $latest ? (int)substr($latest->kode_siswa, 5) : 0;
            $newCode = 'S2025' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

            // Buat siswa
            Siswa::create([
                'users_id' => $user->id,
                'jenis_kelamin' => $item['jenis_kelamin'],
                'asal_sekolah' => $item['asal_sekolah'],
                'alamat' => $item['alamat'],
                'no_telpon' => $item['no_telpon'],
                'education_level' => 'SMP',
                'kelas' => '8',
                'kode_siswa' => $newCode,
                'kelas_belajar_id' => 10,
            ]);
        }
    }
}
