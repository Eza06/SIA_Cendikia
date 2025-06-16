<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table = 'absen';
    protected $fillable = [
        'siswa_id',
        'jadwal_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    public function jadwal() {
        return $this->belongsTo(Jadwal::class);
    }
    
    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }
    
}
