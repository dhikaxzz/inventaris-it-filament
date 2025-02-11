<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class RiwayatKondisi extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kondisi';

    protected $fillable = [
        'barang_id',
        'kondisi_sebelumnya',
        'kondisi_setelahnya',
        'keterangan',
        'tanggal_perubahan',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
