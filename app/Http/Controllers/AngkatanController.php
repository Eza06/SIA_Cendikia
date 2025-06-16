<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use Illuminate\Http\Request;

class AngkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahunAngkatan = Angkatan::all();
        return view('admin.angkatan.index', compact('tahunAngkatan'));
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
            'tahun_angkatan' => 'required|string|max:255',
        ]);
    
        Angkatan::create([
            'tahun_angkatan' => $request->tahun_angkatan,
        ]);
    
        return redirect()->route('admin.angkatan.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Angkatan $angkatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Angkatan $angkatan)
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
            'tahun_angkatan' => 'required|string|max:255',
        ]);
    
        // Ambil data mapel berdasarkan ID
        $tahunAngkatan = Angkatan::findOrFail($id);
    
        // Update data
        $tahunAngkatan->update([
            ' tahun_angkatan' => $request->tahunAngkatan,
        ]);
    
        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Mapel berhasil diperbarui.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tahunAngkatan = Angkatan::findOrFail($id);
        $tahunAngkatan->delete();
        return redirect(route('admin.angkatan.index'))->with('success', 'Data Tahun Ajaran berhasil di hapus ');
    }
}
