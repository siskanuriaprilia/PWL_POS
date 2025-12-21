<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kategori_kode' => 'BYT', 'kategori_nama' => 'Beauty'],
            ['kategori_kode' => 'SPORT', 'kategori_nama' => 'Sport'],
            ['kategori_kode' => 'FURN', 'kategori_nama' => 'Furniture'],
            ['kategori_kode' => 'TECH', 'kategori_nama' => 'Technology'],
            ['kategori_kode' => 'PSKB', 'kategori_nama' => 'Paskibraka'],
        ];
        
        DB::table('m_kategori')->insert($data);
    }
}