<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $jumlahSiswa = Siswa::count();
        $jumlahGuru = Guru::count();
        $mapelAll = Mapel::count();
    
        // Hitung jumlah kehadiran dan persentase (misalnya dari semua absensi)
        $totalAbsensi = Absen::count();
        $jumlahHadir = Absen::where('status', 'HADIR')->count();
        $rateHadir = $totalAbsensi > 0 ? round(($jumlahHadir / $totalAbsensi) * 100, 2) : 0;
        return view('admin.dashboard', compact('jumlahSiswa', 'jumlahGuru', 'rateHadir', 'user', 'mapelAll'));
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

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'ADMIN',
        ]);

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan.');
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
