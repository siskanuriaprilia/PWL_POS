<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 2,
                'barang_kode' => 'SPORT1',
                'barang_nama' => 'Onitsuka Pink',
                'harga_beli' => 3000000,
                'harga_jual' => 2500000,
                'stok' => 50, // ✅ TAMBAHKAN STOK
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'SPORT2',
                'barang_nama' => 'Kronikel Project',
                'harga_beli' => 500000,
                'harga_jual' => 550000,
                'stok' => 100,
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'SPORT3',
                'barang_nama' => 'New Balance 550',
                'harga_beli' => 1000000,
                'harga_jual' => 1800000,
                'stok' => 30,
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'BYT1',
                'barang_nama' => 'Cushion Wardah Color Fit',
                'harga_beli' => 100000,
                'harga_jual' => 120000,
                'stok' => 200,
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'BYT2',
                'barang_nama' => 'Powder Foundation Color Fit',
                'harga_beli' => 100000,
                'harga_jual' => 130000,
                'stok' => 150,
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'BYT3',
                'barang_nama' => 'Lip Balm Wardah Grape',
                'harga_beli' => 20000,
                'harga_jual' => 28000,
                'stok' => 500,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'FURN1',
                'barang_nama' => 'Sapu',
                'harga_beli' => 20000,
                'harga_jual' => 25000,
                'stok' => 75,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'FURN2',
                'barang_nama' => 'Bolde Pel',
                'harga_beli' => 30000,
                'harga_jual' => 35000,
                'stok' => 60,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'FURN3',
                'barang_nama' => 'Sulak',
                'harga_beli' => 15000,
                'harga_jual' => 20000,
                'stok' => 120,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'TECH1',
                'barang_nama' => 'USB Cable',
                'harga_beli' => 20000,
                'harga_jual' => 30000,
                'stok' => 300,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'TECH2',
                'barang_nama' => 'Logitech Mouse',
                'harga_beli' => 100000,
                'harga_jual' => 110000,
                'stok' => 80,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'TECH3',
                'barang_nama' => 'Touchpen',
                'harga_beli' => 120000,
                'harga_jual' => 130000,
                'stok' => 50,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'PSKB1',
                'barang_nama' => 'Pantofel 5 cm',
                'harga_beli' => 50000,
                'harga_jual' => 55000,
                'stok' => 90,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'PSKB2',
                'barang_nama' => 'PDL Paskibraka',
                'harga_beli' => 300000,
                'harga_jual' => 350000,
                'stok' => 25,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'PSKB3',
                'barang_nama' => 'Bendera Merah Putih',
                'harga_beli' => 1000000,
                'harga_jual' => 1500000,
                'stok' => 10,
            ]
        ];
        
        DB::table('m_barang')->insert($data);
        
        // ✅ Create initial stok history untuk setiap barang
        $this->createInitialStokHistory();
    }
    
    private function createInitialStokHistory(): void
    {
        $barangs = DB::table('m_barang')->get();
        
        foreach ($barangs as $barang) {
            DB::table('stok_history')->insert([
                'product_id' => $barang->barang_id,
                'perubahan' => $barang->stok,
                'tipe_perubahan' => 'masuk',
                'keterangan' => 'Stok awal sistem',
                'user_id' => 1, // admin
                'stok_sebelum' => 0,
                'stok_sesudah' => $barang->stok,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}