<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;

class GuruAbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jadwal = Jadwal::find($id);
        $siswas = Siswa::where('kelas_belajar_id', $jadwal->kelas_belajar_id)->get();

        $absens = Absen::where('jadwal_id', $jadwal->id)->get()->keyBy('siswa_id');

        return view('guru.absen.edit', compact('jadwal', 'siswas', 'absens'))->with('success', 'Data Absen Berhasil diperbarui.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'absen' => 'required|array',
        ]);
    
        $jadwal = Jadwal::findOrFail($id);
        // dd($jadwal);
        foreach ($request->absen as $siswa_id => $data) {
            Absen::updateOrCreate(
                [
                    'jadwal_id' => $jadwal->id,
                    'siswa_id' => $siswa_id,
                    'tanggal' => $jadwal->tanggal,
                ],
                [
                    'status' => $data['status'],
                    'keterangan' => $data['keterangan'] ?? null,
                ]
            );
        }
    
        return redirect()->route('guru.dashboard', $jadwal->id)->with('success', 'Data absensi berhasil diperbarui!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
