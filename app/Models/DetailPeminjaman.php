<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjaman';

    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'kode_barang',
        'status',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($detailPeminjaman) {
            $detailPeminjaman->kode_barang = Barang::where('id', $detailPeminjaman->barang_id)->value('kode_barang');
        });
    }

}
