<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokHistory;
use App\Models\KategoriModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class StokManagementController extends Controller
{
    /**
     * Halaman utama manajemen stok
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Manajemen Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Manajemen Stok Barang'
        ];

        $activeMenu = 'stok';

        $kategori = KategoriModel::all();
        
        return view('stok.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'kategori' => $kategori
        ]);
    }

    public function list(Request $request)
    {
        $barangs = BarangModel::select(
            'barang_id',
            'barang_kode',
            'barang_nama',
            'stok',
            'harga_beli',
            'harga_jual',
            'kategori_id'
        )->with('kategori');

        // Filter berdasarkan kategori
        if ($request->kategori_id) {
            $barangs->where('kategori_id', $request->kategori_id);
        }

        // Filter berdasarkan status stok
        if ($request->status_stok) {
            if ($request->status_stok == 'habis') {
                $barangs->where('stok', 0);
            } elseif ($request->status_stok == 'menipis') {
                $barangs->where('stok', '<', 5)->where('stok', '>', 0);
            } elseif ($request->status_stok == 'tersedia') {
                $barangs->where('stok', '>=', 5);
            }
        }

        return DataTables::of($barangs)
            ->addIndexColumn()
            ->addColumn('status_stok', function ($barang) {
                if ($barang->stok == 0) {
                    return '<span class="badge badge-danger">Habis</span>';
                } elseif ($barang->stok < 5) {
                    return '<span class="badge badge-warning">Menipis</span>';
                } else {
                    return '<span class="badge badge-success">Tersedia</span>';
                }
            })
            ->addColumn('total_nilai_beli', function ($barang) {
                return 'Rp ' . number_format($barang->harga_beli * $barang->stok, 0, ',', '.');
            })
            ->addColumn('total_nilai_jual', function ($barang) {
                return 'Rp ' . number_format($barang->harga_jual * $barang->stok, 0, ',', '.');
            })
            ->addColumn('aksi', function ($barang) {
                $btn = '<a href="' . url('/stok/' . $barang->barang_id . '/history') . '" class="btn btn-info btn-sm">History</a> ';
                $btn .= '<button onclick="showStokModal(\'' . $barang->barang_id . '\', \'' . $barang->barang_nama . '\')" class="btn btn-warning btn-sm">Update Stok</button> ';
                $btn .= '<button onclick="showAdjustModal(\'' . $barang->barang_id . '\', \'' . $barang->barang_nama . '\', ' . $barang->stok . ')" class="btn btn-primary btn-sm">Adjust</button>';
                return $btn;
            })
            ->rawColumns(['status_stok', 'aksi'])
            ->make(true);
    }

    public function history($id)
    {
        $barang = BarangModel::with('kategori')->find($id);
        
        if (!$barang) {
            return redirect('/stok')->with('error', 'Barang tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'History Stok',
            'list' => ['Home', 'Stok', 'History']
        ];

        $page = (object) [
            'title' => 'History Stok: ' . $barang->barang_nama
        ];

        $activeMenu = 'stok';

        // Ambil history stok
        $histories = StokHistory::where('product_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('stok.history', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'barang' => $barang,
            'histories' => $histories
        ]);
    }

    /**
     * Tambah stok (masuk)
     */
    public function addStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:m_barang,barang_id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $barang = BarangModel::find($request->barang_id);
            $stokSebelum = $barang->stok;
            $stokSesudah = $stokSebelum + $request->jumlah;
            $barang->stok = $stokSesudah;
            $barang->save();

            StokHistory::create([
                'product_id' => $barang->barang_id,
                'perubahan' => $request->jumlah,
                'tipe_perubahan' => 'masuk',
                'keterangan' => $request->keterangan ?: 'Penambahan stok' . ($request->supplier ? ' dari ' . $request->supplier : ''),
                'user_id' => auth()->id(),
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Stok berhasil ditambahkan',
                'data' => [
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $stokSesudah,
                    'perubahan' => $request->jumlah
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah stok: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reduceStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:m_barang,barang_id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $barang = BarangModel::find($request->barang_id);
            $stokSebelum = $barang->stok;
            $stokSesudah = $stokSebelum - $request->jumlah;

            // Validasi stok cukup
            if ($stokSesudah < 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Stok tidak mencukupi. Stok saat ini: ' . $stokSebelum
                ], 400);
            }

            // Update stok barang
            $barang->stok = $stokSesudah;
            $barang->save();

            // Catat history
            StokHistory::create([
                'product_id' => $barang->barang_id,
                'perubahan' => -$request->jumlah,
                'tipe_perubahan' => 'keluar',
                'keterangan' => $request->keterangan,
                'user_id' => auth()->id(),
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Stok berhasil dikurangi',
                'data' => [
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $stokSesudah,
                    'perubahan' => -$request->jumlah
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengurangi stok: ' . $e->getMessage()
            ], 500);
        }
    }

    public function adjustStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:m_barang,barang_id',
            'stok_baru' => 'required|integer|min:0',
            'alasan' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $barang = BarangModel::find($request->barang_id);
            $stokSebelum = $barang->stok;
            $stokSesudah = $request->stok_baru;
            $perubahan = $stokSesudah - $stokSebelum;

            // Update stok barang
            $barang->stok = $stokSesudah;
            $barang->save();

            // Tentukan tipe perubahan
            $tipe = $perubahan >= 0 ? 'koreksi_tambah' : 'koreksi_kurang';

            // Catat history
            StokHistory::create([
                'product_id' => $barang->barang_id,
                'perubahan' => $perubahan,
                'tipe_perubahan' => $tipe,
                'keterangan' => 'Koreksi stok: ' . $request->alasan,
                'user_id' => auth()->id(),
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Stok berhasil dikoreksi',
                'data' => [
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $stokSesudah,
                    'perubahan' => $perubahan
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengkoreksi stok: ' . $e->getMessage()
            ], 500);
        }
    }


    public function report()
    {
        $breadcrumb = (object) [
            'title' => 'Laporan Stok',
            'list' => ['Home', 'Stok', 'Laporan']
        ];

        $page = (object) [
            'title' => 'Laporan Stok Barang'
        ];

        $activeMenu = 'stok';

        // Hitung total nilai stok
        $barangs = BarangModel::with('kategori')->get();
        
        $totalNilaiBeli = $barangs->sum(function($barang) {
            return $barang->stok * $barang->harga_beli;
        });
        
        $totalNilaiJual = $barangs->sum(function($barang) {
            return $barang->stok * $barang->harga_jual;
        });

        $stokMenipis = $barangs->where('stok', '<', 5)->where('stok', '>', 0);
        $stokHabis = $barangs->where('stok', 0);
        $stokTerbanyak = $barangs->sortByDesc('stok')->take(5);
        $nilaiTertinggi = $barangs->sortByDesc(function($barang) {
            return $barang->stok * $barang->harga_beli;
        })->take(5);

        return view('stok.report', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'barangs' => $barangs,
            'totalNilaiBeli' => $totalNilaiBeli,
            'totalNilaiJual' => $totalNilaiJual,
            'stokMenipis' => $stokMenipis,
            'stokHabis' => $stokHabis,
            'stokTerbanyak' => $stokTerbanyak,
            'nilaiTertinggi' => $nilaiTertinggi
        ]);
    }

    public function exportPdf()
    {
        $barangs = BarangModel::with('kategori')
            ->orderBy('kategori_id')
            ->orderBy('barang_nama')
            ->get();

        $totalNilaiBeli = $barangs->sum(function($barang) {
            return $barang->stok * $barang->harga_beli;
        });

        $totalNilaiJual = $barangs->sum(function($barang) {
            return $barang->stok * $barang->harga_jual;
        });

        $pdf = Pdf::loadView('stok.export_pdf', [
            'barangs' => $barangs,
            'totalNilaiBeli' => $totalNilaiBeli,
            'totalNilaiJual' => $totalNilaiJual,
            'tanggal' => now()->format('d/m/Y')
        ]);

        return $pdf->download('laporan-stok-' . date('Y-m-d') . '.pdf');
    }

    public function import(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Import Stok',
            'list' => ['Home', 'Stok', 'Import']
        ];

        $page = (object) [
            'title' => 'Import Data Stok'
        ];

        $activeMenu = 'stok';

        return view('stok.import', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function importAjax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'file_stok' => ['required', 'mimes:xlsx,xls', 'max:2048']
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'File berhasil diupload, proses import akan segera dimulai'
            ]);
        }

        return redirect('/stok');
    }
}