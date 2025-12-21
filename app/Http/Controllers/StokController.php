<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        $activeMenu = 'stok';
        $breadcrumb = (object) [
            'title' => 'Manajemen Stok',
            'list' => ['Home', 'Stok']
        ];

        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'stok')->get();
        
        return view('stok.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'barang' => $barang
        ]);
    }

    public function list(Request $request)
    {
        $barang = BarangModel::with('kategori')
            ->select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'stok', 'kategori_id');
        
        // Filter berdasarkan kategori
        if($request->filter_kategori){
            $barang->where('kategori_id', $request->filter_kategori);
        }
        
        // Filter berdasarkan status stok
        if($request->filter_status){
            if($request->filter_status == 'habis'){
                $barang->where('stok', 0);
            } elseif($request->filter_status == 'menipis'){
                $barang->where('stok', '<', 5)->where('stok', '>', 0);
            } elseif($request->filter_status == 'tersedia'){
                $barang->where('stok', '>=', 5);
            }
        }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('status_stok', function ($barang) {
                return $barang->status_stok;
            })
            ->addColumn('aksi', function ($barang) {
                $btn = '<button onclick="modalAction(\''.url('/stok/' . $barang->barang_id . '/update').'\')" class="btn btn-primary btn-sm">Update Stok</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/stok/' . $barang->barang_id . '/history').'\')" class="btn btn-info btn-sm">History</button>';
                return $btn;
            })
            ->rawColumns(['status_stok', 'aksi'])
            ->make(true);
    }

    // ✅ Form untuk update stok
    public function updateForm($id)
    {
        $barang = BarangModel::find($id);
        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ]);
        }

        return view('stok.update_form', compact('barang'));
    }

    // ✅ Proses update stok
    public function update(Request $request, $id)
    {
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                'tipe_perubahan' => ['required', 'in:masuk,keluar,koreksi_tambah,koreksi_kurang'],
                'jumlah' => ['required', 'integer', 'min:1'],
                'keterangan' => ['nullable', 'string', 'max:255'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $barang = BarangModel::find($id);
            if (!$barang) {
                return response()->json([
                    'status' => false,
                    'message' => 'Barang tidak ditemukan'
                ]);
            }

            // Validasi stok keluar tidak melebihi stok tersedia
            if (($request->tipe_perubahan == 'keluar' || $request->tipe_perubahan == 'koreksi_kurang') && 
                $request->jumlah > $barang->stok) {
                return response()->json([
                    'status' => false,
                    'message' => 'Jumlah keluar melebihi stok tersedia. Stok saat ini: ' . $barang->stok
                ]);
            }

            try {
                $result = $barang->updateStok(
                    $request->jumlah,
                    $request->tipe_perubahan,
                    $request->keterangan,
                    auth()->id()
                );

                return response()->json([
                    'status' => true,
                    'message' => 'Stok berhasil diupdate',
                    'data' => $result
                ]);
                
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }
        
        return redirect('/stok');
    }

    // ✅ History stok per barang
    public function history($id)
    {
        $barang = BarangModel::find($id);
        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ]);
        }

        $histories = $barang->getRiwayatStok(50);
        
        return view('stok.history', compact('barang', 'histories'));
    }

    // ✅ History semua stok
    public function historyAll(Request $request)
    {
        $histories = StokHistory::with(['barang', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Filter
        if($request->product_id){
            $histories = StokHistory::where('product_id', $request->product_id)
                ->with(['barang', 'user'])
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        if($request->ajax() || $request->wantsJson()){
            return DataTables::of($histories)
                ->addIndexColumn()
                ->addColumn('barang_info', function ($history) {
                    return $history->barang ? $history->barang->barang_kode . ' - ' . $history->barang->barang_nama : '-';
                })
                ->addColumn('user_info', function ($history) {
                    return $history->user ? $history->user->nama : '-';
                })
                ->addColumn('tipe_badge', function ($history) {
                    return $history->tipe_badge;
                })
                ->addColumn('perubahan_formatted', function ($history) {
                    return $history->perubahan_formatted;
                })
                ->addColumn('stok_info', function ($history) {
                    return number_format($history->stok_sebelum) . ' → ' . number_format($history->stok_sesudah);
                })
                ->addColumn('waktu', function ($history) {
                    return $history->created_at->format('d-m-Y H:i:s');
                })
                ->rawColumns(['tipe_badge', 'perubahan_formatted'])
                ->make(true);
        }

        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama')->get();
        
        $activeMenu = 'stok';
        $breadcrumb = (object) [
            'title' => 'History Semua Stok',
            'list' => ['Home', 'Stok', 'History']
        ];

        return view('stok.history_all', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'barang' => $barang,
            'histories' => $histories
        ]);
    }
}