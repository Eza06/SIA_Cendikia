<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasBelajar extends Model
{
    protected $table = 'kelas_belajar';

    protected $fillable = [
        'nama_kelas',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
