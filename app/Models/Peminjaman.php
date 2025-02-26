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

    public function pengguna() 
    {
        return $this->belongsTo(Pengguna::class, 'nama_peminjam', 'nama');
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($peminjaman) {
            if (!$peminjaman->unit) {
                $peminjaman->unit = \App\Models\Pengguna::where('nama', $peminjaman->nama_peminjam)->value('unit');
            }
        });

        static::deleting(function ($peminjaman) {
            // Kembalikan semua barang yang terkait ke status 'tersedia'
            foreach ($peminjaman->detailPeminjaman as $detail) {
                Barang::where('id', $detail->barang_id)->update(['status' => 'tersedia']);
            }
        });
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}
