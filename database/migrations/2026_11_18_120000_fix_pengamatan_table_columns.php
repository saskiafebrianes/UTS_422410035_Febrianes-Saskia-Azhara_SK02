<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('objek_sasarans', 'nama_objek')) {
            Schema::table('objek_sasarans', function (Blueprint $table) {
                $table->string('nama_objek', 150)->nullable();
                $table->string('kategori', 50)->nullable();
                $table->text('deskripsi')->nullable();
            });
        }

        if (!Schema::hasColumn('perlengkapans', 'kode_alat')) {
            Schema::table('perlengkapans', function (Blueprint $table) {
                $table->string('kode_alat', 30)->nullable();
                $table->string('nama_alat', 150)->nullable();
                $table->string('jenis_alat', 100)->nullable();
                $table->string('kondisi', 50)->nullable();
            });
        }

        if (!Schema::hasColumn('lokasi_pengamatans', 'nama_lokasi')) {
            Schema::table('lokasi_pengamatans', function (Blueprint $table) {
                $table->foreignId('sesi_pengamatan_id')->nullable()->constrained('sesi_pengamatans')->cascadeOnDelete();
                $table->string('nama_lokasi', 120)->nullable();
                $table->string('koordinat_langit', 100)->nullable();
                $table->string('tingkat_polusi_cahaya', 50)->nullable();
                $table->text('catatan_cuaca')->nullable();
            });
        }

        if (!Schema::hasColumn('sesi_pengamatans', 'objek_sasaran_id')) {
            Schema::table('sesi_pengamatans', function (Blueprint $table) {
                $table->foreignId('objek_sasaran_id')->nullable()->constrained('objek_sasarans')->cascadeOnDelete();
                $table->string('kode_sesi', 30)->nullable();
                $table->string('nama_sesi', 150)->nullable();
                $table->date('tanggal_pengamatan')->nullable();
                $table->decimal('durasi_jam', 4, 1)->nullable();
            });
        }

        if (!Schema::hasTable('sesi_perlengkapan')) {
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
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_perlengkapan');
    }
};
