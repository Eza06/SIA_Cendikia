<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.loginsiswa');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

     public function login(Request $request)
     {
         $request->validate([
             'email' => 'required|email',
             'password' => 'required',
             
         ]);

         // Login dengan tambahan kondisi role guru
         $credentials = $request->only('email', 'password');

         if (Auth::attempt(array_merge($credentials, ['role' => 'MURID']))) {
             $request->session()->regenerate();
             return redirect()->route('siswa.dashboard'); // Ubah sesuai rute dashboard guru kamu
         }

         return back()->withErrors([
             'email' => 'Email atau password salah, atau Anda bukan Siswa.',
         ]);
     }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'login' => 'required', // email atau kode_siswa
    //         'password' => 'required',
    //     ]);

    //     $loginInput = $request->input('login');
    //     $password = $request->input('password');

    //     // 1. Coba cari berdasarkan email
    //     $user = User::where('email', $loginInput)
    //         ->where('role', 'MURID')
    //         ->first();

    //     // 2. Kalau tidak ketemu, coba cari berdasarkan kode_siswa di tabel siswa
    //     if (!$user) {
    //         $user = User::whereHas('siswa', function ($query) use ($loginInput) {
    //             $query->where('kode_siswa', $loginInput);
    //         })->where('role', 'MURID')->first();
    //     }

    //     // 3. Kalau user ditemukan dan password cocok
    //     if ($user && Hash::check($password, $user->password)) {
    //         Auth::login($user);
    //         $request->session()->regenerate();
    //         return redirect()->route('siswa.dashboard');
    //     }

    //     // 4. Kalau gagal login
    //     return back()->withErrors([
    //         'login' => 'Login gagal. Cek email/kode dan password Anda.',
    //     ]);
    // }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login-siswa');
    }
}
