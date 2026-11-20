<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PerlengkapanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode_alat' => 'ALAT-' . fake()->unique()->numerify('###'),
            'nama_alat' => fake()->randomElement(['Teleskop Refraktor 4 inch', 'Teleskop Reflektor 8 inch', 'Kamera DSLR Astro', 'Star Tracker', 'Filter Light Pollution']),
            'jenis_alat' => 'Teleskop/Aksesoris',
            'kondisi' => 'Baik',
        ];
    }
}
