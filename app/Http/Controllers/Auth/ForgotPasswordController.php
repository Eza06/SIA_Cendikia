<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Mail\ResetCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan form lupa password utama untuk Admin dan Guru.
     */
    public function showForm()
    {
        return view('auth.forgotpass');
    }

    /**
     * Mengirim kode reset ke email pengguna (Admin/Guru).
     */
    public function sendResetCode(Request $request)
    {
        // 1. Validasi input email
        $request->validate(['email' => 'required|email|exists:users,email']);

        // 2. Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Pastikan user bukan murid
        if ($user->role === 'MURID') {
            return back()->with('error', 'Fitur ini tidak tersedia untuk siswa. Silakan gunakan halaman lupa password siswa.');
        }

        // 3. Generate kode acak (6 digit) dan waktu kedaluwarsa
        $code = random_int(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10); // Kode berlaku 10 menit

        // 4. Simpan kode dan waktu kedaluwarsa ke database
        $user->reset_code = $code;
        $user->reset_code_expires_at = $expiresAt;
        $user->save();

        // 5. Kirim email yang berisi kode
        try {
            Mail::to($user->email)->send(new ResetCodeMail($code));
        } catch (\Exception $e) {
            Log::error('Mail sending failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim email verifikasi. Silakan coba lagi nanti atau hubungi admin.');
        }

        // 6. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('status', 'Kode verifikasi telah dikirim ke email Anda.');
    }


    /**
     * Menangani proses reset password menggunakan kode verifikasi (Admin/Guru).
     */
    public function resetPasswordWithCode(Request $request)
    {
        // 1. Validasi semua input yang diperlukan
        $request->validate([
            'identifier' => 'required|string', // Bisa email atau kode unik
            'kode'       => 'required|numeric',
            'password'   => 'required|confirmed|min:6',
        ]);

        $user = null;

        // 2. Cari user berdasarkan identifier (email atau kode unik)
        if (filter_var($request->identifier, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->identifier)->first();
        } else {
            $guru = Guru::where('kode_guru', $request->identifier)->first();
            if ($guru) {
                $user = $guru->user;
            }
        }

        // 3. Lakukan pengecekan user dan kode verifikasi
        if (!$user) {
            return back()->with('error', 'Data pengguna dengan email atau kode unik tersebut tidak ditemukan.');
        }

        if ($user->reset_code != $request->kode) {
            return back()->with('error', 'Kode verifikasi tidak valid.');
        }

        if (Carbon::now()->isAfter($user->reset_code_expires_at)) {
            return back()->with('error', 'Kode verifikasi telah kedaluwarsa. Silakan minta kode baru.');
        }

        // 4. Jika semua valid, update password dan hapus kode reset
        $user->password = Hash::make($request->password);
        $user->reset_code = null;
        $user->reset_code_expires_at = null;
        $user->save();

        // 5. Redirect ke halaman login yang sesuai dengan peran (role)
        if ($user->role === 'ADMIN') {
            return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login kembali.');
        } elseif ($user->role === 'GURU') {
            return redirect()->route('login.guru')->with('status', 'Password berhasil direset. Silakan login kembali.');
        }

        return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login kembali.');
    }

    /*
    |--------------------------------------------------------------------------
    | LUPA PASSWORD KHUSUS SISWA (TANPA KODE VERIFIKASI)
    |--------------------------------------------------------------------------
    */

    /**
     * Menampilkan form untuk siswa memasukkan email.
     */
    public function showStudentForgotForm()
    {
        return view('auth.murid.forgot');
    }

    /**
     * Memvalidasi email siswa dan mengarahkan ke form reset.
     */
    public function handleStudentEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->where('role', 'MURID')->first();

        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar sebagai siswa.');
        }

        // Redirect ke halaman reset dengan membawa email
        return redirect()->route('password.reset.siswa', ['email' => $user->email]);
    }

    /**
     * Menampilkan form untuk siswa mengatur password baru.
     */
    public function showStudentResetForm(Request $request)
    {
        if (!$request->has('email')) {
            return redirect()->route('password.request.siswa')->with('error', 'Sesi tidak valid.');
        }

        return view('auth.murid.reset', ['email' => $request->email]);
    }

    /**
     * Memproses dan menyimpan password baru siswa.
     */
    public function updateStudentPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('email', $request->email)->where('role', 'MURID')->first();

        if (!$user) {
            return redirect()->route('password.request.siswa')->with('error', 'Terjadi kesalahan. Pengguna tidak ditemukan.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login.siswa')->with('status', 'Password berhasil diubah! Silakan login.');
    }
}
