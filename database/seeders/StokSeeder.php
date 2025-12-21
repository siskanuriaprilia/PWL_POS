<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan barang dan user sudah ada
        $barangCount = DB::table('m_barang')->count();
        $userCount = DB::table('m_user')->count();
        
        if ($barangCount == 0) {
            $this->call(BarangSeeder::class);
        }
        
        if ($userCount == 0) {
            $this->call(UserSeeder::class);
        }
        
        $data = [
            // Data stok untuk 5 barang pertama
            ['barang_id' => 1, 'user_id' => 1, 'stok_tanggal' => '2025-01-01', 'stok_jumlah' => 50],
            ['barang_id' => 2, 'user_id' => 2, 'stok_tanggal' => '2025-01-02', 'stok_jumlah' => 100],
            ['barang_id' => 3, 'user_id' => 3, 'stok_tanggal' => '2025-01-03', 'stok_jumlah' => 30],
            ['barang_id' => 4, 'user_id' => 3, 'stok_tanggal' => '2025-01-04', 'stok_jumlah' => 200],
            ['barang_id' => 5, 'user_id' => 3, 'stok_tanggal' => '2025-01-05', 'stok_jumlah' => 150],

            // Data stok untuk 5 barang berikutnya
            ['barang_id' => 6, 'user_id' => 2, 'stok_tanggal' => '2025-01-06', 'stok_jumlah' => 500],
            ['barang_id' => 7, 'user_id' => 2, 'stok_tanggal' => '2025-01-07', 'stok_jumlah' => 75],
            ['barang_id' => 8, 'user_id' => 2, 'stok_tanggal' => '2025-01-08', 'stok_jumlah' => 60],
            ['barang_id' => 9, 'user_id' => 2, 'stok_tanggal' => '2025-01-09', 'stok_jumlah' => 120],
            ['barang_id' => 10, 'user_id' => 2, 'stok_tanggal' => '2025-01-10', 'stok_jumlah' => 300],

            // Data stok untuk 5 barang terakhir
            ['barang_id' => 11, 'user_id' => 1, 'stok_tanggal' => '2025-01-11', 'stok_jumlah' => 80],
            ['barang_id' => 12, 'user_id' => 1, 'stok_tanggal' => '2025-01-12', 'stok_jumlah' => 50],
            ['barang_id' => 13, 'user_id' => 1, 'stok_tanggal' => '2025-01-13', 'stok_jumlah' => 90],
            ['barang_id' => 14, 'user_id' => 1, 'stok_tanggal' => '2025-01-14', 'stok_jumlah' => 25],
            ['barang_id' => 15, 'user_id' => 1, 'stok_tanggal' => '2025-01-15', 'stok_jumlah' => 10],
        ];

        // Insert data ke tabel t_stok
        DB::table('t_stok')->insert($data);
    }
}