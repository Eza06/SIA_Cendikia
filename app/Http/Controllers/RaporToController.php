<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\KelasBelajar;
use App\Models\Mapel;
use App\Models\NilaiTo;
use App\Models\RaporTo;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RaporToController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data angkatan dan kelas belajar untuk filter
        $angkatans = Angkatan::all();

        // Urutkan nama_kelas secara numerik dan abjad, contoh: 1-A, 2-A, ..., 12-C
        $kelasBelajar = KelasBelajar::orderByRaw("
        CAST(SUBSTRING_INDEX(nama_kelas, '-', 1) AS UNSIGNED),
        nama_kelas
    ")->get();

        // Filter data raport berdasarkan request jika tersedia
        $query = RaporTo::query();

        if ($request->filled('angkatan_id')) {
            $query->where('angkatan_id', $request->angkatan_id);
        }

        if ($request->filled('kelas_belajar_id')) {
            $query->where('kelas_belajar_id', $request->kelas_belajar_id);
        }

        $raporTo = $query->get();

        return view('admin.raport.index', compact('raporTo', 'angkatans', 'kelasBelajar'));
    }

    public function create(Request $request)
    {
        $kelasBelajar = KelasBelajar::all();
        $angkatan = Angkatan::all();
        $mapels = Mapel::all();
        $siswas = [];

        if ($request->has('kelas_belajar_id')) {
            $siswas = Siswa::with('user')
                ->where('kelas_belajar_id', $request->kelas_belajar_id)
                ->get();
        }

        return view('admin.raport.create', compact('kelasBelajar', 'angkatan', 'mapels', 'siswas'));
    }

    public function getSiswaByKelas(Request $request)
    {
        $kelasId = $request->kelas_belajar_id;

        $siswa = Siswa::where('kelas_belajar_id', $kelasId)->get();

        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rapor' => 'required|string|max:255',
            'angkatan_id' => 'required|exists:angkatan,id',
            'semester' => 'required|in:Ganjil,Genap',
            'kelas_belajar_id' => 'required|exists:kelas_belajar,id',
            'nilai' => 'required|array',
        ]);

        $rapor = RaporTo::create([
            'nama_rapor' => $request->nama_rapor,
            'angkatan_id' => $request->angkatan_id,
            'semester' => $request->semester,
            'kelas_belajar_id' => $request->kelas_belajar_id,
        ]);

        foreach ($request->nilai as $siswaId => $nilaiMapel) {
            foreach ($nilaiMapel as $mapelId => $nilai) {
                NilaiTo::create([
                    'rapor_to_id' => $rapor->id,
                    'siswa_id' => $siswaId,
                    'mapel_id' => $mapelId,
                    'nilai' => $nilai,
                ]);
            }
        }

        return redirect()->route('admin.raport.index')->with('success', 'Raport berhasil disimpan');
    }

    public function show(string $id)
    {
        $rapor = RaporTo::findOrFail($id);
        $angkatans = Angkatan::all();
        $kelasBelajar = KelasBelajar::all();
        $mapels = Mapel::all();
        $siswas = $rapor->kelasBelajar ? $rapor->kelasBelajar->siswa : collect();

        $nilaiRaport = NilaiTo::where('rapor_to_id', $rapor->id)->get()
            ->groupBy('siswa_id')
            ->map(function ($group) {
                return $group->keyBy('mapel_id');
            });

        return view('admin.raport.detail', compact(
            'rapor',
            'angkatans',
            'kelasBelajar',
            'siswas',
            'mapels',
            'nilaiRaport'
        ));
    }

    public function cetakPerSiswa($rapor, $siswa)
    {
        $rapor = RaporTo::with(['angkatan', 'kelasBelajar'])->findOrFail($rapor);
        $siswa = Siswa::with('user')->findOrFail($siswa);

        $nilaiRapor = NilaiTo::with('mapel')
            ->where('rapor_to_id', $rapor->id)
            ->where('siswa_id', $siswa->id)
            ->get();

        $pdf = Pdf::loadView('admin.raport.pdf', compact('rapor', 'siswa', 'nilaiRapor'));

        return $pdf->download('raport-' . $siswa->user->name . '_' . now()->format('Ymd_His') . '.pdf');
    }

    public function edit($id)
    {
        $rapor = RaporTo::findOrFail($id);
        $angkatans = Angkatan::all();
        $kelasBelajar = KelasBelajar::all();
        $mapels = Mapel::all();
        $siswas = $rapor->kelasBelajar ? $rapor->kelasBelajar->siswa : collect();

        $nilaiRaport = NilaiTo::where('rapor_to_id', $rapor->id)->get()
            ->groupBy('siswa_id')
            ->map(function ($group) {
                return $group->keyBy('mapel_id');
            });

        return view('admin.raport.edit', compact(
            'rapor',
            'angkatans',
            'kelasBelajar',
            'siswas',
            'mapels',
            'nilaiRaport'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_rapor' => 'required|string|max:255',
            'angkatan_id' => 'required|exists:angkatan,id',
            'semester' => 'required|in:Ganjil,Genap',
            'kelas_belajar_id' => 'required|exists:kelas_belajar,id',
        ]);

        $rapor = RaporTo::findOrFail($id);
        $rapor->update([
            'nama_rapor' => $request->nama_rapor,
            'angkatan_id' => $request->angkatan_id,
            'semester' => $request->semester,
            'kelas_belajar_id' => $request->kelas_belajar_id,
        ]);

        foreach ($request->siswa_id as $siswaId) {
            foreach ($request->nilai[$siswaId] as $mapelId => $nilai) {
                NilaiTo::updateOrCreate(
                    [
                        'rapor_to_id' => $rapor->id,
                        'siswa_id' => $siswaId,
                        'mapel_id' => $mapelId,
                    ],
                    [
                        'nilai' => $nilai
                    ]
                );
            }
        }

        return redirect()->route('admin.raport.index')->with('success', 'Raport berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $rapor = RaporTo::findOrFail($id);
        $rapor->nilai()->delete();
        $rapor->delete();

        return redirect()->route('admin.raport.index')->with('success', 'Raport Berhasil Di Hapus');
    }
}
