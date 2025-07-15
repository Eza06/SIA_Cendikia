<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginGuruController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.loginguru');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->where('role', 'GURU')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah, atau Anda bukan guru.']);
        }

        $currentSessionId = session()->getId();

        if (! is_null($user->last_session_id) && $user->last_session_id !== $currentSessionId) {
            session([
                'force_login_user_id_guru' => $user->id,
                'force_login_email_guru' => $user->email,
                'force_login_name_guru' => $user->name,
                'force_login_password_guru' => $request->password,
            ]);

            return redirect()->route('login.guru')->with('show_force_login_guru', true);
        }
        Auth::login($user);
        $request->session()->regenerate();
        $user->last_session_id = session()->getId();
        $user->save();

        return redirect()->route('guru.dashboard');
    }

    public function forceLogin(Request $request)
    {
        $email = session('force_login_email_guru');
        $password = session('force_login_password_guru');

        if (!$email || !$password) {
            return redirect()->route('login.guru')->withErrors(['email' => 'Data login tidak valid.']);
        }

        if (Auth::attempt(['email' => $email, 'password' => $password, 'role' => 'GURU'])) {
            $user = Auth::user();
            session()->regenerate();

            // Hapus sesi lama
            if ($user->last_session_id) {
                DB::table('sessions')->where('id', $user->last_session_id)->delete();
            }

            // Simpan sesi baru
            $user->last_session_id = session()->getId();
            $user->save();

            // Bersihkan sesi sementara
            session()->forget([
                'force_login_user_id_guru',
                'force_login_email_guru',
                'force_login_name_guru',
                'force_login_password_guru',
            ]);

            return redirect()->route('guru.dashboard');
        }

        return redirect()->route('login.guru')->withErrors(['email' => 'Login ulang gagal.']);
    }


    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->last_session_id = null;
            $user->save();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login-guru');
    }
}
