<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = [
        'guru_id',
        'jenjang',
        'kelas',
        'tanggal',
        'mapel_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'kelas_belajar_id',
        'materi',
        'status',
    ];

    public function absen()
    {
        return $this->hasMany(Absen::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }


    public function kelasbelajar()
    {
        return $this->belongsTo(KelasBelajar::class, 'kelas_belajar_id');
    }
    
}
