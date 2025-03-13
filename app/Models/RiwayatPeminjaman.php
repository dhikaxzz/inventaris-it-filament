<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPeminjaman extends Model
{
    protected $table = 'riwayat_peminjaman';

    protected $fillable = [
        'nama_peminjam',
        'unit',
        'tempat',
        'acara',
        'tanggal_pinjam',
        'tanggal_kembali',
    ];
}