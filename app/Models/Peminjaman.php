<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RiwayatDetailPeminjaman;

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

            // Catat riwayat peminjaman
            $riwayatPeminjaman = RiwayatPeminjaman::create([
                'nama_peminjam' => $peminjaman->nama_peminjam,
                'unit' => $peminjaman->unit,
                'tempat' => $peminjaman->tempat,
                'acara' => $peminjaman->acara,
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'tanggal_kembali' => $peminjaman->tanggal_kembali,
            ]);

            // Catat detail barang yang dipinjam ke riwayat_detail_peminjaman
            foreach ($peminjaman->detailPeminjaman as $detail) {
                RiwayatDetailPeminjaman::create([
                    'riwayat_peminjaman_id' => $riwayatPeminjaman->id,
                    'barang_id' => $detail->barang_id,
                    'kode_barang' => $detail->kode_barang,
                    'nama_barang' => $detail->barang->nama_barang,
                ]);
            }
        });
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}