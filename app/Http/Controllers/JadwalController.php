<?php

namespace App\Http\Controllers;

use App\Models\{Absen, Guru, Jadwal, KelasBelajar, Mapel, Siswa};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::query();

        if ($request->filled('jenjang')) {
            $query->where('jenjang', $request->jenjang);
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        if ($request->filled('mapel_id')) {
            $query->where('mapel_id', $request->mapel_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jadwal = $query->get();

        $guruList = Guru::with('user')->get();
        $mapelList = Mapel::all();

        return view('admin.jadwal.index', compact('jadwal', 'guruList', 'mapelList'));
    }

    public function create()
    {
        $kelasBelajar = KelasBelajar::all();
        $guru = Guru::with('user', 'mapels')->get();
        $mapel = Mapel::all();

        return view('admin.jadwal.create', compact('guru', 'mapel', 'kelasBelajar'));
    }

    public function getGuruData($id)
    {
        $guru = Guru::with(['mapel', 'kelas'])->findOrFail($id);

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

        DB::beginTransaction();

        try {
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

            $siswas = Siswa::where('kelas_belajar_id', $request->kelas_belajar_id)->get();

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

            DB::table('absen')->insert($absenData);
            DB::commit();

            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dibuat dan absensi otomatis disiapkan untuk ' . count($siswas) . ' siswa.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan jadwal: ' . $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        $jadwal = Jadwal::find($id);
        $kelasBelajar = KelasBelajar::all();
        $guru = Guru::all();
        $mapel = Mapel::all();

        return view('admin.jadwal.edit', compact('jadwal', 'guru', 'mapel', 'kelasBelajar'));
    }

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


    public function destroy(string $id)
    {
        try {
            $jadwal = Jadwal::findOrFail($id);
            $jadwal->absen()->delete();
            $jadwal->delete();

            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal dan absensi terkait berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.jadwal.index')->with('error', 'Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }
}
