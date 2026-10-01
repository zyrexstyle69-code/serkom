@extends('admin')
@section('content')
    <style>
        /* --- STYLE BAWAAN ANDA --- */
        h4.text-white i,
        .bg-dark h3.text-white,
        .bg-dark small.text-light,
        .bg-dark small.text-white,
        .bg-dark i.text-white {
            color: #ffffff !important;
        }

        h4.text-white {
            display: flex;
            align-items: center;
        }

        .ikon-lingkaran {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #045e35;
            border-radius: 50%;
            margin-right: 12px;
            vertical-align: middle;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .ikon-lingkaran i {
            color: #ffffff !important;
            font-size: 18px;
            margin: 0 !important;
        }

        /* =========================================
           CSS KARTU JENJANG PENDIDIKAN (CLEAN UI)
           ========================================= */
        .jenjang-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb; /* Border tipis abu-abu */
            border-radius: 8px; /* Sudut lebih formal */
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        /* Efek hover yang halus, tidak berlebihan */
        .jenjang-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .jenjang-header {
            padding: 16px 20px;
            color: #ffffff !important;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        /* Warna Solid yang Lebih Elegan (Tidak Norak) */
        .bg-jenjang-orange { background-color: #d97706; } /* Amber-600 */
        .bg-jenjang-red    { background-color: #b91c1c; } /* Red-700 */
        .bg-jenjang-green  { background-color: #047857; } /* Emerald-700 */

        .jenjang-badge {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            color: #ffffff;
            text-transform: uppercase;
        }

        .jenjang-header h5 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 2px;
            color: #ffffff !important;
        }

        .jenjang-header p {
            font-size: 13px;
            margin: 0;
            color: rgba(255, 255, 255, 0.85) !important;
        }

        .jenjang-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #ffffff;
        }

        .jenjang-body p {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
            font-weight: 400;
        }

        .jenjang-link {
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: color 0.2s ease;
        }

        /* Warna link disesuaikan dengan warna header */
        .link-orange { color: #d97706; }
        .link-orange:hover { color: #b45309; }

        .link-red { color: #b91c1c; }
        .link-red:hover { color: #991b1b; }

        .link-green { color: #047857; }
        .link-green:hover { color: #065f46; }
    </style>

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="">
                    <h1 class="mb-4 text-white">Profil Sekolah</h1>

                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <img src="asset/img/al-haq.jpg" alt="" class="img-fluid rounded-circle mb-3"
                                style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #037235;">
                        </div>
                        <div class="col-md-9">
                            <h2 class="text-white mb-2">AL-HAQ</h2>
                            <p class="text-light mb-1">
                                <i class="fa fa-map-marker-alt me-2 text-primary"></i>
                                Jl. Manglid No. 13 RT 05 RW 02, Desa Margahayu Selatan, Kecamatan Margahayu, Kabupaten
                                Bandung 40226
                            </p>
                            <p class="text-light mb-1">
                                <i class="fa fa-phone-alt me-2 text-primary"></i>
                                +62 858-6153-9740
                            </p>
                            <p class="text-light mb-1">
                                <i class="fa fa-envelope me-2 text-primary"></i>
                                alhaqmargahayu@gmail.com
                            </p>
                            <p class="text-light mb-1">
                                <i class="fa fa-globe me-2 text-primary"></i>
                                alhaqmargahayu.sch.id
                            </p>
                        </div>
                    </div>

                    <hr class="border-secondary">

                    <div class="mb-4">
                        <h4 class="text-white mb-3">
                            <span class="ikon-lingkaran"><i class="fa fa-eye"></i></span>Visi
                        </h4>
                        <p class="text-light">
                            "Terwujudnya generasi Qur'ani yang beriman, berilmu, beramal saleh,
                            dan berakhlak mulia menuju ridha Allah SWT."
                        </p>
                    </div>

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

                    <!--BAGIAN JENJANG PENDIDIKAN -->
                    <div class="mb-5">
                        <h4 class="text-white mb-3">
                            <span class="ikon-lingkaran"><i class="fa fa-graduation-cap"></i></span>Jenjang Pendidikan
                        </h4>
                        <div class="row g-4">
                            <div class="col-md-4">
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
                            </div>
                            <div class="col-md-4">
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
                            </div>
                            <div class="col-md-4">
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
                    </div>
                    <!--AKHIR BAGIAN JENJANG PENDIDIKAN -->

                    <div class="mb-4">
                        <h4 class="text-white mb-3">
                            <span class="ikon-lingkaran"><i class="fa fa-building"></i></span>Fasilitas
                        </h4>
                        <div class="row g-2">
                            <div class="col-md-3 col-6">
                                <p class="text-light mb-1"><i class="fa fa-check text-primary me-2"></i>Lab Komputer</p>
                            </div>
                            <div class="col-md-3 col-6">
                                <p class="text-light mb-1"><i class="fa fa-check text-primary me-2"></i>Perpustakaan</p>
                            </div>
                            <div class="col-md-3 col-6">
                                <p class="text-light mb-1"><i class="fa fa-check text-primary me-2"></i>Lapangan Olahraga
                                </p>
                            </div>
                            <div class="col-md-3 col-6">
                                <p class="text-light mb-1"><i class="fa fa-check text-primary me-2"></i>Masjid</p>
                            </div>
                            <div class="col-md-3 col-6">
                                <p class="text-light mb-1"><i class="fa fa-check text-primary me-2"></i>Ruang UKS</p>
                            </div>
                            <div class="col-md-3 col-6">
                                <p class="text-light mb-1"><i class="fa fa-check text-primary me-2"></i>Kantin Sehat</p>
                            </div>
                            <div class="col-md-3 col-6">
                                <p class="text-light mb-1"><i class="fa fa-check text-primary me-2"></i>WiFi Area</p>
                            </div>
                            <div class="col-md-3 col-6">
                                <p class="text-light mb-1"><i class="fa fa-check text-primary me-2"></i>Aula Serbaguna</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-3 col-6">
                            <div class="bg-dark rounded p-3 text-center">
                                <h3 class="text-white mb-0">500+</h3>
                                <small class="text-light">Siswa Aktif</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="bg-dark rounded p-3 text-center">
                                <h3 class="text-white mb-0">45</h3>
                                <small class="text-light">Guru & Staff</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="bg-dark rounded p-3 text-center">
                                <h3 class="text-white mb-0">30+</h3>
                                <small class="text-light">Tahun Berdiri</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="bg-dark rounded p-3 text-center">
                                <h3 class="text-white mb-0">1000+</h3>
                                <small class="text-light">Alumni</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary">
                            <i class="fa fa-edit me-2"></i>Edit Profil
                        </button>
                        <button class="btn btn-outline-light">
                            <i class="fa fa-print me-2"></i>Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection