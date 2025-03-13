<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatDetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'riwayat_detail_peminjaman';

    protected $fillable = [
        'riwayat_peminjaman_id',
        'barang_id',
        'kode_barang',
        'nama_barang',
    ];

    public function riwayatPeminjaman()
    {
        return $this->belongsTo(RiwayatPeminjaman::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}