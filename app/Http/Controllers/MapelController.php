<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapel = Mapel::all();
        return view('admin.mapel.index', compact('mapel'));
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
        ]);
    
        // Simpan data mapel
        Mapel::create([
            'name' => $request->name,
        ]);
    
        return redirect()->back()->with('success', 'Data mata pelajaran berhasil disimpan.');
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
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        // Ambil data mapel berdasarkan ID
        $mapel = Mapel::findOrFail($id);
    
        // Update data
        $mapel->update([
            'name' => $request->name,
        ]);
    
        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Mapel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();
        return redirect(route('admin.mapel.index'))->with('success', 'Data Mata Pelajaran berhasil di hapus ');
    }
}
