<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\dd;

class UserController extends Controller
{
    
        // Add user data with Eloquent Model
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // Access UserModel
        // $user = UserModel::find(1); // Get user with ID 1 from the m_user table
        // return view('user', ['data' => $user]);

        // $user = UserModel::where('level_id', 1)->first();
        // return view('user', ['data' => $user]);

        // $user = UserModel::firstWhere('level_id', 1);
        // return view('user', ['data' => $user]);

        // $user = UserModel::findOr(20, ['username', 'nama'], function(){
        //     abort(404);
        // });

        // return view('user', ['data' => $user]);

        // $user = UserModel::findOrFail(1);
        // return view('user', ['data' => $user]);

        // $user = UserModel::where('username', 'manager9')->firstOrFail();
        // return view('user', ['data' => $user]);

        // $user = UserModel::where('level_id', '2')->count();
        // //dd($user);
        // return view('user', ['data' => $user]);

        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ],
        // );
        // return view('user', ['data' => $user]);

        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager22',
        //         'nama' => 'Manager Dua Dua',
        //         'level_id' => 2
        //     ],
        //     [
        //         'password' => Hash::make('12345')
        //     ]
        // );
        // return view('user', ['data' => $user]);

        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ],
        // );
        // return view('user', ['data' => $user]);

        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'level_id' => 2
        //     ]
        // );
        
        // // Set password only if the user is new
        // if (!$user->exists) {
        //     $user->password = Hash::make('12345');
        // }
        
        // $user->save();
        // return view('user', ['data' => $user]);

        // $user = UserModel::create([
        //     'username' => 'manager55',
        //     'nama' => 'Manager55',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);

        // $user->username = 'manager56';

        // $user->isDirty(); // true
        // $user->isDirty('username'); // true
        // $user->isDirty('nama'); // false
        // $user->isDirty(['nama', 'username']); // true

        // $user->isClean(); // false
        // $user->isClean('username'); // false
        // $user->isClean('nama'); // true
        // $user->isClean(['nama', 'username']); // false

        // $user->save();

        // $user->isDirty(); // false
        // $user->isClean(); // true
        // dd($user->isDirty());

        // $user = UserModel::create([
        //     'username' => 'manager11',
        //     'nama' => 'Manager11',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);

        // $user->username = 'manager12';

        // $user->save();

        // $user->wasChanged();// true
        // $user->wasChanged('username'); // true
        // $user->wasChanged(['username', 'level_id']); // false
        // $user->wasChanged('nama'); // false
        // dd($user->wasChanged(['nama', 'username']));// true
        
        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        // $user = UserModel::with('level')->get();
        // dd($user);

        // public function index()
        // {
        //     $user = UserModel::all();
        //     return view('user', ['data' => $user]);
        // }
    
        // // Menampilkan form tambah user
        // public function tambah()
        // {
        //     return view('user_tambah');
        // }
    
        // // Menyimpan data user baru
        // public function tambah_simpan(Request $request)
        // {
        //     UserModel::create([
        //         'username' => $request->username,
        //         'nama' => $request->nama,
        //         'password' => Hash::make($request->password),
        //         'level_id' => $request->level_id
        //     ]);
    
        //     return redirect('/user');
        // }
    
        // // Menampilkan form ubah user
        // public function ubah($id)
        // {
        //     $user = UserModel::find($id);
        //     return view('user_ubah', ['data' => $user]);
        // }
    
        // // Menyimpan perubahan data user
        // public function ubah_simpan($id, Request $request)
        // {
        //     $user = UserModel::find($id);
    
        //     $user->username = $request->username;
        //     $user->nama = $request->nama;
        //     $user->password = Hash::make($request->password);
        //     $user->level_id = $request->level_id;
    
        //     $user->save();
    
        //     return redirect('/user');
        // }
    
        // // Menghapus data user
        // public function hapus($id)
        // {
        //     $user = UserModel::find($id);
        //     $user->delete();
    
        //     return redirect('/user');
        //}
        public function index()
        {
            $user = userModel:: with('level')->get();
            return view ('user',['data' => $user]);
        }
}
    
    