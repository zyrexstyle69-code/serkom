@extends('admin')
@section('content')
    <style>
        /* ===== DASAR ===== */
        .profil-sekolah {
            max-width: 960px;
            color: #d1d5db;
            font-size: 14px;
            line-height: 1.7;
        }

        .profil-sekolah h1 {
            font-size: 21px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 20px;
            letter-spacing: -0.2px;
        }

        .profil-sekolah h2 {
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 10px;
        }

        /* ===== IKON LINGKARAN (tetap ada, tapi lebih kalem) ===== */
        .ikon-lingkaran {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            background-color: #1f2937;
            border: 1px solid #374151;
            border-radius: 50%;
            margin-right: 10px;
            vertical-align: middle;
        }

        .ikon-lingkaran i {
            color: #9ca3af !important;
            font-size: 14px;
            margin: 0 !important;
        }

        h4.text-white {
            display: flex;
            align-items: center;
            font-size: 15px;
            font-weight: 600;
            color: #fff !important;
            margin-bottom: 12px;
        }

        /* ===== HEADER PROFIL ===== */
        .profil-header {
            display: flex;
            gap: 24px;
            align-items: center;
            padding-bottom: 22px;
            border-bottom: 1px solid #374151;
            margin-bottom: 22px;
        }

        .profil-header img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #374151;
            flex-shrink: 0;
        }

        .profil-header .info-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            color: #9ca3af;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .profil-header .info-item i {
            color: #6b7280 !important;
            width: 14px;
            text-align: center;
            margin-top: 3px;
        }

        /* ===== JENJANG ===== */
        .jenjang-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        @media (max-width: 768px) {
            .jenjang-grid { grid-template-columns: 1fr; }
            .profil-header { flex-direction: column; text-align: center; }
            .profil-header .info-item { justify-content: center; }
        }

        .jenjang-card {
            background: #1f2937;
            border: 1px solid #374151;
            border-radius: 8px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: border-color 0.2s;
        }

        .jenjang-card:hover {
            border-color: #4b5563;
        }

        .jenjang-header {
            padding: 14px 16px;
            border-bottom: 1px solid #374151;
            background: transparent;
        }

        .jenjang-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 6px;
        }

        .jenjang-header h5 {
            font-size: 14px;
            font-weight: 600;
            color: #fff !important;
            margin: 0 0 2px 0;
        }

        .jenjang-header p {
            font-size: 12px;
            color: #6b7280 !important;
            margin: 0;
        }

        .jenjang-body {
            padding: 16px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .jenjang-body p {
            font-size: 13px;
            color: #9ca3af;
            line-height: 1.6;
            margin-bottom: 14px;
        }

        .jenjang-link {
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            color: #60a5fa !important;
        }

        .jenjang-link:hover {
            color: #93c5fd !important;
            text-decoration: underline;
        }

        /* hapus warna solid norak */
        .bg-jenjang-orange,
        .bg-jenjang-red,
        .bg-jenjang-green {
            background-color: transparent;
        }

        .link-orange,
        .link-red,
        .link-green {
            color: #60a5fa !important;
        }

        /* ===== FASILITAS ===== */
        .fasilitas-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 6px 20px;
        }

        @media (max-width: 768px) {
            .fasilitas-grid { grid-template-columns: repeat(2, 1fr); }
        }

        .fasilitas-grid p {
            font-size: 13px;
            color: #d1d5db;
            margin-bottom: 4px;
        }

        .fasilitas-grid i {
            color: #6b7280 !important;
        }

        /* ===== TOMBOL ===== */
        .btn-aksi {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.15s;
        }

        .btn-utama {
            background: #2563eb;
            color: #fff;
            border: none;
        }

        .btn-utama:hover {
            background: #1d4ed8;
        }

        .btn-sekunder {
            background: transparent;
            color: #d1d5db;
            border-color: #4b5563;
        }

        .btn-sekunder:hover {
            background: #1f2937;
            border-color: #6b7280;
        }

        hr.border-secondary {
            border-color: #374151 !important;
            opacity: 1;
        }
    </style>

    <div class="container-fluid pt-4 px-4">
        <div class="profil-sekolah">
            <h1 class="mb-4 text-white">Profil Sekolah</h1>

            {{-- HEADER --}}
            <div class="profil-header mb-4">
                <img src="{{ asset('asset/img/al-haq.jpg') }}"
                     onerror="this.src='https://via.placeholder.com/150?text=Logo+Sekolah'"
                     alt="Logo AL-HAQ">
                <div>
                    <h2 class="text-white mb-2">AL-HAQ</h2>
                    <p class="info-item">
                        <i class="fa fa-map-marker-alt"></i>
                        <span>Jl. Manglid No. 13 RT 05 RW 02, Desa Margahayu Selatan, Kecamatan Margahayu, Kabupaten Bandung 40226</span>
                    </p>
                    <p class="info-item">
                        <i class="fa fa-phone-alt"></i>
                        <span>+62 858-6153-9740</span>
                    </p>
                    <p class="info-item">
                        <i class="fa fa-envelope"></i>
                        <span>alhaqmargahayu@gmail.com</span>
                    </p>
                    <p class="info-item">
                        <i class="fa fa-globe"></i>
                        <span>alhaqmargahayu.sch.id</span>
                    </p>
                </div>
            </div>

            <hr class="border-secondary">

            {{-- VISI --}}
            <div class="mb-4">
                <h4 class="text-white mb-3">
                    <span class="ikon-lingkaran"><i class="fa fa-eye"></i></span>Visi
                </h4>
                <p class="text-light">
                    "Terwujudnya generasi Qur'ani yang beriman, berilmu, beramal saleh,
                    dan berakhlak mulia menuju ridha Allah SWT."
                </p>
            </div>

            {{-- MISI --}}
            <div class="mb-4">
                <h4 class="text-white mb-3">
                    <span class="ikon-lingkaran"><i class="fa fa-bullseye"></i></span>Misi
                </h4>
                <ol class="text-light">
                    <li>Memakmurkan masjid sebagai tempat ibadah dan pembinaan umat</li>
                    <li>Menyebarkan dakwah Islam yang rahmatan lil 'alamin</li>
                    <li>Membina generasi muda islami yang berakhlak mulia</li>
                    <li>Memberdayakan ekonomi dan sosial masyarakat sekitar</li>
                    <li>Membangun ukhuwah islamiyah antar sesama</li>
                </ol>
            </div>

            {{-- JENJANG --}}
            <div class="mb-5">
                <h4 class="text-white mb-3">
                    <span class="ikon-lingkaran"><i class="fa fa-graduation-cap"></i></span>Jenjang Pendidikan
                </h4>
                <div class="jenjang-grid">
                    <div class="jenjang-card">
                        <div class="jenjang-header bg-jenjang-orange">
                            <span class="jenjang-badge">PG & RA</span>
                            <h5>Play Group & Raudhatul Athfal</h5>
                            <p>Usia 3-6 Tahun</p>
                        </div>
                        <div class="jenjang-body">
                            <p>Langkah pertama yang menyenangkan untuk si kecil. Belajar sambil bermain dengan pendekatan Islami.</p>
                            <a href="#" class="jenjang-link link-orange">Pelajari Lebih Lanjut <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="jenjang-card">
                        <div class="jenjang-header bg-jenjang-red">
                            <span class="jenjang-badge">MI</span>
                            <h5>Madrasah Ibtidaiyah</h5>
                            <p>Setara SD</p>
                        </div>
                        <div class="jenjang-body">
                            <p>Fondasi yang kuat dengan keseimbangan akademik dan program tahsin-tahfidz metode UMMI.</p>
                            <a href="#" class="jenjang-link link-red">Pelajari Lebih Lanjut <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="jenjang-card">
                        <div class="jenjang-header bg-jenjang-green">
                            <span class="jenjang-badge">MTs</span>
                            <h5>Madrasah Tsanawiyah</h5>
                            <p>Setara SMP</p>
                        </div>
                        <div class="jenjang-body">
                            <p>Menyiapkan remaja tangguh yang siap menghadapi tantangan masa depan.</p>
                            <a href="#" class="jenjang-link link-green">Pelajari Lebih Lanjut <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FASILITAS --}}
            <div class="mb-4">
                <h4 class="text-white mb-3">
                    <span class="ikon-lingkaran"><i class="fa fa-building"></i></span>Fasilitas
                </h4>
                <div class="fasilitas-grid">
                    <p class="text-light mb-1"><i class="fa fa-check me-2"></i>Lab Komputer</p>
                    <p class="text-light mb-1"><i class="fa fa-check me-2"></i>Perpustakaan</p>
                    <p class="text-light mb-1"><i class="fa fa-check me-2"></i>Lapangan Olahraga</p>
                    <p class="text-light mb-1"><i class="fa fa-check me-2"></i>Masjid</p>
                    <p class="text-light mb-1"><i class="fa fa-check me-2"></i>Ruang UKS</p>
                    <p class="text-light mb-1"><i class="fa fa-check me-2"></i>Kantin Sehat</p>
                    <p class="text-light mb-1"><i class="fa fa-check me-2"></i>WiFi Area</p>
                    <p class="text-light mb-1"><i class="fa fa-check me-2"></i>Aula Serbaguna</p>
                </div>
            </div>

            {{-- TOMBOL --}}
            <div class="d-flex gap-2">
                <button class="btn-aksi btn-utama">
                    <i class="fa fa-edit me-2"></i>Edit Profil
                </button>
                <button class="btn-aksi btn-sekunder">
                    <i class="fa fa-print me-2"></i>Cetak
                </button>
            </div>
        </div>
    </div>
@endsection