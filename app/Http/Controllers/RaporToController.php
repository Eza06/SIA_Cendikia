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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $raporTo = RaporTo::all();
        return view('admin.raport.index', compact('raporTo'));
    }

    /**
     * Show the form for creating a new resource.
     */
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



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_rapor' => 'required|string|max:255',
            'angkatan_id' => 'required|exists:angkatan,id',
            'semester' => 'required|in:Ganjil,Genap',
            'kelas_belajar_id' => 'required|exists:kelas_belajar,id',
            'nilai' => 'required|array',
        ]);

        // 1. Simpan ke rapor_tos
        $rapor = RaporTo::create([
            'nama_rapor' => $request->nama_rapor,
            'angkatan_id' => $request->angkatan_id,
            'semester' => $request->semester,
            'kelas_belajar_id' => $request->kelas_belajar_id,
        ]);

        // 2. Simpan nilai ke nilai_tos
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


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $rapor = RaporTo::findOrFail($id);
        $angkatans = Angkatan::all();
        $kelasBelajar = KelasBelajar::all();

        $siswas = $rapor->kelasBelajar->siswas ?? [];
        $mapels = Mapel::all();

        $siswas = $rapor->kelasBelajar ? $rapor->kelasBelajar->siswa : collect();
        // Ambil nilai yang sudah ada
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
        // Ambil data raport
        $rapor = RaporTo::with(['angkatan', 'kelasBelajar'])->findOrFail($rapor);

        // Ambil data siswa
        $siswa = Siswa::with('user')->findOrFail($siswa);

        // Ambil nilai raport untuk siswa ini
        $nilaiRapor = NilaiTo::with('mapel')
            ->where('rapor_to_id', $rapor->id)
            ->where('siswa_id', $siswa->id)
            ->get();

        // Generate PDF
        $pdf = Pdf::loadView('admin.raport.pdf', compact('rapor', 'siswa', 'nilaiRapor'));

        // Unduh PDF
        return $pdf->download('raport-' . $siswa->user->name . '_' . now()->format('Ymd_His') . '.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rapor = RaporTo::findOrFail($id);
        $angkatans = Angkatan::all();
        $kelasBelajar = KelasBelajar::all();

        $siswas = $rapor->kelasBelajar->siswas ?? [];
        $mapels = Mapel::all();

        $siswas = $rapor->kelasBelajar ? $rapor->kelasBelajar->siswa : collect();
        // Ambil nilai yang sudah ada
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

    /**
     * Update the specified resource in storage.
     */
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

        // Simpan nilai
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rapor = RaporTo::findOrFail($id);
        $rapor->nilai()->delete();

        $rapor->delete();
        return redirect()->route('admin.raport.index')->with('success', 'Raport Berhasil Di Hapus');
    }
}
