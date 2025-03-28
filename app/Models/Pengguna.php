<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengguna extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'email', 'no_telp', 'jabatan', 'unit', 'alamat'];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'nama_peminjam', 'nama');
    }
}
