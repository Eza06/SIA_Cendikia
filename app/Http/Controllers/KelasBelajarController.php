<?php

namespace App\Http\Controllers;

use App\Models\KelasBelajar;
use Illuminate\Http\Request;

class KelasBelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelasBelajar = KelasBelajar::latest()->get();
        return view('admin.kelasbelajar.index', compact('kelasBelajar'));
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
            'nama_kelas' => 'required|string|max:255',
        ]);
    
        // Simpan data mapel
        KelasBelajar::create([
            'nama_kelas' => $request->nama_kelas,
        ]);
    
        return redirect()->back()->with('success', 'Data Kelas berhasil disimpan.');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(KelasBelajar $kelasBelajar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KelasBelajar $kelasBelajar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);
    
        // Ambil data mapel berdasarkan ID
        $kelasBelajar = KelasBelajar::findOrFail($id);
    
        // Update data
        $kelasBelajar->update([
            'nama_kelas' => $request->nama_kelas,
        ]);
    
        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Kelas Belajar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelasBelajar = KelasBelajar::findOrFail($id);
        $kelasBelajar->delete();
        return redirect(route('admin.kelasbelajar.index'))->with('success', 'Data Kelas Belajar berhasil di hapus ');
    }

}