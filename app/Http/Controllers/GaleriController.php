<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::latest('tanggal')->get();
        return view('galeri.index', compact('galeri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'      => 'required|max:50',
            'keterangan' => 'required',
            'kategori'   => 'required|in:Foto,Video',
            'tanggal'    => 'required|date',
            'file'       => 'required|file|mimes:jpeg,png,jpg,mp4,mkv,avi|max:20480',
        ]);

        $filePath = $request->file('file')->store('galeri', 'public');

        Galeri::create([
            'judul'      => $request->judul,
            'keterangan' => $request->keterangan,
            'kategori'   => $request->kategori,
            'tanggal'    => $request->tanggal,
            'file'       => $filePath,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul'      => 'required|max:50',
            'keterangan' => 'required',
            'kategori'   => 'required|in:Foto,Video',
            'tanggal'    => 'required|date',
            'file'       => 'nullable|file|mimes:jpeg,png,jpg,mp4,mkv,avi|max:20480',
        ]);

        $data = [
            'judul'      => $request->judul,
            'keterangan' => $request->keterangan,
            'kategori'   => $request->kategori,
            'tanggal'    => $request->tanggal,
        ];

        if ($request->hasFile('file')) {
            if ($galeri->file && Storage::disk('public')->exists($galeri->file)) {
                Storage::disk('public')->delete($galeri->file);
            }
            $data['file'] = $request->file('file')->store('galeri', 'public');
        }

        $galeri->update($data);

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->file && Storage::disk('public')->exists($galeri->file)) {
            Storage::disk('public')->delete($galeri->file);
        }

        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil dihapus!');
    }
}