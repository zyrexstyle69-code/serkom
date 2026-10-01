<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        return view('siswa.index', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn'          => 'required|digits:10|unique:siswa,nisn',
            'nama_siswa'    => 'required|max:40',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tahun_masuk'   => 'required|digits:4',
        ]);

        Siswa::create($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nisn'          => 'required|digits:10|unique:siswa,nisn,' . $id . ',id_siswa',
            'nama_siswa'    => 'required|max:40',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tahun_masuk'   => 'required|digits:4',
        ]);

        $siswa->update($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data berhasil dihapus!');
    }
}