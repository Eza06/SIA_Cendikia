<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';

    protected $fillable = [
        'name',
    ];

    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel');
    }

     public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
