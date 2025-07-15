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

        if (! is_null($user->last_session_id) && $user->last_session_id !== $currentSessionId) {
            session([
                'pending_login_user_id' => $user->id,
                'pending_login_email'   => $user->email,
                'pending_login_name'    => $user->name,
                'pending_login_password'=> $request->password,
            ]);

            return redirect()->route('login')->with('show_force_login', true);
        }

        Auth::login($user);
        $request->session()->regenerate();

        $user->last_session_id = session()->getId();
        $user->save();

        // ✅ Redirect langsung berdasarkan role
        return $this->redirectToDashboard($user->role);
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

        if ($user->last_session_id) {
            DB::table('sessions')->where('id', $user->last_session_id)->delete();
        }

        Auth::login($user);
        $request->session()->regenerate();

        $user->last_session_id = session()->getId();
        $user->save();

        session()->forget([
            'pending_login_user_id',
            'pending_login_email',
            'pending_login_name',
            'pending_login_password',
        ]);

        // ✅ Redirect langsung berdasarkan role
        return $this->redirectToDashboard($user->role);
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

    // ✅ Fungsi redirect singkat sebagai pengganti redirectByRole()
    private function redirectToDashboard($role)
    {
        return match ($role) {
            'ADMIN' => redirect()->route('admin.dashboard'),
        };
    }
}
