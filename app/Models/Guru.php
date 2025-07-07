<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'users_id',
        'kode_guru',
        'jenjang',
        'kelas',
        'jenis_kelamin',
        'alamat',
        'no_telpon',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // app/Models/Guru.php

    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel');
    }

    // app/Models/Guru.php

    public function jadwal()
    {
        return $this->hasMany(\App\Models\Jadwal::class, 'guru_id');
    }

    public function kelas()
{
    return $this->belongsToMany(KelasBelajar::class, 'guru_kelas'); // sesuaikan nama tabel pivot jika berbeda
}

}
