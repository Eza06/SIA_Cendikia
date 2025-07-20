<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ResetCodeMail; // Kita akan buat ini nanti
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan form lupa password utama.
     */
    public function showForm()
    {
        return view('auth.forgotpass');
    }

    /**
     * Mengirim kode reset ke email pengguna.
     */
    public function sendResetCode(Request $request)
    {
        // 1. Validasi input email
        $request->validate(['email' => 'required|email|exists:users,email']);

        // 2. Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // 3. Generate kode acak (6 digit) dan waktu kedaluwarsa
        $code = random_int(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10); // Kode berlaku 10 menit

        // 4. Simpan kode dan waktu kedaluwarsa ke database
        // PENTING: Anda perlu menambahkan kolom `reset_code` (string, nullable) dan
        // `reset_code_expires_at` (timestamp, nullable) ke tabel 'users' Anda melalui migration.
        $user->reset_code = $code;
        $user->reset_code_expires_at = $expiresAt;
        $user->save();

        // 5. Kirim email yang berisi kode
        try {
            Mail::to($user->email)->send(new ResetCodeMail($code));
        } catch (\Exception $e) {
            // Jika email gagal terkirim, kembalikan dengan pesan error
            return back()->with('error', 'Gagal mengirim email verifikasi. Silakan coba lagi nanti.');
        }

        // 6. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('status', 'Kode verifikasi telah dikirim ke email Anda.');
    }


    /**
     * Menangani proses reset password menggunakan kode verifikasi.
     * Menggantikan fungsi handleForm Anda sebelumnya.
     */
    public function resetPasswordWithCode(Request $request)
    {
        // 1. Validasi semua input yang diperlukan
        $request->validate([
            'identifier' => 'required|string', // Bisa email atau kode unik
            'kode'       => 'required|numeric',
            'password'   => 'required|confirmed|min:6',
        ]);

        // 2. Cari user berdasarkan identifier (email atau kode siswa/guru)
        $userQuery = User::query();

        // Cek apakah identifier adalah email
        if (filter_var($request->identifier, FILTER_VALIDATE_EMAIL)) {
            $userQuery->where('email', $request->identifier);
        } else {
            // Jika bukan email, cari di kode_siswa atau kode_guru
            $userQuery->where(function ($query) use ($request) {
                $query->where('kode_siswa', $request->identifier)
                      ->orWhere('kode_guru', 'like', '%' . $request->identifier . '%');
            });
        }

        $user = $userQuery->first();

        // 3. Lakukan pengecekan user dan kode verifikasi
        if (!$user) {
            return back()->with('error', 'Data pengguna tidak ditemukan.');
        }

        if ($user->reset_code !== $request->kode) {
            return back()->with('error', 'Kode verifikasi tidak valid.');
        }

        if (Carbon::now()->isAfter($user->reset_code_expires_at)) {
            return back()->with('error', 'Kode verifikasi telah kedaluwarsa. Silakan minta kode baru.');
        }

        // 4. Jika semua valid, update password dan hapus kode reset
        $user->password = Hash::make($request->password);
        $user->reset_code = null; // Hapus kode agar tidak bisa dipakai lagi
        $user->reset_code_expires_at = null;
        $user->save();

        // 5. Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login kembali.');
    }
}
