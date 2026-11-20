<?php
namespace Database\Seeders;

use App\Models\ObjekSasaran;
use App\Models\Perlengkapan;
use App\Models\SesiPengamatan;
use App\Models\LokasiPengamatan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Master Data Objek & Perlengkapan
        $objeks = ObjekSasaran::factory()->count(5)->create();
        $perlengkapans = Perlengkapan::factory()->count(6)->create();

        // 2. Buat Sesi Pengamatan beserta relasi One-to-One (Lokasi) & Many-to-Many (Pivot Perlengkapan)
        SesiPengamatan::factory()->count(10)->create()->each(function ($sesi) use ($perlengkapans) {

            // Relasi One-to-One: Lokasi Pengamatan
            LokasiPengamatan::create([
                'sesi_pengamatan_id' => $sesi->id,
                'nama_lokasi' => fake()->randomElement(['Observatorium Bosscha', 'Dataran Tinggi Dieng', 'Pantai Cemara', 'Bukit Paralayang']),
                'koordinat_langit' => 'RA ' . fake()->numerify('##h ##m') . ' / Dec ' . fake()->numerify('+##° ##\''),
                'tingkat_polusi_cahaya' => 'Bortle Class ' . fake()->numberBetween(2, 5),
                'catatan_cuaca' => 'Cerah, minim awan, visibilitas sangat baik.',
            ]);

            // Relasi Many-to-Many: Melampirkan beberapa perlengkapan (pilihan jamak) ke sesi ini menggunakan attach()
            $sesi->perlengkapans()->attach(
                $perlengkapans->random(rand(2, 4))->pluck('id')->toArray(),
                [
                    'jumlah_unit' => rand(1, 2),
                    'keterangan_penggunaan' => 'Digunakan secara aktif selama sesi pemotretan.',
                ]
            );
        });
    }
}
