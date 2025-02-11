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
        Schema::create('riwayat_kondisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->enum('kondisi_sebelumnya', ['Baik', 'Lecet', 'Rusak'])->nullable();
            $table->enum('kondisi_setelahnya', ['Baik', 'Lecet', 'Rusak']);
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal_perubahan')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_kondisi');
    }
};
