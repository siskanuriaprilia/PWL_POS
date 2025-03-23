<?php

namespace App\Http\Controllers;
use App\Models\m_user;
use Illuminate\Http\Request;

class POSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $useri = m_user::all();
        return view('m_user.index', compact('useri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('m_user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //mlakukan validasi data
        $request->validate([
            'user-id' => 'max:20',
            'username' => 'required',
            'nama' => 'required',
        ]);

        m_user::create($request->all());

        return redirect()->route('m_user.index')
            ->with('success', 'User Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $useri = m_user::findOrFail($id);
        return view('m_user.show', compact('useri'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $useri = m_user::find($id);
        return view('m_user.edit', compact('useri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required',
        ]);

        m_user::find($id)->update($request->all());

        return redirect()->route('m_user.index')
            ->with('success', 'User Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $useri = m_user::findOrFail($id)->delete();
        return redirect()->route('m_user.index')
            ->with('success', 'User Berhasil Dihapus');
    }
}