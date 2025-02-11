<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kategori;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_barang' => 'BRG' . $this->faker->unique()->numberBetween(100, 999),
            'nama_barang' => $this->faker->word(),
            'kategori_id' => Kategori::inRandomOrder()->first()->id ?? 1,
            'status' => $this->faker->randomElement(['Tersedia', 'Dipinjam']),
            'kondisi' => $this->faker->randomElement(['Baik', 'Lecet', 'Rusak']),
            'keterangan' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
