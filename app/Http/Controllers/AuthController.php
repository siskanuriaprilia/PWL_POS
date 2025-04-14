<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login()
    {
        // Jika sudah login, redirect ke halaman home
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors(),
            ]);
        }
    
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return response()->json([
                'status' => true,
                'message' => 'Login berhasil!',
                'redirect' => url('/'), // arahkan ke dashboard atau halaman utama
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Username atau password salah!',
                'msgField' => [
                    'username' => ['Periksa kembali username Anda.'],
                    'password' => ['Periksa kembali password Anda.'],
                ]
            ]);
        }
    }
    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login'); // Atau arahkan ke halaman lain setelah logout
}

}   