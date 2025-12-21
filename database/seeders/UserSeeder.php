<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'level_id' => 1,
                'username' => 'admin',
                'nama' => 'Administrator',
                'password' => Hash::make('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_id' => 2,
                'username' => 'manager',
                'nama' => 'Manager Toko',
                'password' => Hash::make('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_id' => 3,
                'username' => 'staff1',
                'nama' => 'Staff Gudang 1',
                'password' => Hash::make('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_id' => 3,
                'username' => 'staff2',
                'nama' => 'Staff Gudang 2',
                'password' => Hash::make('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_id' => 4,
                'username' => 'kasir1',
                'nama' => 'Kasir 1',
                'password' => Hash::make('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        DB::table('m_user')->insert($data);
    }
}