<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BarangSeeder extends Seeder
{

    public function run()
    {
        $now = Carbon::now();

        $barangs = [
            // Laptop (Kategori: 1)
            ['kode_barang' => 'BRG001', 'nama_barang' => 'Laptop Dell Inspiron', 'merek' => 'Dell', 'model_seri' => 'Inspiron 15', 'kategori_id' => 1, 'status' => 'Tersedia', 'kondisi' => 'Baik', 'keterangan' => 'Laptop i5, RAM 8GB', 'created_at' => $now, 'updated_at' => $now],
            ['kode_barang' => 'BRG002', 'nama_barang' => 'Laptop Asus ROG', 'merek' => 'Asus', 'model_seri' => 'ROG Strix', 'kategori_id' => 1, 'status' => 'Tersedia', 'kondisi' => 'Baik', 'keterangan' => 'Laptop gaming high-end', 'created_at' => $now, 'updated_at' => $now],

            // Aksesoris Komputer (Kategori: 2)
            ['kode_barang' => 'BRG003', 'nama_barang' => 'Mouse Logitech G102', 'merek' => 'Logitech', 'model_seri' => 'G102', 'kategori_id' => 2, 'status' => 'Tersedia', 'kondisi' => 'Lecet', 'keterangan' => 'Mouse gaming dengan DPI 8000', 'created_at' => $now, 'updated_at' => $now],
            ['kode_barang' => 'BRG004', 'nama_barang' => 'Keyboard Mechanical', 'merek' => 'SteelSeries', 'model_seri' => 'Apex Pro', 'kategori_id' => 2, 'status' => 'Tersedia', 'kondisi' => 'Baik', 'keterangan' => 'Keyboard RGB dengan switch red', 'created_at' => $now, 'updated_at' => $now],

            // Monitor & Display (Kategori: 3)
            ['kode_barang' => 'BRG005', 'nama_barang' => 'Monitor LG 24 Inch', 'merek' => 'LG', 'model_seri' => '24MK600', 'kategori_id' => 3, 'status' => 'Tersedia', 'kondisi' => 'Baik', 'keterangan' => 'Monitor IPS resolusi 1080p', 'created_at' => $now, 'updated_at' => $now],
            ['kode_barang' => 'BRG006', 'nama_barang' => 'Proyektor BenQ', 'merek' => 'BenQ', 'model_seri' => 'HT3550', 'kategori_id' => 3, 'status' => 'Tersedia', 'kondisi' => 'Baik', 'keterangan' => 'Proyektor 4K untuk presentasi', 'created_at' => $now, 'updated_at' => $now],
        ];

        // Generate tambahan barang secara dinamis
        for ($i = 7; $i <= 50; $i++) {
            $kategori = ($i % 6) + 1; // Rotasi kategori dari 1-6
            $kondisiOptions = ['Baik', 'Lecet', 'Rusak'];
            $merkList = ['Samsung', 'Sony', 'HP', 'Acer', 'Lenovo', 'MSI'];
            $modelList = ['Model A', 'Model B', 'Model C', 'Model D', 'Model E'];

            $barangs[] = [
                'kode_barang' => 'BRG' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_barang' => 'Barang Kategori ' . $kategori . ' - ' . $i,
                'merek' => $merkList[array_rand($merkList)],
                'model_seri' => $modelList[array_rand($modelList)],
                'kategori_id' => $kategori,
                'status' => rand(0, 1) ? 'Tersedia' : 'Dipinjam',
                'kondisi' => $kondisiOptions[array_rand($kondisiOptions)],
                'keterangan' => 'Deskripsi barang nomor ' . $i,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert data ke database
        Barang::insert($barangs);
    }

}
