@extends('admin')

@section('content')
<!-- HAPUS DOCTYPE, HTML, HEAD, BODY DI SINI -->

<style>
    /* Hapus body { margin: 20px; } agar tidak merusak layout admin */
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: middle; }
    th { background-color: #f4f4f4; }
    .alert { color: green; font-weight: bold; }

    /* Tombol Tambah */
    .btn-tambah {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }
    .btn-tambah:hover { background-color: #0056b3; }

    /* Modal pakai div */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: white;
        padding: 20px;
        border-radius: 5px;
        width: 400px;
        max-width: 90%;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        max-height: 90vh;
        overflow-y: auto;
    }
    .modal-box h3 { margin-top: 0; }
    .modal-box p { margin-bottom: 10px; }
    .modal-box label { display: block; margin-bottom: 4px; font-weight: bold; }
    .modal-box input, .modal-box select {
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
    .modal-box button[type="submit"]:hover { background-color: #0056b3; }
</style>

<!-- KONTEN DIMULAI DI SINI -->
<h2>Kelola Data Pengguna</h2>

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

<!-- 1. TOMBOL TAMBAH & TABEL -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
    <h3>Daftar Pengguna</h3>
    <button type="button" class="btn-tambah" onclick="bukaModal('tambahModal')">+ Tambah User</button>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->username }}</td>
                <td><strong>{{ $item->role }}</strong></td>
                <td>
                    <button type="button" onclick='openEditModal(@json($item))'>Edit</button>

                    <form action="{{ route('user.destroy', $item->id_user) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus user ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center;">Belum ada data user.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- 2. MODAL TAMBAH USER -->
<div id="tambahModal" class="modal-overlay">
    <div class="modal-box">
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <h3>Tambah User Baru</h3>

            <p>
                <label>Username:</label>
                <input type="text" name="username" maxlength="30" value="{{ old('username') }}" required>
            </p>
            <p>
                <label>Password (Min. 6 Karakter):</label>
                <input type="password" name="password" required>
            </p>
            <p>
                <label>Role:</label>
                <select name="role" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="Admin">Admin</option>
                    <option value="Operator">Operator</option>
                </select>
            </p>

            <button type="submit">Simpan User</button>
            <button type="button" onclick="tutupModal('tambahModal')">Batal</button>
        </form>
    </div>
</div>

<!-- 3. MODAL EDIT USER -->
<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <h3>Edit User</h3>

            <p>
                <label>Username:</label>
                <input type="text" id="edit_username" name="username" maxlength="30" required>
            </p>
            <p>
                <label>Role:</label>
                <select id="edit_role" name="role" required>
                    <option value="Admin">Admin</option>
                    <option value="Operator">Operator</option>
                </select>
            </p>
            <p>
                <label>Password Baru (Kosongkan jika tidak diubah):</label>
                <input type="password" name="password" placeholder="Password Baru">
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
        document.getElementById('editForm').action = "/user/" + data.id_user;

        document.getElementById('edit_username').value = data.username;
        document.getElementById('edit_role').value = data.role;

        bukaModal('editModal');
    }

    // Tutup modal jika klik di luar area modal
    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                overlay.classList.remove('active');
            }
        });
    });
</script>
@endsection