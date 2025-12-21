<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokHistory extends Model
{
    use HasFactory;

    protected $table = 'stok_history';
    protected $primaryKey = 'history_id';
    
    protected $fillable = [
        'product_id',
        'perubahan',
        'tipe_perubahan',
        'keterangan',
        'user_id',
        'stok_sebelum',
        'stok_sesudah',
    ];

    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'product_id', 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
}