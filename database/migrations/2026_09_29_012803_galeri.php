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
        Schema::create('galeri', function (Blueprint $table) {
            $table->integer('id_galeri')->autoIncrement();
            $table->string('judul', 50);
            $table->text('keterangan');
            $table->string('file', 100);
            $table->enum('kategori', ['Foto', 'Video']);
            $table->date('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('galeri');
    }
};
