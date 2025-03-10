<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 6, 'kategori_kode' => 'CML', 'kategori_nama' => 'Cemilan'],    // Tambahan
            ['kategori_id' => 7, 'kategori_kode' => 'MNR', 'kategori_nama' => 'Minuman Ringan'],      // Tambahan
        ];

        // Insert ke tabel m_kategori
        DB::table('m_kategori')->insert($data);
    }
}