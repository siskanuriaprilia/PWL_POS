<?php
namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'level_id' => 2,
            'username' => 'manager_dua',
            'nama' => 'Manager 2',
            'password' => Hash::make('12345')
        ];

        // Tambah data user ke database
        UserModel::create($data);

        // Ambil semua data user dari tabel m_user
        $user = UserModel::all();

        // Kirim data ke view
        return view('user', ['data' => $user]);
    }
}
