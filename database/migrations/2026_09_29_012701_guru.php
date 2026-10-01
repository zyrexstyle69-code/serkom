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
        Schema::create('guru', function (Blueprint $table) {
            $table->integer('id_guru')->autoIncrement();
            $table->string('nama_guru', 40);
            $table->string('nip', 15);
            $table->string('mapel', 40);
            $table->string('foto', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('guru');
    }
};
