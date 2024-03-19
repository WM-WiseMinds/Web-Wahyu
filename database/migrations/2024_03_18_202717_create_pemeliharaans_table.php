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
        Schema::create('pemeliharaan', function (Blueprint $table) {
            // Atribut id sebagai primary key
            $table->id();
            // Atribut mobil_id
            $table->foreignId('mobil_id')->constrained('mobil')->onDelete('cascade');
            // Atribut keterangan
            $table->text('keterangan');
            // Atribut biaya
            $table->integer('biaya');
            // Atribut bukti_pembayaran
            $table->string('bukti_pembayaran');
            // Atribut timestamp created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeliharaaan');
    }
};
