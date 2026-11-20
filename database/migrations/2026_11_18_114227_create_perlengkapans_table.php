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
        Schema::create('perlengkapans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_alat', 30)->unique();
            $table->string('nama_alat', 150);
            $table->string('jenis_alat', 100)->nullable();
            $table->string('kondisi', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('sesi_perlengkapan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_pengamatan_id')->constrained('sesi_pengamatans')->cascadeOnDelete();
            $table->foreignId('perlengkapan_id')->constrained('perlengkapans')->cascadeOnDelete();
            $table->unsignedInteger('jumlah_unit')->default(1);
            $table->text('keterangan_penggunaan')->nullable();
            $table->timestamps();

            $table->unique(['sesi_pengamatan_id', 'perlengkapan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_perlengkapan');
        Schema::dropIfExists('perlengkapans');
    }
};
