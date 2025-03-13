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

            // Ambil informasi barang yang dipinjam
            $barangDipinjam = $peminjaman->detailPeminjaman->map(function ($detail) {
                return [
                    'nama_barang' => $detail->barang->nama_barang,
                    'kode_barang' => $detail->barang->kode_barang,
                    'jumlah' => $detail->jumlah, // Jika ada kolom jumlah
                ];
            });

            // Catat riwayat peminjaman beserta barang yang dipinjam
            RiwayatPeminjaman::create([
                'nama_peminjam' => $peminjaman->nama_peminjam,
                'unit' => $peminjaman->unit,
                'tempat' => $peminjaman->tempat,
                'acara' => $peminjaman->acara,
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'tanggal_kembali' => $peminjaman->tanggal_kembali,
                'barang_dipinjam' => $barangDipinjam, // Simpan daftar barang dalam format JSON
            ]);
        });
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}