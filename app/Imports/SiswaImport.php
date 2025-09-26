<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation
{
    private $lastSiswaNumber;

    public function __construct()
    {
        $latest = Siswa::where('kode_siswa', 'like', 'S2025%')->orderBy('id', 'desc')->first();
        $this->lastSiswaNumber = $latest ? (int)substr($latest->kode_siswa, 5) : 0;
    }

    public function model(array $row)
    {
        $user = User::create([
            'name'     => $row['nama'],
            'email'    => $row['email'],
            'password' => Hash::make($row['password']),
            'role'     => 'MURID',
        ]);

        $this->lastSiswaNumber++;
        $newCode = 'S2025' . str_pad($this->lastSiswaNumber, 4, '0', STR_PAD_LEFT);

        return new Siswa([
            'users_id'           => $user->id,
            'kode_siswa'        => $newCode,
            'asal_sekolah'      => $row['asal_sekolah'],
            'education_level'   => $row['jenjang'],
            'kelas'             => $row['kelas'],
            'jenis_kelamin'     => $row['jenis_kelamin'],
            'no_telpon'         => $row['no_telepon'],
            'alamat'            => $row['alamat'],
        ]);
    }

    /**
     * [DIPERBARUI] Aturan validasi untuk 'no_telepon' telah diubah.
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'asal_sekolah' => 'required|string|max:255',
            'jenjang' => 'required|in:SD,SMP,SMA',
            'kelas' => 'required|integer|min:1|max:12',
            'jenis_kelamin' => 'required|in:LAKI-LAKI,PEREMPUAN',
            'no_telepon' => 'nullable|numeric|digits_between:8,20',

            'alamat' => 'required|string',
        ];
    }

    /**
     * Memberitahu Laravel Excel untuk membaca header dari baris ke-2.
     */
    public function headingRow(): int
    {
        return 2;
    }
}

