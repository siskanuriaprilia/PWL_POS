<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang'; // Nama tabel di database
    protected $primaryKey = 'barang_id'; // Primary Key

    public $timestamps = true; // Aktifkan `created_at` dan `updated_at`

    protected $fillable = [
        'kategori_id',
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
        'created_at',
        'updated_at',
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }
}