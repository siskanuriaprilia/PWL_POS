<?php
namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Data yang akan diupdate
        $data = [
            'nama' => 'Pelanggan Pertama',
        ];

        // Update data user berdasarkan username
        UserModel::where('username', 'customer-1')->update($data);

        // Ambil semua data user dari tabel m_user
        $user = UserModel::all();

        // Kirim data ke view
        return view('user', ['data' => $user]);
    }
}
