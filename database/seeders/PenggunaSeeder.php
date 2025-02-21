<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengguna;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataPengguna = [
            [
                'nama' => 'Admin Sistem',
                'email' => 'admin@example.com',
                'no_telp' => '081234567890',
                'jabatan' => 'Administrator',
                'unit' => 'IT Support',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'no_telp' => '089876543210',
                'jabatan' => 'Staff',
                'unit' => 'Keuangan',
                'alamat' => 'Jl. Sudirman No. 45, Bandung',
            ],
            [
                'nama' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'no_telp' => '081234112233',
                'jabatan' => 'Supervisor',
                'unit' => 'Pemasaran',
                'alamat' => 'Jl. Gajah Mada No. 67, Surabaya',
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'email' => 'ahmad@example.com',
                'no_telp' => '081345678900',
                'jabatan' => 'Manajer',
                'unit' => 'Operasional',
                'alamat' => 'Jl. Diponegoro No. 21, Medan',
            ],
            [
                'nama' => 'Dewi Kartika',
                'email' => 'dewi@example.com',
                'no_telp' => '087812345678',
                'jabatan' => 'Staff',
                'unit' => 'HRD',
                'alamat' => 'Jl. Imam Bonjol No. 11, Yogyakarta',
            ],
            [
                'nama' => 'Rizky Maulana',
                'email' => 'rizky@example.com',
                'no_telp' => '082233445566',
                'jabatan' => 'Supervisor',
                'unit' => 'Teknik',
                'alamat' => 'Jl. Sudirman No. 99, Makassar',
            ],
            [
                'nama' => 'Indah Lestari',
                'email' => 'indah@example.com',
                'no_telp' => '081998877665',
                'jabatan' => 'Koordinator',
                'unit' => 'Pendidikan',
                'alamat' => 'Jl. Melati No. 5, Semarang',
            ],
            [
                'nama' => 'Fajar Ramadhan',
                'email' => 'fajar@example.com',
                'no_telp' => '085566778899',
                'jabatan' => 'Staff',
                'unit' => 'IT Support',
                'alamat' => 'Jl. Anggrek No. 17, Bali',
            ],
            [
                'nama' => 'Nina Sari',
                'email' => 'nina@example.com',
                'no_telp' => '081211223344',
                'jabatan' => 'Sekretaris',
                'unit' => 'Administrasi',
                'alamat' => 'Jl. Mawar No. 30, Palembang',
            ],
            [
                'nama' => 'Yoga Saputra',
                'email' => 'yoga@example.com',
                'no_telp' => '089912345678',
                'jabatan' => 'Kepala Divisi',
                'unit' => 'Keuangan',
                'alamat' => 'Jl. Kenanga No. 88, Pekanbaru',
            ],
        ];

        foreach ($dataPengguna as $pengguna) {
            Pengguna::create($pengguna + ['created_at' => now(), 'updated_at' => now()]);
        }
    }
}
