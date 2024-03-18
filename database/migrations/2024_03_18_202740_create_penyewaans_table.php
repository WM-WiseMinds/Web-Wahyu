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
        Schema::create('penyewaan', function (Blueprint $table) {
            // Atribut id sebagai primary key
            $table->id();
            // Atribut pelanggan_id
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
            // Atribut mobil_id
            $table->foreignId('mobil_id')->constrained('mobil')->onDelete('cascade');
            // Atribut user_id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Atribut tanggal_penyewaan
            $table->date('tanggal_penyewaan');
            // Atribut durasi sewa
            $table->integer('durasi_sewa');
            // Atribut timestamp created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaan');
    }
};
