<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'serial_number',
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

   // Akses URL Foto
   public function getFotoUrlAttribute()
   {
       return $this->foto ? Storage::url($this->foto) : null;
   }
   
//    public function getPenggunaTerakhir()
//     {
//         return $this->hasOne(RiwayatDetailPeminjaman::class, 'barang_id')
//             ->latest('id') // Mengambil peminjaman terakhir berdasarkan ID terbaru
//             ->with('riwayatPeminjaman'); // Include data peminjaman
//     }

    public function peminjamanTerakhir()
    {
        return $this->hasOne(RiwayatDetailPeminjaman::class, 'barang_id')
                    ->latestOfMany('riwayat_peminjaman_id'); 
    }

    public function getPenggunaTerakhir()
    {
        return $this->peminjamanTerakhir?->riwayatPeminjaman?->nama_peminjam ?? 'Belum Pernah Dipinjam';
    }

}
