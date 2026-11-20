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
        Schema::create('sesi_pengamatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objek_sasaran_id')->constrained('objek_sasarans')->cascadeOnDelete();
            $table->string('kode_sesi', 30)->unique();
            $table->string('nama_sesi', 150);
            $table->date('tanggal_pengamatan');
            $table->decimal('durasi_jam', 4, 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_pengamatans');
    }
};
