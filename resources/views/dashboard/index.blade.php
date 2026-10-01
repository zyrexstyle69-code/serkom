@extends('admin')
@section('content')

<style>
    .table-dark th {
        color: #ffffff !important;
    }

    .stat-card {
        transition: all 0.2s ease-in-out;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }
</style>

<div class="container-fluid pt-4 px-4 pb-5">

    {{-- Header --}}
    <div class="mb-5">
        <h2 class="text-dark fw-bold mb-2">Dashboard</h2>
        <p class="text-muted mb-0">Selamat datang, {{ auth()->user()->name ?? 'Admin' }}!</p>
    </div>

    {{-- Statistik --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4 col-6">
            <div class="stat-card bg-white border rounded p-4 text-center h-100">
                <h6 class="text-muted mb-2">Total Siswa</h6>
                <h3 class="text-dark mb-0 fw-bold">{{ $totalSiswa }}</h3>
            </div>
        </div>

        <div class="col-md-4 col-6">
            <div class="stat-card bg-white border rounded p-4 text-center h-100">
                <h6 class="text-muted mb-2">Total Guru</h6>
                <h3 class="text-dark mb-0 fw-bold">{{ $totalGuru }}</h3>
            </div>
        </div>

        <div class="col-md-4 col-6">
            <div class="stat-card bg-white border rounded p-4 text-center h-100">
                <h6 class="text-muted mb-2">Ekstrakurikuler</h6>
                <h3 class="text-dark mb-0 fw-bold">{{ $totalEskul }}</h3>
            </div>
        </div>
    </div>

    {{-- Tabel Data Siswa Terbaru --}}
    <div class="bg-white border rounded p-4">
        <h5 class="text-dark mb-4 fw-bold">Data Siswa Terbaru</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="py-3 px-3" style="width: 60px;">No</th>
                        <th class="py-3 px-3">Nama</th>
                        <th class="py-3 px-3">NISN</th>
                        <th class="py-3 px-3">Jenis Kelamin</th>
                        <th class="py-3 px-3">Tahun Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswaTerbaru as $index => $siswa)
                        <tr>
                            <td class="py-3 px-3">{{ $index + 1 }}</td>
                            <td class="py-3 px-3">{{ $siswa->nama_siswa }}</td>
                            <td class="py-3 px-3">{{ $siswa->nisn }}</td>
                            <td class="py-3 px-3">{{ $siswa->jenis_kelamin }}</td>
                            <td class="py-3 px-3">{{ $siswa->tahun_masuk }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Belum ada data siswa
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection