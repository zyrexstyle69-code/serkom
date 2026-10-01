<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profil_sekolah', function (Blueprint $table) {
            $table->integer('id_profil')->autoIncrement();
            $table->string('nama_sekolah', 40);
            $table->string('kepala_sekolah', 40);
            $table->string('foto', 100);
            $table->string('logo', 100);
            $table->string('npsn', 10);
            $table->text('alamat');
            $table->string('kontak', 15);
            $table->text('visi_misi');
            $table->year('tahun_berdiri');
            $table->text('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('profil_sekolah');
    }
};
