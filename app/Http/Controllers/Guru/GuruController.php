<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            return view('guru.dashboard')->with('error', 'Data guru tidak ditemukan');
        }

        $jadwals = Jadwal::where('guru_id', $guru->id)
            ->with(['mapel', 'guru.user'])
            ->latest()
            ->get();

        $totalJadwal = $jadwals->count();
        $totalMapel = $jadwals->pluck('mapel_id')->unique()->count();


        return view('guru.dashboard', compact('jadwals', 'user', 'totalJadwal', 'totalMapel'));
    }

    public function updateMateri(Request $request, $id)
    {
        $request->validate([
            'materi' => 'nullable|string|max:1000',
        ]);

        $jadwal = Jadwal::findOrFail($id);

        // Cek apakah jadwal milik guru yang sedang login
        if ($jadwal->guru_id !== Auth::user()->guru->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah materi ini.');
        }

        $jadwal->materi = $request->materi;
        $jadwal->save();

        return back()->with('success', 'Materi berhasil diperbarui.');
    }


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
    public function store(Request $request)
    {
        //
    }

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
