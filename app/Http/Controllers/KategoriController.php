<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    /**
     * Show the form to create a new post.
     */
    public function create(): View
    {
        return view('kategori.create');
    }

    /**
     * Store a new post.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_kode' => 'required',
            'kategori_nama' => 'required',
        ]);

        // The post is valid...

        return redirect('/kategori');
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
