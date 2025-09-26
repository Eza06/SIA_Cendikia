<?php
namespace App\Http\Controllers;

use App\Exports\SiswaExport;
use App\Exports\SiswaTemplateExport;
use App\Imports\SiswaImport;
use App\Models\KelasBelajar;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa dengan fungsionalitas filter.
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

        $kelasBelajar = KelasBelajar::orderByRaw("CAST(SUBSTRING_INDEX(nama_kelas, '-', 1) AS UNSIGNED), nama_kelas")->get();

        return view('admin.siswa.index', compact('murid', 'kelasBelajar'));
    }

    /**
     * Menampilkan form untuk membuat siswa baru.
     */
    public function create()
    {
        $user         = Auth::user();
        $kelasBelajar = KelasBelajar::all();
        return view('admin.siswa.create', compact('user', 'kelasBelajar'));
    }

    /**
     * Menyimpan data siswa baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|string|min:6',
            'jenis_kelamin'    => 'required',
            'alamat'           => 'required|string',
            'asal_sekolah'     => 'required|string',
            'kelas_belajar_id' => 'required|exists:kelas_belajar,id',
            'education_level'  => 'required',
            'no_telpon'        => 'required|string|max:20',
            'kelas'            => 'required',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'SISWA',
        ]);

        $latest     = Siswa::where('kode_siswa', 'like', 'S2025%')->orderBy('id', 'desc')->first();
        $lastNumber = $latest ? (int) substr($latest->kode_siswa, 5) : 0;
        $newCode    = 'S2025' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        Siswa::create([
            'user_id'          => $user->id,
            'kode_siswa'       => $newCode,
            'jenis_kelamin'    => $request->jenis_kelamin,
            'alamat'           => $request->alamat,
            'asal_sekolah'     => $request->asal_sekolah,
            'no_telpon'        => $request->no_telpon,
            'education_level'  => $request->education_level,
            'kelas'            => $request->kelas,
            'kelas_belajar_id' => $request->kelas_belajar_id,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa baru berhasil disimpan.');
    }

    /**
     * Menampilkan form untuk mengedit data siswa.
     */
    public function edit(string $id)
    {
        $siswa        = Siswa::findOrFail($id);
        $kelasBelajar = KelasBelajar::all();
        return view('admin.siswa.edit', compact('siswa', 'kelasBelajar'));
    }

    /**
     * Memperbarui data siswa di dalam database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email',
            'jenis_kelamin'    => 'required',
            'asal_sekolah'     => 'required',
            'alamat'           => 'required|string',
            'education_level'  => 'required',
            'kelas'            => 'required',
            'kelas_belajar_id' => 'required',
            'no_telpon'        => 'required|string',
        ]);

        $siswa = Siswa::findOrFail($id);
        $user  = $siswa->user;

        $user->name  = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $siswa->update($request->except(['name', 'email', 'password']));

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa dari database.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        if ($siswa->user) {
            $siswa->user->delete();
        }
        $siswa->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    /**
     * Menghapus beberapa data siswa yang dipilih.
     */
    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('admin.siswa.index')->with('error', 'Tidak ada siswa yang dipilih.');
        }

        $siswas = Siswa::whereIn('id', $ids)->get();
        foreach ($siswas as $siswa) {
            if ($siswa->user) {
                $siswa->user->delete();
            }
            $siswa->delete();
        }

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa yang dipilih berhasil dihapus.');
    }

    /**
     * Menangani ekspor data siswa ke Excel.
     */
    public function export(Request $request)
    {
        $filters  = $request->only(['jenjang', 'kelas', 'kelas_belajar_id']);
        $fileName = 'data-siswa-' . date('Ymd_His') . '.xlsx';
        return Excel::download(new SiswaExport($filters), $fileName);
    }

    /**
     * Menangani impor data siswa dari Excel.
     */
    public function import(Request $request)
    {
        $request->validate(['file_siswa' => 'required|mimes:xlsx,xls']);
        try {
            Excel::import(new SiswaImport, $request->file('file_siswa'));
            return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diimpor!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures      = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris " . $failure->row() . ": " . implode(", ", $failure->errors());
            }
            return redirect()->route('admin.siswa.index')->with('error', "Impor Gagal: <br>" . implode("<br>", $errorMessages));
        } catch (\Exception $e) {
            return redirect()->route('admin.siswa.index')->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Menangani unduhan file template Excel.
     */
    public function downloadTemplate()
    {
        $fileName = 'template-import-siswa-' . date('dmy') . '.xlsx';

        return Excel::download(new SiswaTemplateExport, $fileName);
    }

    public function checkImport(Request $request)
    {
        $request->validate([
            'file_siswa' => 'required|mimes:xlsx,xls',
        ]);

        // Mulai transaksi database, tapi jangan pernah di-commit
        DB::beginTransaction();

        try {
            // Coba lakukan impor. Jika ada error validasi, akan ditangkap di bawah.
            Excel::import(new SiswaImport, $request->file('file_siswa'));

            // Jika tidak ada error sama sekali, berarti file valid
            // Kita rollback agar tidak ada data yang tersimpan
            DB::rollBack();
            return response()->json(['success' => true, 'message' => 'File valid dan siap untuk diimpor.']);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Jika ada error validasi, tangkap, format, dan kirim sebagai JSON
            DB::rollBack();
            $failures      = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                // Baris di Excel adalah row() + 1 (karena baris header tidak dihitung)
                $errorMessages[] = "Baris " . ($failure->row()) . ": " . implode(", ", $failure->errors());
            }
            return response()->json(['success' => false, 'errors' => $errorMessages], 422);

        } catch (\Exception $e) {
            // Jika ada error lain (misal, error database)
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan tak terduga: ' . $e->getMessage()], 500);
        }
    }
}
