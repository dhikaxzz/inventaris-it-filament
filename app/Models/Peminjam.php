<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class Peminjam extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'email', 'password', 'no_telepon', 'alamat', 'unit'];


    protected $hidden = ['password'];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($peminjam) {
            if ($peminjam->isDirty('password') && !empty($peminjam->password)) {
                $peminjam->password = Hash::make($peminjam->password);
            } else {
                unset($peminjam->password);
            }
        });
    }

}
