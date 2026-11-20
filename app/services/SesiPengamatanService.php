<?php

namespace App\Services;

use App\Models\SesiPengamatan;
use Illuminate\Support\Facades\DB;

class SesiPengamatanService
{
    public function simpanSesi(array $data): SesiPengamatan
    {
        return DB::transaction(function () use ($data) {
            // 1. Simpan Data Utama
            $sesi = SesiPengamatan::create([
                'objek_sasaran_id' => $data['objek_sasaran_id'],
                'kode_sesi' => $data['kode_sesi'],
                'nama_sesi' => $data['nama_sesi'],
                'tanggal_pengamatan' => $data['tanggal_pengamatan'],
                'durasi_jam' => $data['durasi_jam'],
            ]);

            // 2. Simpan Detail One-to-One (Lokasi Pengamatan)
            $sesi->lokasiPengamatan()->create([
                'nama_lokasi' => $data['nama_lokasi'],
                'koordinat_langit' => $data['koordinat_langit'],
                'tingkat_polusi_cahaya' => $data['tingkat_polusi_cahaya'] ?? null,
                'catatan_cuaca' => $data['catatan_cuaca'] ?? null,
            ]);

            // 3. Simpan Relasi Many-to-Many (Pivot Perlengkapan)
            $syncData = [];
            foreach ($data['perlengkapan_ids'] as $alatId) {
                $syncData[$alatId] = [
                    'jumlah_unit' => 1,
                    'keterangan_penggunaan' => 'Digunakan pada sesi ' . $data['kode_sesi'],
                ];
            }
            $sesi->perlengkapans()->sync($syncData);

            return $sesi;
        });
    }

    public function perbaruiSesi(SesiPengamatan $sesi, array $data): SesiPengamatan
    {
        return DB::transaction(function () use ($sesi, $data) {
            // 1. Update Data Utama
            $sesi->update([
                'objek_sasaran_id' => $data['objek_sasaran_id'],
                'kode_sesi' => $data['kode_sesi'],
                'nama_sesi' => $data['nama_sesi'],
                'tanggal_pengamatan' => $data['tanggal_pengamatan'],
                'durasi_jam' => $data['durasi_jam'],
            ]);

            // 2. Update atau Create One-to-One Lokasi
            $sesi->lokasiPengamatan()->updateOrCreate(
                ['sesi_pengamatan_id' => $sesi->id],
                [
                    'nama_lokasi' => $data['nama_lokasi'],
                    'koordinat_langit' => $data['koordinat_langit'],
                    'tingkat_polusi_cahaya' => $data['tingkat_polusi_cahaya'] ?? null,
                    'catatan_cuaca' => $data['catatan_cuaca'] ?? null,
                ]
            );

            // 3. Sync Many-to-Many Perlengkapan
            $syncData = [];
            foreach ($data['perlengkapan_ids'] as $alatId) {
                $syncData[$alatId] = [
                    'jumlah_unit' => 1,
                    'keterangan_penggunaan' => 'Diperbarui pada sesi ' . $data['kode_sesi'],
                ];
            }
            $sesi->perlengkapans()->sync($syncData);

            return $sesi;
        });
    }
}
