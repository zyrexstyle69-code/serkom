<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::all();
        return view('guru.index', compact('guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required|max:40',
            'nip'       => 'required|max:15|unique:guru,nip',
            'mapel'     => 'required|max:40',
            'foto'      => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fotoPath = $request->file('foto')->store('guru', 'public');

        Guru::create([
            'nama_guru' => $request->nama_guru,
            'nip'       => $request->nip,
            'mapel'     => $request->mapel,
            'foto'      => $fotoPath,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nama_guru' => 'required|max:40',
            'nip'       => 'required|max:15|unique:guru,nip,' . $id . ',id_guru',
            'mapel'     => 'required|max:40',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nama_guru' => $request->nama_guru,
            'nip'       => $request->nip,
            'mapel'     => $request->mapel,
        ];

        if ($request->hasFile('foto')) {
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $guru->update($data);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus!');
    }
}