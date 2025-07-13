<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Guru::with(['user', 'mapels'])->get();
        return view('admin.guru.index', compact('guru'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guru = Auth::user();
        $mapel = Mapel::all();
        return view('admin.guru.create', compact('guru', 'mapel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'mapel_id' => 'required|array',
            'mapel_id.*' => 'exists:mapel,id',
            // 'jenjang' => 'required',
            // 'kelas' => 'required',
            'no_telpon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'GURU',
        ]);

        $kodeGuru = 'GR-' . date('Y') . '-' . strtoupper(Str::random(8));

        $guru = Guru::create([
            'users_id' => $user->id,
            'kode_guru' => $kodeGuru,
            // 'jenjang' => $request->jenjang,
            // 'kelas' => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telpon' => $request->no_telpon,
        ]);

        $guru->mapels()->attach($request->mapel_id);


        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guru = Guru::findOrFail($id);
        return response()->json($guru);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $guru = Guru::find($id);
        $mapel = Mapel::all();
        return view('admin.guru.edit', compact('guru', 'mapel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'alamat' => 'nullable|string',
            'no_telpon' => 'nullable|string',
            'email' => 'required|email',
            'mapel_id' => 'required|array',
            'mapel_id.*' => 'exists:mapel,id',
        ]);

        $guru = Guru::findOrFail($id);
        $user = $guru->user;

        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password); // Password baru
        }

        $user->save(); // <-- penting!

        // Update guru data
        $guru->update([
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telpon' => $request->no_telpon,
        ]);

        // Update mapel relasi
        $guru->mapels()->sync($request->mapel_id);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $guru = Guru::with('jadwal')->findOrFail($id);

        // Hapus semua jadwal dan absen terkait
        foreach ($guru->jadwal as $jadwal) {
            // Hapus semua absen yang terkait dengan jadwal ini
            $jadwal->absen()->delete();

            // Hapus jadwalnya
            $jadwal->delete();
        }

        // Hapus user (jika ada relasinya)
        if ($guru->user) {
            $guru->user->delete();
        }

        // Terakhir, hapus guru
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Guru dan semua data terkait berhasil dihapus.');
    }
}
