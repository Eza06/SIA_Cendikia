<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = [
        'users_id',
        'kode_siswa',
        'jenis_kelamin',
        'kelas',
        'asal_sekolah',
        'education_level',
        'no_telpon',
        'kelas_belajar_id',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }


    public function kelasBelajar()
    {
        return $this->belongsTo(KelasBelajar::class);
    }
}
