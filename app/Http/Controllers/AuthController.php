<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) { // jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
    public function register(){
         $level = LevelModel::select('level_id','level_nama')->get();
 
         return View('auth.register')
         ->with('level', $level);
     }
 
     public function store_user(Request $request)
     {
         $request->validate([
             'username' => 'required|string|min:3|unique:m_user,username',
             'nama'     => 'required|string|max:100',
             'password' => 'required|min:5',
             'level_id' => 'required|integer',
         ]);
     
         // Menyimpan user baru
         UserModel::create([
             'username' => $request->username,
             'nama'     => $request->nama,
             'password' => bcrypt($request->password), // Enkripsi password
             'level_id' => $request->level_id,
         ]);
     
         // Mengirim respons JSON jika permintaan AJAX
         if ($request->ajax() || $request->wantsJson()) {
             return response()->json([
                 'status' => true,
                 'message' => 'Registrasi Berhasil',
                 'redirect' => url('login')
             ]);
         }
     
         // Jika bukan AJAX, redirect ke halaman utama dengan flash message
         return redirect('/')->with('success', 'Registrasi berhasil');
     }
     public function profile()
     {
         $user = Auth::user();
         $activeMenu = 'profile';
 
         $breadcrumb = (object) [
             'title' => 'Profil Pengguna',
             'list'  => ['Home', 'Profil']
         ];
 
         return view('profile.index', compact('user', 'activeMenu', 'breadcrumb'))->with([
             'status' => true,
             'data' => $user
         ]);
     }
 
     public function update(Request $request)
     {
         $user = Auth::user();
 
         $rules = [
             'username' => 'required|string|min:3|unique:m_user,username,' . $user->user_id . ',user_id',
             'nama' => 'required|string|max:100',
             'password' => 'nullable|min:6|confirmed',
             'profile_picture' => 'nullable|mimes:jpeg,png,jpg|max:2048',
         ];
 
         $validator = Validator::make($request->all(), $rules);
 
         if ($validator->fails()) {
             return redirect()->back()
                 ->withErrors($validator)
                 ->withInput();
         }
 
         $user->username = $request->username;
         $user->nama = $request->nama;
 
         if ($request->filled('password')) {
             $user->password = bcrypt($request->password);
         }
 
         if ($request->hasFile('profile_picture')) {
             $file = $request->file('profile_picture');
             $filename = time() . '.' . $file->getClientOriginalExtension();
             $file->move(public_path('uploads/profile'), $filename);
             $user->profile_picture = $filename;
         }
 
         /** @var \App\Models\User $user **/
         $user->save();
 
         return redirect()->route('profile')
             ->with('success', 'Profil berhasil diperbarui');
     }
}