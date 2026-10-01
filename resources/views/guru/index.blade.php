@extends('admin')

@section('content')

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        vertical-align: middle;
    }

    th {
        background-color: #f4f4f4;
    }

    .alert {
        color: green;
        font-weight: bold;
    }

    img.thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }

    .btn-tambah {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-tambah:hover {
        background-color: #0056b3;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-box {
        background: white;
        padding: 20px;
        border-radius: 5px;
        width: 400px;
        max-width: 90%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-box h3 {
        margin-top: 0;
    }

    .modal-box p {
        margin-bottom: 10px;
    }

    .modal-box label {
        display: block;
        margin-bottom: 4px;
        font-weight: bold;
    }

    .modal-box input,
    .modal-box select {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .modal-box button {
        padding: 8px 15px;
        margin-right: 5px;
        cursor: pointer;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .modal-box button[type="submit"] {
        background-color: #007bff;
        color: white;
        border: none;
    }

    .modal-box button[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>

<h2>Kelola Data Guru</h2>

@if(session('success'))
    <p class="alert">{{ session('success') }}</p>
@endif

@if($errors->any())
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin: 5px 0 0 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
    <h3>Daftar Guru</h3>
    <button type="button" class="btn-tambah" onclick="bukaModal('tambahModal')">+ Tambah Guru</button>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama Guru</th>
            <th>NIP</th>
            <th>Mata Pelajaran</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($guru as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" class="thumb" alt="Foto Guru">
                    @else
                        -
                    @endif
                </td>
                <td>{{ $item->nama_guru }}</td>
                <td>{{ $item->nip }}</td>
                <td>{{ $item->mapel }}</td>
                <td>
                    <button type="button" onclick='openEditModal(@json($item))'>Edit</button>

                    <form action="{{ route('guru.destroy', $item->id_guru) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus data guru ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center;">Belum ada data guru.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div id="tambahModal" class="modal-overlay">
    <div class="modal-box">
        <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3>Tambah Guru Baru</h3>

            <p>
                <label>Nama Guru:</label>
                <input type="text" name="nama_guru" maxlength="40" value="{{ old('nama_guru') }}" required>
            </p>
            <p>
                <label>NIP:</label>
                <input type="text" name="nip" maxlength="15" value="{{ old('nip') }}" required>
            </p>
            <p>
                <label>Mata Pelajaran:</label>
                <input type="text" name="mapel" maxlength="40" value="{{ old('mapel') }}" required>
            </p>
            <p>
                <label>Foto:</label>
                <input type="file" name="foto" accept="image/*" required>
            </p>

            <button type="submit">Simpan</button>
            <button type="button" onclick="tutupModal('tambahModal')">Batal</button>
        </form>
    </div>
</div>

<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h3>Edit Data Guru</h3>

            <p>
                <label>Nama Guru:</label>
                <input type="text" id="edit_nama_guru" name="nama_guru" maxlength="40" required>
            </p>
            <p>
                <label>NIP:</label>
                <input type="text" id="edit_nip" name="nip" maxlength="15" required>
            </p>
            <p>
                <label>Mata Pelajaran:</label>
                <input type="text" id="edit_mapel" name="mapel" maxlength="40" required>
            </p>
            <p>
                <label>Ganti Foto (Opsional):</label>
                <input type="file" name="foto" accept="image/*">
            </p>

            <button type="submit">Update</button>
            <button type="button" onclick="tutupModal('editModal')">Batal</button>
        </form>
    </div>
</div>

<script>
    function bukaModal(id) {
        document.getElementById(id).classList.add('active');
    }
    function tutupModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    function openEditModal(data) {
        document.getElementById('editForm').action = "/guru/" + data.id_guru;

        document.getElementById('edit_nama_guru').value = data.nama_guru;
        document.getElementById('edit_nip').value = data.nip;
        document.getElementById('edit_mapel').value = data.mapel;

        bukaModal('editModal');
    }

    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                overlay.classList.remove('active');
            }
        });
    });
</script>
@endsection