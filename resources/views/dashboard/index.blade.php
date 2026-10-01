@extends('admin')
@section('content')

<style>
    .table-dark th {
        color: #ffffff !important;
    }
</style>

<div class="container-fluid pt-4 px-4">

    <div class="mb-4">
        <h2 class="text-dark fw-bold">Dashboard</h2>
        <p class="text-muted">Selamat datang, Favian!</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="bg-white border rounded p-3 text-center">
                <h6 class="text-muted mb-1">Total Siswa</h6>
                <h3 class="text-dark mb-0 fw-bold">520</h3>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="bg-white border rounded p-3 text-center">
                <h6 class="text-muted mb-1">Total Guru</h6>
                <h3 class="text-dark mb-0 fw-bold">45</h3>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="bg-white border rounded p-3 text-center">
                <h6 class="text-muted mb-1">Jurusan</h6>
                <h3 class="text-dark mb-0 fw-bold">3</h3>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="bg-white border rounded p-3 text-center">
                <h6 class="text-muted mb-1">Ekstrakurikuler</h6>
                <h3 class="text-dark mb-0 fw-bold">12</h3>
            </div>
        </div>
    </div>

    <div class="bg-white border rounded p-3">
        <h5 class="text-dark mb-3 fw-bold">Data Siswa Terbaru</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ahmad Fauzi</td>
                        <td>RPL</td>
                        <td>Aktif</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Siti Aminah</td>
                        <td>TKJ</td>
                        <td>Aktif</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Budi Santoso</td>
                        <td>AKL</td>
                        <td>Aktif</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Dewi Lestari</td>
                        <td>RPL</td>
                        <td>Pending</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection