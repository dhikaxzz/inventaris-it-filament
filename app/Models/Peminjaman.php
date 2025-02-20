<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamen';

    protected $fillable = [
        'nama_peminjam',
        'unit',
        'tempat',
        'acara',
        'tanggal_pinjam',
        'tanggal_kembali',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'date',
    ];
}
