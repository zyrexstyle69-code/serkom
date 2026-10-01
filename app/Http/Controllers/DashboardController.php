<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Ekstrakurikuler;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total dari masing-masing tabel
        $totalSiswa = Siswa::count();
        $totalGuru  = Guru::count();
        $totalEskul = Ekstrakurikuler::count();

        // Ambil 5 siswa terbaru (urut dari yang paling baru masuk)
        $siswaTerbaru = Siswa::orderBy('id_siswa', 'desc')->take(5)->get();

        return view('dashboard.index', compact(
            'totalSiswa',
            'totalGuru',
            'totalEskul',
            'siswaTerbaru'
        ));
    }
}