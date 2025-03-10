<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 2,
                'barang_kode' => 'SPORT1',
                'barang_nama' => 'Onitsuka Pink',
                'harga_beli' => 3000000,
                'harga_jual' => 2500000
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'SPORT2',
                'barang_nama' => 'Kronikel Project',
                'harga_beli' => 500000,
                'harga_jual' => 550000
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'SPORT3',
                'barang_nama' => 'New Balance 550',
                'harga_beli' => 1000000,
                'harga_jual' => 1800000
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'BYT1',
                'barang_nama' => 'Cushion Wardah Color Fit',
                'harga_beli' => 100000,
                'harga_jual' => 120000
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'BYT2',
                'barang_nama' => 'Powder Foundation Color Fit',
                'harga_beli' => 100000,
                'harga_jual' => 130000
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'BYT3',
                'barang_nama' => 'Lip Balm Wardah Grape',
                'harga_beli' => 20000,
                'harga_jual' => 28000
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'FURN1',
                'barang_nama' => 'Sapu',
                'harga_beli' => 20000,
                'harga_jual' => 25000
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'FURN2',
                'barang_nama' => 'Bolde Pel',
                'harga_beli' => 30000,
                'harga_jual' => 35000
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'FURN3',
                'barang_nama' => 'Sulak',
                'harga_beli' => 15000,
                'harga_jual' => 20000
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'TECH1',
                'barang_nama' => 'USB Cable',
                'harga_beli' => 20000,
                'harga_jual' => 30000
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'TECH2',
                'barang_nama' => 'Logitech Mouse',
                'harga_beli' => 100000,
                'harga_jual' => 110000
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'TECH3',
                'barang_nama' => 'Touchpen',
                'harga_beli' => 120000,
                'harga_jual' => 130000
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'PSKB1',
                'barang_nama' => 'Pantofel 5 cm',
                'harga_beli' => 50000,
                'harga_jual' => 55000
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'PSKB2',
                'barang_nama' => 'PDL Paskibraka',
                'harga_beli' => 300000,
                'harga_jual' => 350000
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'PSKB3',
                'barang_nama' => 'Bendera Merah Putih',
                'harga_beli' => 1000000,
                'harga_jual' => 1500000
            ]
        ];
        
        DB::table('m_barang')->insert($data);
    }
}