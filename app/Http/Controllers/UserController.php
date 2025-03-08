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

        // $user = UserModel::where('username', 'manager9')->firstOrFail();
        // return  view('user',['data'=> $user]);

            // Ambil semua data user dengan level_id = 2
        //     $userCount = UserModel::where('level_id', 2)->count();
        // return view('user', ['userCount' => $userCount]);

        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ],
        // );
        
        // return view('user', ['data' => $user]);


        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ]
        // );

        // return view('user', ['data' => $user]);

        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ]
        // );

        // return view('user', ['data' => $user]);

        // Pastikan kolom password terisi dengan benar
        // $user = UserModel::firstOrNew([
        //     'username' => 'manager33',
        //     'nama' => 'Manager Tiga Tiga',
        //     'level_id' => 2
        // ]);

        // // Tambahkan password jika belum ada
        // if (!$user->exists) {
        //     $user->password = Hash::make('12345');
        // }

        // $user->save();

        // // Tampilkan data user untuk memastikan

        // $user = UserModel::create([
        //     'username' => 'manage55',
        //     'nama' => 'Manager55',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);
        

        // $user->username = 'manager56';
        
        // // Mengecek apakah ada perubahan data
        // $user->isDirty(); // true
        // $user->isDirty('username'); // true
        // $user->isDirty('nama'); // false
        // $user->isDirty(['nama', 'username']); // true
        
        // // Mengecek apakah data bersih (tidak ada perubahan)
        // $user->isClean(); // false
        // $user->isClean('username'); // false
        // $user->isClean('nama'); // true
        // $user->isClean(['nama', 'username']); // false
        
        // // Menyimpan perubahan data ke database
        // $user->save();
        
        // // Mengecek ulang setelah penyimpanan
        // $user->isDirty(); // false
        // $user->isClean(); // true
        // dd($user->isDirty());

        $user = UserModel::create([
            'username' => 'manager11',
            'nama' => 'Manager11',
            'password' => Hash::make('12345'),
            'level_id' => 2,
        ]);

        $user->username = 'manager12';

        $user->save();

        // Mengecek apakah ada perubahan data setelah penyimpanan
        $user->wasChanged(); // true
        $user->wasChanged('username'); // true
        $user->wasChanged(['username', 'level_id']); // true
        $user->wasChanged('nama'); // false
        dd($user->wasChanged(['nama', 'username'])); // true
        
    }
}  

   