<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // Mengacu ke barang_id
            $table->integer('perubahan'); // Nilai perubahan (+ untuk tambah, - untuk kurang)
            $table->string('tipe_perubahan', 20); // 'masuk', 'keluar', 'koreksi_tambah', 'koreksi_kurang'
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('stok_sebelum')->default(0);
            $table->integer('stok_sesudah')->default(0);
            $table->timestamps();

            // Foreign keys
            $table->foreign('product_id')->references('barang_id')->on('m_barang')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('m_user')->onDelete('set null');
            
            // Indexes
            $table->index(['product_id', 'created_at']);
            $table->index('tipe_perubahan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_history');
    }
};