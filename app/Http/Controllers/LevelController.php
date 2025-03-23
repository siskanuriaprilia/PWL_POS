<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreLevelRequest;

class LevelController extends Controller
{
    public function index()
    {
        $data = DB::select('SELECT * FROM m_level');
        return view('level', ['data' => $data]);
    }

    public function create()
{
    return view('level.tambah');
}


    public function store(StoreLevelRequest $request)
    {
        DB::insert('INSERT INTO m_level (level_kode, level_nama, created_at) VALUES (?, ?, ?)', [
            $request->level_kode,
            $request->level_nama,
            now()
        ]);

        return redirect('/level')->with('success', 'Level berhasil ditambahkan!');
    }
}