<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'riwayat_peminjaman';

    protected $fillable = [
        'nama_peminjam',
        'unit',
        'tempat',
        'acara',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    // Relasi ke tabel riwayat_detail_peminjaman
    public function riwayatDetailPeminjaman()
    {
        return $this->hasMany(RiwayatDetailPeminjaman::class, 'riwayat_peminjaman_id');
    }
}