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
        Schema::create('lokasi_pengamatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_pengamatan_id')->unique()->constrained('sesi_pengamatans')->cascadeOnDelete();
            $table->string('nama_lokasi', 120);
            $table->string('koordinat_langit', 100);
            $table->string('tingkat_polusi_cahaya', 50)->nullable();
            $table->text('catatan_cuaca')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_pengamatans');
    }
};
