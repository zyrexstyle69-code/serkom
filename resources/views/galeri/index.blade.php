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

    img.media-preview,
    video.media-preview {
        width: 100px;
        height: 60px;
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
</style>

<h2>Kelola Data Galeri</h2>

@if(session('success'))
    <p class="alert">{{ session('success') }}</p>
@endif

@if($errors->any())
    <div style="color:red;border:1px solid red;padding:10px;margin-bottom:15px;border-radius:4px;">
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin:5px 0 0 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="display:flex;justify-content:space-between;align-items:center;margin-top:20px;">
    <h3>Daftar Galeri</h3>
    <button type="button" class="btn-tambah" onclick="bukaModal('tambahModal')">+ Tambah Media</button>
</div>

<table>
    <thead>
        <tr>
            <th>No</th><th>Media</th><th>Judul</th><th>Kategori</th><th>Tanggal</th><th>Keterangan</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($galeri as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($item->kategori == 'Foto')
                        <img src="{{ asset('storage/' . $item->file) }}" class="media-preview" alt="Foto">
                    @elseif($item->kategori == 'Video')
                        <video class="media-preview" controls>
                            <source src="{{ asset('storage/' . $item->file) }}">
                        </video>
                    @endif
                </td>
                <td>{{ $item->judul }}</td>
                <td><strong>{{ $item->kategori }}</strong></td>
                <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                <td>{{ Str::limit($item->keterangan, 50) }}</td>
                <td>
                    <button type="button" onclick='openEditModal(@json($item))'>Edit</button>
                    <form action="{{ route('galeri.destroy', $item->id_galeri) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus galeri ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;">Belum ada media galeri.</td></tr>
        @endforelse
    </tbody>
</table>

<div id="tambahModal" class="modal-overlay">
    <div class="modal-box">
        <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3>Tambah Media Galeri</h3>

            <p>
                <label>Judul Media:</label>
                <input type="text" name="judul" maxlength="50" value="{{ old('judul') }}" required>
            </p>
            <p>
                <label>Kategori:</label>
                <select name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Foto">Foto</option>
                    <option value="Video">Video</option>
                </select>
            </p>
            <p>
                <label>Tanggal:</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            </p>
            <p>
                <label>Keterangan:</label>
                <textarea name="keterangan" required>{{ old('keterangan') }}</textarea>
            </p>
            <p>
                <label>File (Foto / Video):</label>
                <input type="file" name="file" required>
            </p>

            <button type="submit">Simpan Galeri</button>
            <button type="button" onclick="tutupModal('tambahModal')">Batal</button>
        </form>
    </div>
</div>

<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <h3>Edit Media Galeri</h3>

            <p>
                <label>Judul:</label>
                <input type="text" id="edit_judul" name="judul" maxlength="50" required>
            </p>
            <p>
                <label>Kategori:</label>
                <select id="edit_kategori" name="kategori" required>
                    <option value="Foto">Foto</option>
                    <option value="Video">Video</option>
                </select>
            </p>
            <p>
                <label>Tanggal:</label>
                <input type="date" id="edit_tanggal" name="tanggal" required>
            </p>
            <p>
                <label>Keterangan:</label>
                <textarea id="edit_keterangan" name="keterangan" required></textarea>
            </p>
            <p>
                <label>Ganti File (opsional):</label>
                <input type="file" name="file">
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
        document.getElementById('editForm').action = "/galeri/" + data.id_galeri;
        document.getElementById('edit_judul').value = data.judul;
        document.getElementById('edit_kategori').value = data.kategori;
        document.getElementById('edit_tanggal').value = data.tanggal;
        document.getElementById('edit_keterangan').value = data.keterangan;
        bukaModal('editModal');
    }

    document.querySelectorAll('.modal-overlay').forEach(function(el) {
        el.addEventListener('click', function(e) {
            if (e.target === el) el.classList.remove('active');
        });
    });
</script>
@endsection