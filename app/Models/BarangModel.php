<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';

    protected $fillable = [
        'kategori_id',
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
        'stok', // ✅ TAMBAHKAN STOK
        'created_at',
        'updated_at',
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

    // ✅ Relasi ke stok history
    public function stokHistories()
    {
        return $this->hasMany(StokHistory::class, 'product_id', 'barang_id')
            ->orderBy('created_at', 'desc');
    }

    // ✅ Method untuk update stok
    public function updateStok($perubahan, $tipe, $keterangan = null, $userId = null)
    {
        \DB::beginTransaction();
        
        try {
            $stokSebelum = $this->stok;
            
            // Update stok barang
            if ($tipe == 'masuk' || $tipe == 'koreksi_tambah') {
                $this->stok += $perubahan;
            } elseif ($tipe == 'keluar' || $tipe == 'koreksi_kurang') {
                $this->stok -= $perubahan;
                
                // Validasi stok tidak boleh negatif
                if ($this->stok < 0) {
                    throw new \Exception('Stok tidak boleh negatif. Stok saat ini: ' . $stokSebelum);
                }
            }
            
            $this->save();

            // ✅ Simpan ke history stok
            StokHistory::create([
                'product_id' => $this->barang_id,
                'perubahan' => $tipe == 'keluar' || $tipe == 'koreksi_kurang' ? -$perubahan : $perubahan,
                'tipe_perubahan' => $tipe,
                'keterangan' => $keterangan,
                'user_id' => $userId ?? auth()->id(),
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $this->stok,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            \DB::commit();
            
            return [
                'success' => true,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $this->stok
            ];
            
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }
    }

    // ✅ Method untuk mendapatkan riwayat stok
    public function getRiwayatStok($limit = 10)
    {
        return $this->stokHistories()
            ->with('user')
            ->limit($limit)
            ->get();
    }

    // ✅ Accessor untuk status stok
    public function getStatusStokAttribute()
    {
        if ($this->stok == 0) {
            return '<span class="badge badge-danger">Habis</span>';
        } elseif ($this->stok < 5) {
            return '<span class="badge badge-warning">Menipis</span>';
        } else {
            return '<span class="badge badge-success">Tersedia</span>';
        }
    }
}