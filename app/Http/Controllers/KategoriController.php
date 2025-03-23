<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use App\DataTables\KategoriDataTable;
use Illuminate\Http\RedirectResponse;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
        
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'kategori_kode' => 'required|string|max:255',
            'kategori_nama' => 'required|string|max:255',
        ]);
    
        // Store the validated data
        KategoriModel::create($validated);
    
        // Redirect with success message
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }
    

    // Method edit
    public function edit($id)
    {
        // Cari data kategori berdasarkan ID
        // (sesuaikan 'id' atau 'kategori_id' dengan kolom primary key di DB)
        $kategori = KategoriModel::findOrFail($id);

        // Tampilkan view edit
        return view('kategori.edit', compact('kategori'));
    }

    // Method update
    public function update(Request $request, $id)
    {
        // Validasi data (opsional, tapi disarankan)
        $request->validate([
            'kategori_kode' => 'required',
            'kategori_nama' => 'required',
        ]);

        // Proses update data
        $kategori = KategoriModel::findOrFail($id);
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->kategori_nama = $request->kategori_nama;
        $kategori->save();

        // Redirect kembali ke halaman index
        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cari data kategori berdasarkan primary key (sesuaikan dengan kolom di DB)
        $kategori = KategoriModel::findOrFail($id);

        // Hapus data
        $kategori->delete();

        // Redirect kembali ke halaman index dengan pesan sukses (opsional)
        return redirect()->route('kategori.index')
                         ->with('success', 'Data Kategori berhasil dihapus.');
    }

}


// namespace App\Http\Controllers;

// use App\Models\KategoriModel;
// use Illuminate\Http\Request;
// use App\DataTables\KategoriDataTable;

// class KategoriController extends Controller
// {
//     public function index(KategoriDataTable $dataTable)
//     {
//         return $dataTable->render('kategori.index', [
//             'dataTable' => $dataTable
//         ]);
//     }

//     public function create()
//     {
//         return view('kategori.create');
//     }

//     public function store(Request $request)
//     {
//         KategoriModel::create([
//             'kategori_kode' => $request->kodeKategori,
//             'kategori_nama' => $request->namaKategori,
//         ]);

//         return redirect('/kategori');
//     }

//     // Menampilkan form edit
//     public function edit($id)
//     {
//         $kategori = KategoriModel::findOrFail($id);
//         return view('kategori.edit', compact('kategori'));
//     }

//     // Mengupdate data kategori
//     public function update(Request $request, $id)
//     {
//         $kategori = KategoriModel::findOrFail($id);
//         $kategori->update([
//             'kategori_kode' => $request->kodeKategori,
//             'kategori_nama' => $request->namaKategori,
//         ]);

//         return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
//     }

//     // Tambahkan action edit di DataTables
//     public function dataTableAction($kategori)
//     {
//         return '<a href="'.route('kategori.edit', $kategori->id).'" class="btn btn-sm btn-warning">Edit</a>';
//     }

//     //delete
//     public function destroy($id)
// {
//     $kategori = KategoriModel::findOrFail($id);
//     $kategori->delete();

//     return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
// }

// }
