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
        background: #f4f4f4;
    }

    .alert {
        color: green;
        font-weight: bold;
    }

    img.thumb {
        width: 70px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }

    .btn-tambah {
        background: #007bff;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-tambah:hover {
        background: #0056b3;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-box {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        width: 500px;
        max-width: 90%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, .2);
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
    .modal-box select,
    .modal-box textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .modal-box textarea {
        height: 70px;
        resize: vertical;
    }

    .modal-box button {
        padding: 8px 15px;
        margin-right: 5px;
        cursor: pointer;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .modal-box button[type="submit"] {
        background: #007bff;
        color: #fff;
        border: none;
    }

    .modal-box button[type="submit"]:hover {
        background: #0056b3;
    }

    .jadwal-row {
        display: flex;
        gap: 8px;
    }

    .jadwal-row select,
    .jadwal-row input {
        flex: 1;
    }

    .hint {
        color: #666;
        font-size: 12px;
        display: block;
        margin-top: 4px;
    }
</style>

<h2>Kelola Data Ekstrakurikuler</h2>

@if (session('success'))
    <p class="alert">{{ session('success') }}</p>
@endif

@if ($errors->any())
    <div style="color:red;border:1px solid red;padding:10px;margin-bottom:15px;border-radius:4px;">
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin:5px 0 0 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-top:20px;">
    <h3>Daftar Ekstrakurikuler</h3>
    <button type="button" class="btn-tambah" onclick="bukaModal('tambahModal')">+ Tambah Ekskul</button>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Nama Ekskul</th>
            <th>Pembina</th>
            <th>Jadwal Latihan</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($ekskul as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if ($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" class="thumb" alt="Gambar Ekskul">
                    @else
                        -
                    @endif
                </td>
                <td>{{ $item->nama_ekskul }}</td>
                <td>{{ $item->pembina }}</td>
                <td>{{ $item->jadwal_latihan }}</td>
                <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                <td>
                    <button type="button" onclick='openEditModal(@json($item))'>Edit</button>
                    <form action="{{ route('ekstrakurikuler.destroy', $item->id_ekskul) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus data ekskul ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align:center;">Belum ada data ekstrakurikuler.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div id="tambahModal" class="modal-overlay">
    <div class="modal-box">
        <form action="{{ route('ekstrakurikuler.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3>Tambah Ekstrakurikuler Baru</h3>

            <p>
                <label>Nama Ekskul:</label>
                <input type="text" name="nama_ekskul" maxlength="40" value="{{ old('nama_ekskul') }}" required>
            </p>
            <p>
                <label>Pembina:</label>
                <input type="text" name="pembina" maxlength="40" value="{{ old('pembina') }}" required>
            </p>
            <p>
                <label>Jadwal Latihan:</label>
                <div class="jadwal-row">
                    <select name="hari" required>
                        <option value="">-- Pilih Hari --</option>
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                            <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                        @endforeach
                    </select>
                    <input type="time" name="jam" value="{{ old('jam') }}" required>
                </div>
                <small class="hint">Pilih hari dan jam latihan</small>
            </p>
            <p>
                <label>Deskripsi:</label>
                <textarea name="deskripsi" required>{{ old('deskripsi') }}</textarea>
            </p>
            <p>
                <label>Gambar Logo/Kegiatan:</label>
                <input type="file" name="gambar" accept="image/*" required>
            </p>

            <button type="submit">Simpan Data</button>
            <button type="button" onclick="tutupModal('tambahModal')">Batal</button>
        </form>
    </div>
</div>

<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h3>Edit Ekstrakurikuler</h3>

            <p>
                <label>Nama Ekskul:</label>
                <input type="text" id="edit_nama_ekskul" name="nama_ekskul" maxlength="40" required>
            </p>
            <p>
                <label>Pembina:</label>
                <input type="text" id="edit_pembina" name="pembina" maxlength="40" required>
            </p>
            <p>
                <label>Jadwal Latihan:</label>
                <div class="jadwal-row">
                    <select id="edit_hari" name="hari" required>
                        <option value="">-- Pilih Hari --</option>
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                            <option value="{{ $hari }}">{{ $hari }}</option>
                        @endforeach
                    </select>
                    <input type="time" id="edit_jam" name="jam" required>
                </div>
            </p>
            <p>
                <label>Deskripsi:</label>
                <textarea id="edit_deskripsi" name="deskripsi" required></textarea>
            </p>
            <p>
                <label>Ganti Gambar (opsional):</label>
                <input type="file" name="gambar" accept="image/*">
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
        document.getElementById('editForm').action = "/ekstrakurikuler/" + data.id_ekskul;
        document.getElementById('edit_nama_ekskul').value = data.nama_ekskul;
        document.getElementById('edit_pembina').value = data.pembina;

        if (data.jadwal_latihan) {
            var parts = data.jadwal_latihan.split(',');
            document.getElementById('edit_hari').value = parts[0] ? parts[0].trim() : '';
            document.getElementById('edit_jam').value = parts[1] ? parts[1].trim() : '';
        }

        document.getElementById('edit_deskripsi').value = data.deskripsi;
        bukaModal('editModal');
    }

    document.querySelectorAll('.modal-overlay').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (e.target === el) el.classList.remove('active');
        });
    });
</script>
@endsection