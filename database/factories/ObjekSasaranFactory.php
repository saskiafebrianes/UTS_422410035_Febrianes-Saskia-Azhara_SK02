<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ObjekSasaranFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_objek' => fake()->randomElement(['Andromeda Galaxy', 'Orion Nebula', 'Planet Saturnus', 'Pleiades Star Cluster', 'Sombrero Galaxy']),
            'kategori' => fake()->randomElement(['Galaxy', 'Nebula', 'Planet', 'Star Cluster']),
            'deskripsi' => fake()->sentence(),
        ];
    }
}
