<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'merek',
        'model_seri',
        'kategori_id',
        'status',
        'kondisi',
        'keterangan',
        'lokasi',
        'foto',
    ];

    public $timestamps = true; // Pastikan ini ada

    protected $attributes = [
        'kondisi' => 'Baik',
    ];
    

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function riwayatPeminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'barang_id');
    }

    public function riwayatKondisi()
    {
        return $this->hasMany(RiwayatKondisi::class, 'barang_id');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

}
