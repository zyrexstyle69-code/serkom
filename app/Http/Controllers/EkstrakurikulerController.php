<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $ekskul = Ekstrakurikuler::latest()->get();
        return view('ekstrakurikuler.index', compact('ekskul'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_ekskul' => 'required|max:40',
            'pembina'     => 'required|max:40',
            'hari'        => 'required',
            'jam'         => 'required',
            'deskripsi'   => 'required',
            'gambar'      => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data['jadwal_latihan'] = $request->hari . ', ' . $request->jam;
        $data['gambar']         = $request->file('gambar')->store('ekstrakurikuler', 'public');

        Ekstrakurikuler::create($data);

        return redirect()->route('ekstrakurikuler.index')->with('success', 'Data ekstrakurikuler berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);

        $data = $request->validate([
            'nama_ekskul' => 'required|max:40',
            'pembina'     => 'required|max:40',
            'hari'        => 'required',
            'jam'         => 'required',
            'deskripsi'   => 'required',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data['jadwal_latihan'] = $request->hari . ', ' . $request->jam;

        if ($request->hasFile('gambar')) {
            if ($ekskul->gambar && Storage::disk('public')->exists($ekskul->gambar)) {
                Storage::disk('public')->delete($ekskul->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('ekstrakurikuler', 'public');
        }

        $ekskul->update($data);

        return redirect()->route('ekstrakurikuler.index')->with('success', 'Data ekstrakurikuler berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);

        if ($ekskul->gambar && Storage::disk('public')->exists($ekskul->gambar)) {
            Storage::disk('public')->delete($ekskul->gambar);
        }

        $ekskul->delete();

        return redirect()->route('ekstrakurikuler.index')->with('success', 'Data ekstrakurikuler berhasil dihapus!');
    }
}