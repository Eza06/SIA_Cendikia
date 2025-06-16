<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginGuruController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.loginguru');
    }

    // Menangani proses login guru
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Login dengan tambahan kondisi role guru
        $credentials = $request->only('email', 'password');

        if (Auth::attempt(array_merge($credentials, ['role' => 'GURU']))) {
            $request->session()->regenerate();
            return redirect()->route('guru.dashboard'); // Ubah sesuai rute dashboard guru kamu
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau Anda bukan guru.',
        ]);
    }

    // Logout guru
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login-guru');
    }
}
