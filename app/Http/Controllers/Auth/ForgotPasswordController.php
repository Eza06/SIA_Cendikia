<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function showForm()
    {
        return view('auth.forgotpass');
    }

    public function handleForm(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'email' => 'nullable|email',
            'kode' => 'nullable|string',
        ]);

        if (empty($request->email) && empty($request->kode)) {
            return back()->withErrors(['email' => 'Harap isi email atau kode.']);
        }

        $userQuery = User::query();

        if (!empty($request->email)) {
            $userQuery->where('email', $request->email);
        }

        if (!empty($request->kode)) {
            $userQuery->orWhere('kode_siswa', $request->kode)
                ->orWhere('kode_guru', $request->kode);
        }

        $user = $userQuery->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Data tidak ditemukan.']);
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        return redirect()->route('welcome')->with('status', 'Password berhasil direset. Silakan login kembali.');
    }

    /**
     * Store a newly created resource in storage.
     */
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
    public function destroy(string $id)
    {
        //
    }
}
