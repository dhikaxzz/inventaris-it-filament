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
        Schema::create('riwayat_detail_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('riwayat_peminjaman_id'); // Relasi ke riwayat_peminjaman
            $table->unsignedBigInteger('barang_id'); // Relasi ke barang
            $table->string('kode_barang'); // Kode barang yang dipinjam
            $table->string('nama_barang'); // Nama barang yang dipinjam
            $table->timestamps();

            // Foreign key ke riwayat_peminjaman
            $table->foreign('riwayat_peminjaman_id')->references('id')->on('riwayat_peminjaman')->onDelete('cascade');
            // Foreign key ke barang
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_detail_peminjaman');
    }
};
