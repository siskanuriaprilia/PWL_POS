<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan PENTING!
        $this->call([
            LevelSeeder::class,       // 1. Level dulu
            UserSeeder::class,        // 2. User (butuh level_id)
            KategoriSeeder::class,    // 3. Kategori
            BarangSeeder::class,      // 4. Barang (butuh kategori_id)
            StokSeeder::class,        // 5. Stok (butuh barang_id dan user_id)
        ]);
    }
}