<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Jalankan Seeder Kategori dulu biar kategori_id 1-6 ada
        $this->call(KategoriSeeder::class);

        // Jalankan Seeder Barang
        $this->call(BarangSeeder::class);
    }
}
