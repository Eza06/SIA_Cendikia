<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaporToMapel extends Model
{
    protected $table = 'rapor_to_mapel';

    protected $fillable = [
        'rapor_to_id',
        'mapel_id',
    ];

    public function raporTo()
    {
        return $this->belongsTo(RaporTo::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function nilaiTo()
    {
        return $this->hasMany(NilaiTo::class);
    }
}
