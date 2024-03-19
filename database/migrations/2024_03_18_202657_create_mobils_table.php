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
        Schema::create('mobil', function (Blueprint $table) {
            // Attribut id sebagai primary key
            $table->id();
            // Atribut nama
            $table->string('nama');
            // Atribut merk
            $table->string('merk');
            // Atribut warna
            $table->string('warna');
            // Atribut tahun
            $table->string('tahun');
            // Atribut plat_nomor
            $table->string('plat_nomor');
            // Atribut keterangan
            $table->text('keterangan');
            // Atribut harga
            $table->integer('harga');
            // Atribut status
            $table->enum('status', ['Tersedia', 'Disewa', 'Rusak']);
            // Atribut kapasitas_penumpang
            $table->integer('kapasitas_penumpang');
            // Atribut foto
            $table->string('foto', 255);
            // Atribut timestamp created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
