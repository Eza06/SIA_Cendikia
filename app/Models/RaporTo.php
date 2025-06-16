<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaporTo extends Model
{
    protected $table = 'rapor_to';
    protected $fillable = [
        'nama_rapor',
        'angkatan_id',
        'semester',
        'kelas_belajar_id',
    ];

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'angkatan_id');
    }

    public function nilai()
    {
        return $this->hasMany(NilaiTo::class);
    }

    public function kelasBelajar()
    {
        return $this->belongsTo(kelasBelajar::class, 'kelas_belajar_id');
    }
}
