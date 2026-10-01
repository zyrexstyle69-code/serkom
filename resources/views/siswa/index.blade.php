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
    }

    th {
        background-color: #f4f4f4;
    }

    .alert {
        color: green;
        font-weight: bold;
    }

    .btn-tambah {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
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

<h2>Kelola Data Siswa</h2>

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
    <h3>Daftar Siswa</h3>
    <button type="button" class="btn-tambah" onclick="bukaModal('tambahModal')">+ Tambah Siswa</button>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NISN</th>
            <th>Nama Siswa</th>
            <th>Jenis Kelamin</th>
            <th>Tahun Masuk</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($siswa as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nisn }}</td>
                <td>{{ $item->nama_siswa }}</td>
                <td>{{ $item->jenis_kelamin }}</td>
                <td>{{ $item->tahun_masuk }}</td>
                <td>
                    <button type="button" onclick='openEditModal(@json($item))'>Edit</button>

                    <form action="{{ route('siswa.destroy', $item->id_siswa) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align: center;">Belum ada data siswa.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div id="tambahModal" class="modal-overlay">
    <div class="modal-box">
        <form action="{{ route('siswa.store') }}" method="POST">
            @csrf
            <h3>Tambah Siswa Baru</h3>

            <p>
                <label>NISN (10 Digit):</label>
                <input type="text" name="nisn" maxlength="10" value="{{ old('nisn') }}" required>
            </p>
            <p>
                <label>Nama Siswa:</label>
                <input type="text" name="nama_siswa" maxlength="40" value="{{ old('nama_siswa') }}" required>
            </p>
            <p>
                <label>Jenis Kelamin:</label>
                <select name="jenis_kelamin" required>
                    <option value="">-- Pilih Gender --</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </p>
            <p>
                <label>Tahun Masuk (YYYY):</label>
                <input type="number" name="tahun_masuk" min="2000" max="2099" value="{{ old('tahun_masuk') }}" required>
            </p>

            <button type="submit">Simpan</button>
            <button type="button" onclick="tutupModal('tambahModal')">Batal</button>
        </form>
    </div>
</div>

<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <h3>Edit Data Siswa</h3>

            <p>
                <label>NISN:</label>
                <input type="text" id="edit_nisn" name="nisn" maxlength="10" required>
            </p>
            <p>
                <label>Nama Siswa:</label>
                <input type="text" id="edit_nama_siswa" name="nama_siswa" maxlength="40" required>
            </p>
            <p>
                <label>Jenis Kelamin:</label>
                <select id="edit_jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </p>
            <p>
                <label>Tahun Masuk:</label>
                <input type="number" id="edit_tahun_masuk" name="tahun_masuk" required>
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
        document.getElementById('editForm').action = "/siswa/" + data.id_siswa;

        document.getElementById('edit_nisn').value = data.nisn;
        document.getElementById('edit_nama_siswa').value = data.nama_siswa;
        document.getElementById('edit_jenis_kelamin').value = data.jenis_kelamin;
        document.getElementById('edit_tahun_masuk').value = data.tahun_masuk;

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