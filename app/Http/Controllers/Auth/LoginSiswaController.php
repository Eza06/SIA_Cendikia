<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginSiswaController extends Controller
{
    public function index()
    {
        return view('auth.loginsiswa');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->where('role', 'MURID')
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah, atau Anda bukan siswa.',
            ]);
        }

        $currentSessionId = session()->getId();

        // ✅ Jangan trigger force login kalau last_session_id masih null (pertama kali)
        if (! is_null($user->last_session_id) && $user->last_session_id !== $currentSessionId) {
            session([
                'force_login_user_id_siswa'  => $user->id,
                'force_login_email_siswa'    => $user->email,
                'force_login_name_siswa'     => $user->name,
                'force_login_password_siswa' => $request->password,
            ]);

            return redirect()->route('login.siswa')->with('show_force_login_siswa', true);
        }

        Auth::login($user);
        $request->session()->regenerate();
        $user->last_session_id = session()->getId();
        $user->save();

        return redirect()->route('siswa.dashboard');
    }

    public function forceLogin(Request $request)
    {
        $email    = session('force_login_email_siswa');
        $password = session('force_login_password_siswa');

        if (! $email || ! $password) {
            return redirect()->route('login.siswa')->withErrors([
                'email' => 'Data login tidak valid.',
            ]);
        }

        if (Auth::attempt(['email' => $email, 'password' => $password, 'role' => 'MURID'])) {
            $user = Auth::user();
            session()->regenerate();

            if ($user->last_session_id) {
                DB::table('sessions')->where('id', $user->last_session_id)->delete();
            }

            $user->last_session_id = session()->getId();
            $user->save();

            session()->forget([
                'force_login_user_id_siswa',
                'force_login_email_siswa',
                'force_login_name_siswa',
                'force_login_password_siswa',
            ]);

            return redirect()->route('siswa.dashboard');
        }

        return redirect()->route('login.siswa')->withErrors([
            'email' => 'Login ulang gagal.',
        ]);
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

        return redirect('/login-siswa');
    }
}
