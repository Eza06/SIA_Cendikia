<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SiswaExport implements FromQuery, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Siswa::query()->with('user');

        if (!empty($this->filters['jenjang'])) {
            $query->where('education_level', $this->filters['jenjang']);
        }
        if (!empty($this->filters['kelas'])) {
            $query->where('kelas', $this->filters['kelas']);
        }
        if (!empty($this->filters['kelas_belajar_id'])) {
            $query->where('kelas_belajar_id', $this->filters['kelas_belajar_id']);
        }

        return $query->orderByRaw("FIELD(education_level, 'SD', 'SMP', 'SMA')")
                     ->orderByRaw("CAST(kelas AS UNSIGNED)");
    }

    public function headings(): array
    {
        return [
            'Kode Siswa',
            'Nama',
            'Email',
            'Asal Sekolah',
            'Jenjang',
            'Kelas',
            'Jenis Kelamin',
            'No Telepon',
            'Alamat',
        ];
    }

    public function map($siswa): array
    {
        return [
            $siswa->kode_siswa,
            optional($siswa->user)->name,
            optional($siswa->user)->email,
            $siswa->asal_sekolah,
            $siswa->education_level,
            $siswa->kelas,
            $siswa->jenis_kelamin,
            $siswa->no_telpon,
            $siswa->alamat,
        ];
    }
}
