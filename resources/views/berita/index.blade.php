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

    th { background: #f4f4f4; }

    .alert {
        color: green;
        font-weight: bold;
    }

    img.thumb {
        width: 80px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }

    .btn-tambah {
        background: #007bff;
        color: #fff;
        padding: 8px 14px;
        border: 0;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn-tambah:hover { background: #0056b3; }

    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .modal-overlay.active { display: flex; }

    .modal-box {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        width: 500px;
        max-width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-box h3 { margin-top: 0; }

    .modal-box label {
        display: block;
        margin: 10px 0 4px;
        font-weight: bold;
    }

    .modal-box input,
    .modal-box textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .modal-box textarea {
        height: 100px;
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
        border: 0;
    }
    .modal-box button[type="submit"]:hover { background: #0056b3; }
</style>

<h2>Kelola Data Berita</h2>



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
    <h3>Daftar Berita</h3>
    <button type="button" class="btn-tambah" onclick="showModal('tambahModal')">+ Tambah Berita</button>
</div>

<table>
    <thead>
        <tr>
            <th>No</th><th>Gambar</th><th>Judul</th><th>Tanggal</th><th>Isi Berita</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($berita as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" class="thumb" alt="Gambar Berita">
                    @else
                        -
                    @endif
                </td>
                <td>{{ $item->judul }}</td>
                <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                <td>{{ Str::limit($item->isi, 60) }}</td>
                <td>
                    <button type="button" onclick='showEditModal(@json($item))'>Edit</button>
                    <form action="{{ route('berita.destroy', $item->id_berita) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus berita ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" style="text-align:center;">Belum ada berita.</td></tr>
        @endforelse
    </tbody>
</table>

<div id="tambahModal" class="modal-overlay">
    <div class="modal-box">
        <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3>Tambah Berita Baru</h3>

            <label>Judul Berita:</label>
            <input type="text" name="judul" maxlength="50" value="{{ old('judul') }}" required>

            <label>Tanggal:</label>
            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>

            <label>Isi Berita:</label>
            <textarea name="isi" required>{{ old('isi') }}</textarea>

            <label>Gambar:</label>
            <input type="file" name="gambar" accept="image/*" required>

            <div style="margin-top:15px;">
                <button type="submit">Simpan</button>
                <button type="button" onclick="hideModal('tambahModal')">Batal</button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <h3>Edit Berita</h3>

            <label>Judul Berita:</label>
            <input type="text" id="edit_judul" name="judul" maxlength="50" required>

            <label>Tanggal:</label>
            <input type="date" id="edit_tanggal" name="tanggal" required>

            <label>Isi Berita:</label>
            <textarea id="edit_isi" name="isi" required></textarea>

            <label>Ganti Gambar (opsional):</label>
            <input type="file" name="gambar" accept="image/*">

            <div style="margin-top:15px;">
                <button type="submit">Update</button>
                <button type="button" onclick="hideModal('editModal')">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    const showModal = id => document.getElementById(id).classList.add('active');
    const hideModal = id => document.getElementById(id).classList.remove('active');

    function showEditModal(data) {
        document.getElementById('editForm').action = "/berita/" + data.id_berita;
        document.getElementById('edit_judul').value = data.judul;
        document.getElementById('edit_tanggal').value = data.tanggal;
        document.getElementById('edit_isi').value = data.isi;
        showModal('editModal');
    }

    document.querySelectorAll('.modal-overlay').forEach(el => {
        el.addEventListener('click', e => { if (e.target === el) el.classList.remove('active'); });
    });
</script>
@endsection