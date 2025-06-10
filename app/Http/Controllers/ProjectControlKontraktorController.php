<?php

namespace App\Http\Controllers;

use App\Models\Kontraktor;
use Illuminate\Http\Request;

class ProjectControlKontraktorController extends Controller
{
    public function index()
    {
        $kontraktors = Kontraktor::all();
        return view('projectcontrol.kontraktors.index', compact('kontraktors'));
    }

    public function create()
    {
        return view('kontraktors.create');
    }

    public function store(Request $request)
    {
    $request->validate([
        'nama_kontraktor' => 'required|max:255',
        'alamat' => 'required',
        'telepon' => 'required|regex:/^[0-9+\s()-]+$/'
    ]);

    Kontraktor::create($request->all());
    return redirect()->route('kontraktors.index')->with('success', 'Data kontraktor berhasil disimpan.');
    }

    public function edit(Kontraktor $kontraktor)
    {
        return view('kontraktors.edit', compact('kontraktor'));
    }

    public function update(Request $request, Kontraktor $kontraktor)
    {
    $request->validate([
        'nama_kontraktor' => 'required|max:255',
        'alamat' => 'required',
        'telepon' => 'required|regex:/^[0-9+\s()-]+$/'
    ]);

    $kontraktor->update($request->all());
    return redirect()->route('kontraktors.index')->with('success', 'Data kontraktor berhasil diupdate.');
    }

    public function destroy(Kontraktor $kontraktor)
    {
        $kontraktor->delete();
        return redirect()->route('kontraktors.index');
    }
}
