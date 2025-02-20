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
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peminjam');
            $table->string('unit');
            $table->string('tempat');
            $table->string('acara')->nullable();
            $table->timestamp('tanggal_pinjam')->useCurrent(); // Otomatis dari created_at
            $table->date('tanggal_kembali');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
