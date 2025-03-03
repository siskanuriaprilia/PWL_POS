<?php
namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];

        // // Tambah data user ke database
        // UserModel::create($data);

        // // Ambil semua data user dari tabel m_user
        // $user = UserModel::all();

        // // Kirim data ke view
        // return view('user', ['data' => $user]);


        //$user = UserModel::find(1);
        // $user = UserModel::FirstWhere('level_id',  1);
        // return view('user',['data'=> $user]);

        // $user = UserModel::findOr(20, ['username', 'nama'], function(){
        // abort(404);

        // });        

        // return view('user',['data'=> $user]);

        $user = UserModel::findOrFail(1);
        return  view('user',['data'=> $user]);

    }
}
