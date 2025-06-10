<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DokumentasiFoto;
class DokumentasiFotoController extends Controller
{
    public function index()
    {
        return view('upload-foto');
    }

    public function store(Request $request)
    {
        $request->validate([
            'weekly_note' => 'required|integer|min:1',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'captions.*' => 'nullable|string'
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                 if ($photo) {
                $path = $photo->store('dokumentasi', 'public');

                DokumentasiFoto::create([
                    'proyek_id' => 1, // GANTI ini dengan ID proyek yang benar
                    'minggu_ke' => $request->weekly_note,
                    'file_path' => $path,
                    'caption' => $request->captions[$index] ?? ''
                ]);
            }
        }

        return back()->with('success', 'Dokumentasi foto berhasil diupload.');
    }
}
}