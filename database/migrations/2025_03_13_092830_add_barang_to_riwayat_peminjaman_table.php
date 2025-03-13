<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('riwayat_peminjaman', function (Blueprint $table) {
            $table->json('barang_dipinjam')->nullable(); // Menyimpan daftar barang dalam format JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_peminjaman', function (Blueprint $table) {
            $table->dropColumn('barang_dipinjam');
        });
    }
};
