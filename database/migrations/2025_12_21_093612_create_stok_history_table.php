// database/migrations/xxxx_create_stok_history_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_history', function (Blueprint $table) {
            $table->id('history_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('perubahan'); 
            $table->enum('tipe_perubahan', ['masuk', 'keluar', 'koreksi_tambah', 'koreksi_kurang']);
            $table->string('keterangan', 255)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->timestamps();

            $table->foreign('product_id')->references('barang_id')->on('m_barang')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('m_user')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_history');
    }
};