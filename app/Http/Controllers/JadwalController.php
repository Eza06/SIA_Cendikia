<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\KelasBelajar;
use App\Models\Mapel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwal = Jadwal::all();
        return view('admin.jadwal.index', compact('jadwal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelasBelajar = KelasBelajar::all();
        $guru = Guru::with('user', 'mapels')->get(); // penting agar data mapel bisa diakses di blade
        $mapel = Mapel::all();

        return view('admin.jadwal.create', compact('guru', 'mapel', 'kelasBelajar'));
    }


    /**
     * Store a newly created resource in storage.
     */

    public function getGuruData($id)
    {
        $guru = Guru::with(['mapel', 'kelas'])->findOrFail($id);

        // Kelompokkan kelas berdasarkan jenjang
        $kelas = $guru->kelas->groupBy('jenjang')->map(function ($group) {
            return $group->map(function ($k) {
                return ['id' => $k->id, 'nama' => $k->nama];
            });
        });

        return response()->json([
            'mapel' => $guru->mapel,
            'kelas' => $kelas
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        // dd($request->all());
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'mapel_id' => 'required|exists:mapel,id',
            'jenjang' => 'required|in:SD,SMP,SMA',
            'kelas' => 'required|string',
            'kelas_belajar_id' => 'required|exists:kelas_belajar,id',
            'tanggal' => 'required|date',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'required|string',
        ]);

        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Simpan jadwal
            $jadwal = Jadwal::create([
                'guru_id' => $request->guru_id,
                'mapel_id' => $request->mapel_id,
                'jenjang' => $request->jenjang,
                'kelas' => $request->kelas,
                'kelas_belajar_id' => $request->kelas_belajar_id,
                'tanggal' => $request->tanggal,
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'ruangan' => $request->ruangan,
                'status' => 'AKTIF',
            ]);

            // Ambil semua siswa yang sesuai dengan jenjang dan kelas
            $siswas = Siswa::where('kelas_belajar_id', $request->kelas_belajar_id)
                ->get();

            // Buat data absen default
            $absenData = [];

            foreach ($siswas as $siswa) {
                $absenData[] = [
                    'jadwal_id' => $jadwal->id,
                    'siswa_id' => $siswa->id,
                    'status' => 'TANPA KETERANGAN',
                    'tanggal' => $jadwal->tanggal,
                    'keterangan' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // dd($absenData);

            DB::table('absen')->insert($absenData);

            // Commit transaksi
            DB::commit();

            return redirect()->route('admin.jadwal.index')
                ->with('success', 'Jadwal berhasil dibuat dan absensi otomatis disiapkan untuk ' . count($siswas) . ' siswa.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan jadwal: ' . $e->getMessage()]);
        }
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
        $jadwal = Jadwal::find($id);
        $kelasBelajar = KelasBelajar::all();
        $guru = Guru::all();
        $mapel = Mapel::all();

        return view('admin.jadwal.edit', compact('jadwal', 'guru', 'mapel', 'kelasBelajar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mapel_id' => 'required|exists:mapel,id',
            'guru_id' => 'required|exists:guru,id',
            'jenjang' => 'required|string',
            'kelas' => 'required|string',
            'kelas_belajar_id' => 'required|exists:kelas_belajar,id',
            'tanggal' => 'required|date',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after_or_equal:jam_mulai',
            'materi' => 'required|string',
            'ruangan' => 'required|string',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update([
            'mapel_id' => $request->mapel_id,
            'guru_id' => $request->guru_id,
            'jenjang' => $request->jenjang,
            'kelas' => $request->kelas,
            'kelas_belajar_id' => $request->kelas_belajar_id,
            'tanggal' => $request->tanggal,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'materi' => $request->materi,
            'ruangan' => $request->ruangan,
        ]);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function toggleStatus(Request $request, string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->status = $jadwal->status === 'AKTIF' ? 'NONAKTIF' : 'AKTIF';
        $jadwal->save();

        return redirect()->back()->with('success', 'Status jadwal berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Cari jadwal berdasarkan ID
            $jadwal = Jadwal::findOrFail($id);

            // Hapus semua absensi yang terkait dengan jadwal ini
            $jadwal->absen()->delete(); // <--- Tambahkan ini

            // Hapus jadwal
            $jadwal->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal dan absensi terkait berhasil dihapus.');
        } catch (\Exception $e) {
            // Redirect dengan pesan error jika gagal
            return redirect()->route('admin.jadwal.index')->with('error', 'Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }
}
