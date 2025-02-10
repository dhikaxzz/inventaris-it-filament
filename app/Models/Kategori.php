<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris'; // Sesuai dengan nama tabel di database
    protected $fillable = ['nama_kategori'];

    // Relasi ke Barang
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}
