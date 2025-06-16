<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiTo extends Model
{

    protected $table = 'nilai_to';

    protected $fillable = [
        'rapor_to_id',
        'mapel_id',
        'siswa_id',
        'nilai',
    ];

    public function raporTo()
    {
        return $this->belongsTo(RaporTo::class, 'rapor_to_id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
