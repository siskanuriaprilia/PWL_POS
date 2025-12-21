<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['level_kode' => 'ADM', 'level_nama' => 'Administrator'],
            ['level_kode' => 'MNG', 'level_nama' => 'Manager'],
            ['level_kode' => 'STF', 'level_nama' => 'Staff'],
            ['level_kode' => 'KSR', 'level_nama' => 'Kasir'],
            ['level_kode' => 'CST', 'level_nama' => 'Customer'],
        ];
        
        DB::table('m_level')->insert($data);
    }
}