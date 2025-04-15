<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        // tambah data user dengan Eloquent Model
        // $data = [
        //     'level_id' => 4,
        //     'username' => 'customer-1',
        //     'nama' => 'Pelanggan',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::insert($data); //tambahkan data ke tabel m_user 

        // $data = [
        //     'nama' => 'Pelanggan Pertama',
        // ];
        // UserModel::where('username', 'customer-1')->update($data);//update data user

        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_dua',
        //     'nama' => 'Manager 2',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);
        //coba akses model usermodel
        // $user = UserModel::all(); //ambil semua data dari tabel m_user
        // $user = UserModel::find(1); //ambil data user dengan id 1
        // $user = UserModel::where('level_id', 1)->first(); // Mengambil satu data pertama dari tabel UserModel yang memiliki level_id = 1
        // $user = UserModel::firstWhere('level_id', 1); // Mengambil satu data pertama dari tabel UserModel yang memiliki level_id = 1 (sama seperti where()->first())

        // Mencari data UserModel dengan id = 1, hanya mengambil kolom 'username' dan 'nama'.
        // Jika data tidak ditemukan, jalankan fungsi abort(404) untuk menampilkan error 404
        // $user = UserModel::findOr(1, ['username', 'nama'], function () {
        //     abort(404);
        // });

        // $user = UserModel::findOr(20, ['username', 'nama'], function(){ //mencari id = 20 tapi tidak ditemukan
        //     abort(404);
        // });

        // Mencari data UserModel dengan id = 1.
        // Jika data tidak ditemukan, otomatis akan menampilkan error 404 (ModelNotFoundException).
        // $user = UserModel::findOrFail(1);

        // Mencari data UserModel dengan username 'manager9'.
        // Jika data tidak ditemukan, otomatis akan menampilkan error 404 (ModelNotFoundException)
        // $user = UserModel::where('username', 'manager9')->firstOrFail();

        // Menghitung jumlah data di tabel UserModel yang memiliki level_id = 2,
        // lalu menampilkan hasilnya menggunakan dd() (dump and die).
        // $user = UserModel::where('level_id', 2)->count();
        // dd($user);
        // return view('user', ['data' => $user]);

        // $jumlahPengguna = UserModel::where('level_id', 2)->count(); //menampilkan sesuai jobsheet
        // return view('user', compact('jumlahPengguna'));

        // Mencari data di tabel UserModel dengan 'username' = 'manager' dan 'nama' = 'Manager'.
        // Jika data ditemukan, akan mengambil data tersebut.
        // Jika data tidak ditemukan, akan membuat (insert) data baru dengan nilai yang diberikan.
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager'
        //     ],
        // );
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager22',
        //         'nama' => 'Manager Dua Dua',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );

        // Mencari data pengguna (user) pertama yang memiliki username 'manager' dan nama 'Manager'.
        // Jika tidak ditemukan, maka akan membuat instance baru dari UserModel dengan data tersebut, tanpa menyimpannya ke database.
        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ],
        // );
        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // $user->save();
        // return view('user', ['data' => $user]);

        // $user = UserModel::create([
        //     'username' => 'manager55',
        //     'nama' => 'Manager55',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);

        // $user->username = 'manager56';

        // $user->isDirty(); //true
        // $user-> isDirty('username'); //true
        // $user-> isDirty('nama'); //false
        // $user-> isDirty(['nama', 'username']); //true

        // $user->isClean(); //false
        // $user-> isClean('username'); //false
        // $user-> isClean('nama'); //true
        // $user-> isClean(['nama', 'username']); //false

        // $user->save();

        // $user->isDirty(); //false
        // $user->isClean();//true
        // dd($user->isDirty());

        // $user = UserModel::create([
        //     'username' => 'manager11',
        //     'nama' => 'Manager11',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);
        // $user->username = 'manager12';
        // $user->save();

        // $user->wasChanged(); //true
        // $user->wasChanged('username'); //true
        // $user->wasChanged(['username', 'level_id']); //true
        // $user->wasChanged('nama');//false
        // dd($user->wasChanged(['nama', 'username']));//true

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list'  => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        $level = LevelModel::all(); //ambil data level untuk filter level

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        // Filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                // $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list'  => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
        $activeMenu = 'user';       // set menu yang sedang aktif

        return view('user.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            // username harus diisi, string, minimal 3 karakter, dan unik di tabel m_user kolom username
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama'     => 'required|string|max:100',  // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'required|min:5',           // password harus diisi dan minimal 5 karakter
            'level_id' => 'required|integer'          // level_id harus diisi dan berupa angka
        ]);

        // Menyimpan data user baru
        UserModel::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => bcrypt($request->password), // password dienkripsi sebelum disimpan
            'level_id' => $request->level_id
        ]);

        // Redirect ke halaman user dengan pesan sukses
        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    // Menampilkan detail user
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list'  => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list'  => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            // username harus diisi, string, minimal 3 karakter,
            // dan bernilai unik di tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama'     => 'required|string|max:100', // nama harus diisi, string, maksimal 100 karakter
            'password' => 'nullable|min:5',          // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
            'level_id' => 'required|integer'         // level_id harus diisi dan berupa angka
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    // Menghapus data user
    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {    // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);    // Hapus data user

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')
            ->with('level', $level);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama'     => 'required|string|max:100',
                'password' => 'required|min:6'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            UserModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:6|max:20'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = UserModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $user = UserModel::find($id);
        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                try {
                    $user->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini'
                    ]);
                }
            }
        }
        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.show_ajax', [
            'user' => $user,
            'level' => $level
        ]);
    }

    public function import()
    {
        return view('user.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_user' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_user');

            try {
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true); // Kolom A, B, C, D

                $inserted = 0;
                foreach ($data as $key => $row) {
                    if ($key === 1) continue; // Skip header

                    $levelId  = $row['A'] ?? null;
                    $username = $row['B'] ?? null;
                    $nama     = $row['C'] ?? null;
                    $password = $row['D'] ?? null;

                    if ($levelId && $username && $nama && $password) {
                        // Cek apakah username sudah ada
                        $existing = UserModel::where('username', $username)->first();
                        if (!$existing) {
                            UserModel::create([
                                'level_id' => $levelId,
                                'username' => $username,
                                'nama'     => $nama,
                                'password' => Hash::make($password),
                            ]);
                            $inserted++;
                        }
                    }
                }

                return response()->json([
                    'status' => true,
                    'message' => "Import berhasil. $inserted data user ditambahkan."
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat memproses file: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('/');
    }
     //Menampilkan form export user
     public function export_excel()
     {
         // Ambil data users yang akan diekspor
         $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
             ->orderBy('user_id')
             ->with('level')
             ->get();

         // Load library PhpSpreadsheet
         $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif


         // Set header kolom
         $sheet->setCellValue('A1', 'No');
         $sheet->setCellValue('B1', 'User ID');
         $sheet->setCellValue('C1', 'Username');
         $sheet->setCellValue('D1', 'Nama');
         $sheet->setCellValue('E1', 'Level');

         // Format header bold
         $sheet->getStyle('A1:E1')->getFont()->setBold(true);

         // Isi data users
         $no = 1;
         $baris = 2;
         foreach ($users as $user) {
             $sheet->setCellValue('A' . $baris, $no);
             $sheet->setCellValue('B' . $baris, $user->user_id);
             $sheet->setCellValue('C' . $baris, $user->username);
             $sheet->setCellValue('D' . $baris, $user->nama);
             $sheet->setCellValue('E' . $baris, $user->level->level_nama);
             $baris++;
             $no++;
         }

         // Set auto size untuk kolom
         foreach (range('A', 'E') as $columnID) {
             $sheet->getColumnDimension($columnID)->setAutoSize(true);
         }

         // Set title sheet
         $sheet->setTitle('Data User');
         
         // Generate filename
         $filename = 'Data_User_' . date('Y-m-d_H-i-s') . '.xlsx';

         // Set header untuk download file
         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         header('Content-Disposition: attachment;filename="' . $filename . '"');
         header('Cache-Control: max-age=0');
         header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
         header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
         header('Cache-Control: cache, must-revalidate');
         header('Pragma: public');

         $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
         $writer->save('php://output');
         exit;
     }
}