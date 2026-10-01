<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->get();
        return view('berita.index', compact('berita'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'   => 'required|max:50',
            'isi'     => 'required',
            'tanggal' => 'required|date',
            'gambar'  => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $gambarPath = $request->file('gambar')->store('berita', 'public');
        $idUser     = Auth::id() ?? User::query()->value('id_user');

        if (!$idUser) {
            return back()
                ->withInput()
                ->withErrors(['id_user' => 'Tidak ada user di database. Buat user terlebih dahulu.']);
        }

        Berita::create([
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'tanggal' => $request->tanggal,
            'gambar'  => $gambarPath,
            'id_user' => $idUser,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul'   => 'required|max:50',
            'isi'     => 'required',
            'tanggal' => 'required|date',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'tanggal' => $request->tanggal,
        ];

        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}