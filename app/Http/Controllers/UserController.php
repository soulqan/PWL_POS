<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';

        $level = LevelModel::all();

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    public function show($id)
    {
        $user = UserModel::findOrFail($id);
        return view('user.show', compact('user'));
    }
    
    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .'/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .'/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .'/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')
            ->with('level', $level);
    }

    public function show_ajax(string $id) {
        $user = UserModel::with('level')->find($id);

        return view('user.show_ajax', ['user' => $user]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:6'
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        UserModel::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil disimpan'
        ]);

        redirect('/');
    }

    public function edit_ajax(string $id) {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,'.$id.',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:6|max20'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = UserModel::find($id);
            if ($check) {
                if (!$request->filled('password')) {
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
    }

    public function confirm_ajax(string $id) {
        $user = UserModel::find($id);

        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            $userId = Auth::id();
            if ($id == $userId) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak dapat menghapus akun sendiri'
                ]);
            } else if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
            return redirect('/');
        }
    }

    public function import() {
        return view('user.import');
    }

    public function import_ajax(Request $request) {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
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

            $file = $request->file('file_user'); // ambil file dari request

            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif

            $data = $sheet->toArray(null, false, true, true); // ambil data excel

            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if($baris > 1) {
                        $insert[] =[
                            'level_id' => $value['A'],
                            'username' => $value['B'],
                            'nama' => $value['C'],
                            'password' => $value['D'],
                            'created_at' => now(),
                        ];
                    }
                }
                
                if(count($insert) > 0) {
                    //insert data ke database, jika data sudah ada, maka diabaikan
                    UserModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada daya yang diimport'
                ]);
            }
            return redirect('/');
        }
    }

    public function export_excel() {
        // ambil data yang akan di export
        $user = UserModel::select('level_id', 'username', 'nama', 'password')
            ->orderBy('level_id')
            ->with('level')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Level Pengguna');
        $sheet->setCellValue('E1', 'password');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true); //bold header

        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($user as $key => $value) {
            $sheet->setCellValue('A'.$baris, $no);
            $sheet->setCellValue('B'.$baris, $value->username);
            $sheet->setCellValue('C'.$baris, $value->nama);
            $sheet->setCellValue('D'.$baris, $value->level->level_nama);
            $sheet->setCellValue('E'.$baris, $value->password);
            $baris++;
            $no++;
        }

        foreach(range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data User'); // set title sheet

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data User ' .date('Y-m-d H:i:s'). '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf() {
        $user = UserModel::select('level_id', 'username', 'nama', 'password')
            ->orderBy('level_id')
            ->orderBy('username')
            ->with('level')
            ->get();
        $pdf = Pdf::loadView('user.export_pdf', ['user' => $user]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data User '.date('Y-m-d H:i:s'). '.pdf');
    }

    public function edit_foto() {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';

        $level = LevelModel::all();
        return view('user.edit_foto', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update_profile(Request $request, $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_profile' => ['mimes:jpeg,jpg,png', 'max:5120'],
                'nama' => 'required|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = UserModel::find($id);
            if ($check) {
                if ($request->hasFile('file_profile')) {
                    $file = $request->file('file_profile');
                    $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('profile_pict'), $filename);
                    
                    $check->profile_photo = $filename;
                } 
                $check->nama = $request->nama;
                $check->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Data profil berhasil diupdate.'
                ]);
            } else {
                return response()->json([
                    'status' => false, 
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
    }
}