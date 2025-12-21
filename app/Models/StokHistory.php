<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokHistory extends Model
{
    use HasFactory;

    protected $table = 'stok_history';
    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id',
        'perubahan',
        'tipe_perubahan',
        'keterangan',
        'user_id',
        'stok_sebelum',
        'stok_sesudah',
    ];

    // Relasi ke barang
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'product_id', 'barang_id');
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    // ✅ Accessor untuk badge tipe perubahan
    public function getTipeBadgeAttribute()
    {
        $badges = [
            'masuk' => '<span class="badge badge-success">Masuk</span>',
            'keluar' => '<span class="badge badge-danger">Keluar</span>',
            'koreksi_tambah' => '<span class="badge badge-info">Koreksi (+)</span>',
            'koreksi_kurang' => '<span class="badge badge-warning">Koreksi (-)</span>',
        ];

        return $badges[$this->tipe_perubahan] ?? '<span class="badge badge-secondary">-</span>';
    }

    // ✅ Accessor untuk format perubahan
    public function getPerubahanFormattedAttribute()
    {
        $sign = $this->perubahan >= 0 ? '+' : '';
        $icon = $this->perubahan >= 0 ? '<i class="fas fa-arrow-up"></i>' : '<i class="fas fa-arrow-down"></i>';
        
        return $icon . ' ' . $sign . number_format($this->perubahan);
    }

    // ✅ Scope untuk filter
    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('tipe_perubahan', $type);
    }

    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}