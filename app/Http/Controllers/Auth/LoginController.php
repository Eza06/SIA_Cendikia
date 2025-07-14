<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.']);
        }

        $currentSessionId = session()->getId();

        // Jika user sudah punya session yang berbeda
        if ($user->last_session_id && $user->last_session_id !== $currentSessionId) {
            session([
                'pending_login_user_id' => $user->id,
                'pending_login_email'   => $user->email,
                'pending_login_name'    => $user->name,
                'pending_login_password'=> $request->password, // hanya untuk sementara (harus hati-hati)
            ]);

            return redirect()->route('login')->with('show_force_login', true);
        }

        // Login normal
        Auth::login($user);
        $request->session()->regenerate();

        $user->last_session_id = session()->getId();
        $user->save();

        return $this->redirectByRole($user);
    }

    public function forceLogin(Request $request)
    {
        $userId   = session('pending_login_user_id');
        $email    = session('pending_login_email');
        $password = session('pending_login_password');

        if (!$userId || !$email || !$password) {
            return redirect()->route('login')->withErrors(['email' => 'Data login tidak valid.']);
        }

        $user = User::find($userId);

        if (!$user || !Hash::check($password, $user->password)) {
            return redirect()->route('login')->withErrors(['email' => 'Login ulang gagal.']);
        }

        // Hapus sesi lama
        if ($user->last_session_id) {
            DB::table('sessions')->where('id', $user->last_session_id)->delete();
        }

        // Login baru
        Auth::login($user);
        $request->session()->regenerate();

        $user->last_session_id = session()->getId();
        $user->save();

        // Bersihkan data login sementara
        session()->forget([
            'pending_login_user_id',
            'pending_login_email',
            'pending_login_name',
            'pending_login_password',
        ]);

        return $this->redirectByRole($user);
    }

    public function logout(Request $request)
    {
        if ($user = Auth::user()) {
            $user->last_session_id = null;
            $user->save();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function redirectByRole($user)
    {
        return match ($user->role) {
            'ADMIN' => redirect()->route('admin.dashboard'),
            'GURU'  => redirect()->route('guru.dashboard'),
            'MURID' => redirect()->route('siswa.dashboard'),
            default => redirect()->route('welcome'),
        };
    }
}
