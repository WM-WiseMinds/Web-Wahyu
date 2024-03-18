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
        Schema::create('pelanggan', function (Blueprint $table) {
            // Attribut id sebagai primary key
            $table->id();
            // Atribut user_id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Atribut alamat
            $table->string('alamat');
            // Atribut no_hp
            $table->string('no_hp');
            // Atribut timestamp created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
