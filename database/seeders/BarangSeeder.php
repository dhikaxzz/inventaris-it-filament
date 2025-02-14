<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;
use Illuminate\Support\Str;

class BarangSeeder extends Seeder
{

    public function run()
    {
        $barangs = [
            // Laptop (Kategori: 1)
            ['kode_barang' => 'BRG001', 'nama_barang' => 'Laptop Dell Inspiron', 'kategori_id' => 1, 'status' => 'Tersedia', 'kondisi' => 'Baik', 'keterangan' => 'Laptop i5, RAM 8GB'],
            ['kode_barang' => 'BRG002', 'nama_barang' => 'Laptop Asus ROG', 'kategori_id' => 1, 'status' => 'Dipinjam', 'kondisi' => 'Baik', 'keterangan' => 'Laptop gaming high-end'],
            
            // Aksesoris Komputer (Kategori: 2)
            ['kode_barang' => 'BRG003', 'nama_barang' => 'Mouse Logitech G102', 'kategori_id' => 2, 'status' => 'Tersedia', 'kondisi' => 'Lecet', 'keterangan' => 'Mouse gaming dengan DPI 8000'],
            ['kode_barang' => 'BRG004', 'nama_barang' => 'Keyboard Mechanical', 'kategori_id' => 2, 'status' => 'Tersedia', 'kondisi' => 'Baik', 'keterangan' => 'Keyboard RGB dengan switch red'],
            
            // Monitor & Display (Kategori: 3)
            ['kode_barang' => 'BRG005', 'nama_barang' => 'Monitor LG 24 Inch', 'kategori_id' => 3, 'status' => 'Tersedia', 'kondisi' => 'Baik', 'keterangan' => 'Monitor IPS resolusi 1080p'],
            ['kode_barang' => 'BRG006', 'nama_barang' => 'Proyektor BenQ', 'kategori_id' => 3, 'status' => 'Tersedia', 'kondisi' => 'Baik', 'keterangan' => 'Proyektor 4K untuk presentasi'],
            
            // Printer & Scanner (Kategori: 4)
            ['kode_barang' => 'BRG007', 'nama_barang' => 'Printer Epson L3110', 'kategori_id' => 4, 'status' => 'Dipinjam', 'kondisi' => 'Baik', 'keterangan' => 'Printer tinta warna'],
            ['kode_barang' => 'BRG008', 'nama_barang' => 'Scanner Canon', 'kategori_id' => 4, 'status' => 'Tersedia', 'kondisi' => 'Baik', 'keterangan' => 'Scanner dokumen A4'],
            
            // Kamera & Aksesoris (Kategori: 5)
            ['kode_barang' => 'BRG009', 'nama_barang' => 'Webcam Logitech C920', 'kategori_id' => 5, 'status' => 'Dipinjam', 'kondisi' => 'Baik', 'keterangan' => 'Webcam Full HD 1080p'],
            ['kode_barang' => 'BRG010', 'nama_barang' => 'Tripod Kamera', 'kategori_id' => 5, 'status' => 'Tersedia', 'kondisi' => 'Baik', 'keterangan' => 'Tripod untuk kamera DSLR'],
            
            // Jaringan & Perangkat Keras (Kategori: 6)
            ['kode_barang' => 'BRG011', 'nama_barang' => 'Router TP-Link', 'kategori_id' => 6, 'status' => 'Dipinjam', 'kondisi' => 'Rusak', 'keterangan' => 'Router WiFi kecepatan 300Mbps'],
            ['kode_barang' => 'BRG012', 'nama_barang' => 'Switch TP-Link 8 Port', 'kategori_id' => 6, 'status' => 'Tersedia', 'kondisi' => 'Baik', 'keterangan' => 'Switch jaringan untuk kantor'],
        ];

        // Generate tambahan barang yang sesuai dengan kategori
        for ($i = 13; $i <= 50; $i++) {
            $kategori = ($i % 6) + 1; // Rotasi kategori dari 1-6
            $barangs[] = [
                'kode_barang' => 'BRG' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_barang' => 'Barang Kategori ' . $kategori . ' - ' . $i,
                'kategori_id' => $kategori,
                'status' => rand(0, 1) ? 'Tersedia' : 'Dipinjam',
                'kondisi' => ['Baik', 'Lecet', 'Rusak'][array_rand(['Baik', 'Lecet', 'Rusak'])],
                'keterangan' => 'Deskripsi barang nomor ' . $i,
            ];
        }

        // Masukkan data ke database
        foreach ($barangs as $barang) {
            Barang::create($barang);
        }
    }

}
