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
        Schema::create('transaksis', function (Blueprint $table) {
            // Atribut id sebagai primary key
            $table->id();
            // Atribut penyewaan_id
            $table->foreignId('penyewaan_id')->constrained('penyewaan')->onDelete('cascade');
            // Atribut jumlah_pembayaran
            $table->integer('jumlah_pembayaran');
            // Atribut keterangan
            $table->text('keterangan');
            // Atribut status
            $table->string('status');
            // Atribut bukti_pembayaran
            $table->string('bukti_pembayaran', 255);
            // Atribut timestamp created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
