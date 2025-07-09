<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $admin = User::where('role', 'ADMIN')->get();

        return view('admin.settings', compact('admin'));
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'ADMIN',
        ]);

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan');
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
    public function destroy($id)
    {
        // Cegah hapus diri sendiri
        if (auth()->id() == $id) {
            return redirect()->back()->with('success', 'Tidak dapat menghapus akun sendiri.');
        }

        $admin = \App\Models\User::find($id);

        if (!$admin) {
            return redirect()->back()->with('success', 'Admin tidak ditemukan.');
        }

        $admin->delete();

        return redirect()->route('admin.settings')->with('success', 'Admin berhasil dihapus.');
    }
}
