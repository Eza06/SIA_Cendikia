<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Raport {{ $siswa->user->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .center { text-align: center; }
        .header img { width: 70px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        hr { border: 1px solid #000; }
    </style>
</head>
<body>
    <div class="header center">
        <img src="{{ public_path('storage/image/cendikia.png') }}" alt="Logo">
        <h2 style="margin: 5px 0;">BIMBEL CENDIKIA</h2>
        <p style="margin: 0;">Jl. Pinang Raya 37, Bojonggede, Bogor</p>
    </div>
    <hr>

    <h3 class="center" style="text-decoration: underline;">SURAT KETERANGAN NILAI RAPORT</h3>

    <div class="details" style="margin-top: 20px;">
        <p><strong>Nama Siswa:</strong> {{ strtoupper($siswa->user->name) }}</p>
        <p><strong>Kode Siswa:</strong> {{ strtoupper($siswa->kode_siswa) }}</p>
        <p><strong>Jenjang:</strong> {{ strtoupper($siswa->education_level) }}</p>
        <p><strong>Kelas:</strong> {{ strtoupper($siswa->kelas) }}</p>
        <p><strong>Angkatan:</strong> {{ $rapor->angkatan->tahun_angkatan ?? '-' }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($nilaiRapor as $index => $nilai)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $nilai->mapel->name ?? '-' }}</td>
                    <td>{{ $nilai->nilai ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Tidak ada data nilai.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 40px; text-align: right;">
        <p>Bogor, {{ now()->setTimezone('Asia/Jakarta')->format('d F Y') }}</p>
        <p style="margin-top: 60px;">__________________________</p>
        <p style="margin-top: -10px;">Staf Administrasi</p>
    </div>
</body>
</html>
