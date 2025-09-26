<?php
namespace App\Http\Controllers;

// Model yang dibutuhkan untuk mengambil data
use App\Models\Absen;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\User;

// Class bawaan Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin beserta data statistik untuk grafik.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // --- Data Pengguna & Statistik Umum ---
        $user        = Auth::user();
        $jumlahSiswa = Siswa::count();
        $jumlahGuru  = Guru::count();
        $mapelAll    = Mapel::count();

        // --- Kalkulasi Data untuk Pie Chart Kehadiran ---

        // 1. Hitung total absensi sebagai dasar pembagian
        $totalAbsensi = Absen::count();

        // 2. Hitung jumlah untuk setiap status yang Anda gunakan
        $jumlahHadir = Absen::where('status', 'HADIR')->count();
        $jumlahIzin  = Absen::where('status', 'IZIN')->count();
        // Diperbarui: Mencari status 'TANPA KETERANGAN'
        $jumlahTanpaKeterangan = Absen::where('status', 'TANPA KETERANGAN')->count();

        // 3. Kalkulasi persentase untuk setiap status
        $persentaseHadir           = $totalAbsensi > 0 ? round(($jumlahHadir / $totalAbsensi) * 100, 1) : 0;
        $persentaseIzin            = $totalAbsensi > 0 ? round(($jumlahIzin / $totalAbsensi) * 100, 1) : 0;
        $persentaseTanpaKeterangan = $totalAbsensi > 0 ? round(($jumlahTanpaKeterangan / $totalAbsensi) * 100, 1) : 0;

        // 4. Kirim semua data ke view
        return view('admin.dashboard', compact(
            'user',
            'jumlahSiswa',
            'jumlahGuru',
            'mapelAll',
            'persentaseHadir',
            'persentaseIzin',
            'persentaseTanpaKeterangan' // Variabel baru dikirim
        ));
    }

    /**
     * Menyimpan data admin baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAdmin(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // Membuat user baru dengan role 'ADMIN'
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password), // Enkripsi password untuk keamanan
            'role'     => 'ADMIN',
        ]);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Admin berhasil ditambahkan.');
    }

    // Fungsi-fungsi lain yang tidak digunakan bisa dibiarkan kosong atau dihapus
    public function create()
    { /* ... */}
    public function store(Request $request)
    { /* ... */}
    public function show(string $id)
    { /* ... */}
    public function edit(string $id)
    { /* ... */}
    public function update(Request $request, string $id)
    { /* ... */}
    public function destroy(string $id)
    { /* ... */}
}
