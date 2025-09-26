<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class SiswaTemplateExport implements WithHeadings, FromArray, WithColumnWidths, WithEvents, WithColumnFormatting
{
    public function array(): array
    {
        // Memberikan satu baris contoh untuk diisi pengguna
        return [
            ['1', '', '', '', '', '', '', '', '', '']
        ];
    }

    public function headings(): array
    {
        // Header yang akan dilihat oleh pengguna
        return [
            'No',
            'Nama',
            'Email',
            'Password',
            'Asal Sekolah',
            'Jenjang',
            'Kelas',
            'Jenis Kelamin',
            'No Telepon',
            'Alamat',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10, 'B' => 30, 'C' => 30, 'D' => 20, 'E' => 30,
            'F' => 15, 'G' => 15, 'H' => 20, 'I' => 25, 'J' => 40,
        ];
    }

    public function columnFormats(): array
    {
        return [
            // Format kolom I (No Telepon) sebagai Teks untuk mencegah 0 hilang
            'I' => NumberFormat::FORMAT_TEXT,
        ];
    }

    /**
     * Mendaftarkan event yang akan berjalan setelah sheet dibuat.
     * Di sinilah kita menambahkan semua styling dan validasi.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // 1. Memberi style pada header yang terlihat (Baris 1)
                $sheet->getStyle('1')->getFont()->setBold(true);
                $sheet->getStyle('1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // 2. Menambahkan header kedua (untuk sistem) di baris kedua
                $systemHeaders = [
                    'No', 'nama', 'email', 'password', 'asal_sekolah', 'jenjang',
                    'kelas', 'jenis_kelamin', 'no_telepon', 'alamat'
                ];
                $sheet->fromArray($systemHeaders, null, 'A2');
                $sheet->getRowDimension('2')->setVisible(false); // Sembunyikan baris ini

                // 3. Menambahkan dropdown validasi data
                $this->applyDataValidation($sheet);
            },
        ];
    }

    /**
     * Fungsi helper untuk menerapkan dropdown validasi.
     */
    protected function applyDataValidation($sheet)
    {
        $lastRow = 1000; // Terapkan validasi hingga baris ke-1000

        // Opsi untuk dropdown Jenjang (Kolom F)
        $validationJenjang = $sheet->getCell('F3')->getDataValidation();
        $validationJenjang->setType(DataValidation::TYPE_LIST);
        $validationJenjang->setFormula1('"SD,SMP,SMA"');
        $validationJenjang->setAllowBlank(false);
        $validationJenjang->setShowDropDown(true);
        for ($i = 3; $i <= $lastRow; $i++) {
            $sheet->getCell("F{$i}")->setDataValidation(clone $validationJenjang);
        }

        // Opsi untuk dropdown Kelas (Kolom G)
        $validationKelas = $sheet->getCell('G3')->getDataValidation();
        $validationKelas->setType(DataValidation::TYPE_LIST);
        $validationKelas->setFormula1('"1,2,3,4,5,6,7,8,9,10,11,12"');
        $validationKelas->setAllowBlank(false);
        $validationKelas->setShowDropDown(true);
        for ($i = 3; $i <= $lastRow; $i++) {
            $sheet->getCell("G{$i}")->setDataValidation(clone $validationKelas);
        }
        // Menambahkan komentar petunjuk
        $sheet->getComment('G1')->getText()->createTextRun('Pilih kelas yang sesuai dengan Jenjang. Contoh: Jika memilih SD, isi kelas 1-6.');

        // Opsi untuk dropdown Jenis Kelamin (Kolom H)
        $validationJenisKelamin = $sheet->getCell('H3')->getDataValidation();
        $validationJenisKelamin->setType(DataValidation::TYPE_LIST);
        $validationJenisKelamin->setFormula1('"LAKI-LAKI,PEREMPUAN"');
        $validationJenisKelamin->setAllowBlank(false);
        $validationJenisKelamin->setShowDropDown(true);
        for ($i = 3; $i <= $lastRow; $i++) {
            $sheet->getCell("H{$i}")->setDataValidation(clone $validationJenisKelamin);
        }
    }
}

