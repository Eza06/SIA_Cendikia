<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample schedule data
        $jadwals = [
            [
                'guru_id' => 8,
                'mapel_id' => 2,
                'tanggal' => '2024-12-02',
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '09:30',
                'kelas' => '10',
                'materi' => 'Pengenalan Algoritma dan Pemrograman',
                'ruangan' => 'Lab Komputer 1',
                'status' => 'AKTIF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guru_id' => 7,
                'mapel_id' => 1,
                'tanggal' => '2024-12-02',
                'hari' => 'Senin',
                'jam_mulai' => '10:00',
                'jam_selesai' => '11:30',
                'kelas' => '11',
                'materi' => 'Fungsi Kuadrat dan Grafiknya',
                'ruangan' => 'Ruang 201',
                'status' => 'AKTIF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('jadwal')->insert($jadwals);
    }
}
