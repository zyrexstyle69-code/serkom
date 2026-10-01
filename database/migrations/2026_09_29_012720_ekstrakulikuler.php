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
        Schema::create('ekstrakurikuler', function (Blueprint $table) {
            $table->integer('id_ekskul')->autoIncrement();
            $table->string('nama_ekskul', 40);
            $table->string('pembina', 40);
            $table->string('jadwal_latihan', 40);
            $table->text('deskripsi');
            $table->string('gambar', 100);
            $table->timestamps(); // Tambahkan ini
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('ekstrakurikuler');
    }
};
