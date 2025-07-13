<?php

namespace App\Http\Controllers;

use App\Models\KelasBelajar;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Siswa::with('user');

        if ($request->filled('jenjang')) {
            $query->where('education_level', $request->jenjang);
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('kelas_belajar_id')) {
            $query->where('kelas_belajar_id', $request->kelas_belajar_id);
        }

        $murid = $query
            ->orderByRaw("FIELD(education_level, 'SD', 'SMP', 'SMA')")
            ->orderByRaw("CAST(kelas AS UNSIGNED)")
            ->orderBy('kelas_belajar_id')
            ->get();

        // Urutkan kelas belajar seperti '1-1', '2-1', ..., '12-3'
        $kelasBelajar = KelasBelajar::orderByRaw("
        CAST(SUBSTRING_INDEX(nama_kelas, '-', 1) AS UNSIGNED),
        nama_kelas
    ")->get();

        return view('admin.siswa.index', compact('murid', 'kelasBelajar'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $kelasBelajar = KelasBelajar::all();
        return view('admin.siswa.create', compact('user', 'kelasBelajar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|string',
            'asal_sekolah' => 'required|string',
            'kelas_belajar_id' => 'required|exists:kelas_belajar,id',
            'education_level' => 'required',
            'no_telpon' => 'required|string|max:20',
            'kelas' => 'required'
        ]);


        // Buat user terlebih dahulu
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),  // encrypt password dari input user
            'role' => 'MURID',
        ]);


        // Ambil kode siswa terakhir
        $latest = Siswa::where('kode_siswa', 'like', 'S2025%')->orderBy('id', 'desc')->first();
        $lastNumber = $latest ? (int)substr($latest->kode_siswa, 5) : 0;
        $newCode = 'S2025' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Buat siswa
        $siswa = Siswa::create([
            'users_id' => $user->id,
            'kode_siswa' => $newCode,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'asal_sekolah' => $request->asal_sekolah,
            'no_telpon' => $request->no_telpon,
            'education_level' => $request->education_level,
            'kelas' => $request->kelas,
            'kelas_belajar_id' => $request->kelas_belajar_id, // << Tambahkan ini
        ]);


        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil disimpan.');
    }



    public function deleteSelected(Request $request)
    {
        // dd($request->all());
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route('admin.siswa.index')->with('showAlert', 'Tidak ada siswa yang dipilih.');
        }

        try {
            foreach ($ids as $id) {
                $siswa = Siswa::find($id);
                if ($siswa) {
                    $siswa->user()->delete();
                    $siswa->delete();
                }
            }
            return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.siswa.index')->with('error', 'Gagal menghapus siswa: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        return response()->json($siswa);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $siswa = Siswa::find($id);
        $kelasBelajar = KelasBelajar::all();
        return view('admin.siswa.edit', compact('siswa', 'kelasBelajar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'jenis_kelamin' => 'required',
            'asal_sekolah' => 'required',
            'alamat' => 'required|string',
            'education_level' => 'required',
            'kelas' => 'required',
            'kelas_belajar_id' => 'required',
            'no_telpon' => 'required|string'
        ]);

        $siswa = Siswa::findOrFail($id);
        $user = $siswa->user;

        // Update user
        $user->name = $request->name;
        $user->email = $request->email;

        // Kalau password diisi, update
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save(); // <-- penting!

        // Update data siswa
        $siswa->update([
            'jenis_kelamin' => $request->jenis_kelamin,
            'asal_sekolah' => $request->asal_sekolah,
            'alamat' => $request->alamat,
            'education_level' => $request->education_level,
            'kelas' => $request->kelas,
            'kelas_belajar_id' => $request->kelas_belajar_id,
            'no_telpon' => $request->no_telpon
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data murid berhasil diperbarui.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);

        // Hapus user yang terkait (jika ada)
        if ($siswa->user) {
            $siswa->user->delete();
        }

        // Hapus siswa
        $siswa->delete();

        return redirect(route('admin.siswa.index'))->with('showAlert', 'Siswa dan user berhasil dihapus.');
    }
}
