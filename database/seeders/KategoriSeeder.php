<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            ['id' => 1, 'nama_kategori' => 'Laptop'],
            ['id' => 2, 'nama_kategori' => 'Aksesoris Komputer'],
            ['id' => 3, 'nama_kategori' => 'Monitor'],
            ['id' => 4, 'nama_kategori' => 'Printer & Scanner'],
            ['id' => 5, 'nama_kategori' => 'Kamera & Audio'],
            ['id' => 6, 'nama_kategori' => 'Jaringan & Router'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
