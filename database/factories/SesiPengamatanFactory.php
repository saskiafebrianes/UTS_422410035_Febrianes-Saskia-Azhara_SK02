<?php
namespace Database\Factories;

use App\Models\ObjekSasaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class SesiPengamatanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'objek_sasaran_id' => ObjekSasaran::factory(),
            'kode_sesi' => 'SESI-' . fake()->unique()->numerify('###'),
            'nama_sesi' => 'Pengamatan ' . fake()->word(),
            'tanggal_pengamatan' => fake()->date(),
            'durasi_jam' => fake()->randomFloat(2, 1.5, 4.0),
        ];
    }
}
