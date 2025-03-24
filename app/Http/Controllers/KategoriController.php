<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list'  => ['Home', 'Kategori']
        ];
    
        $page = (object) [
            'title' => 'Daftar kategori yang tersedia dalam sistem'
        ];
    
        $activeMenu = 'kategori'; // Menandai menu aktif
    
        $kategoris = Kategori::all(); // Mengambil semua data kategori
    
        return view('kategori.index', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'kategoris'  => $kategoris,
            'activeMenu' => $activeMenu
        ]);
    }
    public function create()
{
    $breadcrumb = (object) [
        'title' => 'Tambah Kategori',
        'list'  => ['Home', 'Kategori', 'Tambah']
    ];

    $page = (object) [
        'title' => 'Tambah kategori baru'
    ];

    $activeMenu = 'kategori';

    return view('kategori.create', [
        'breadcrumb' => $breadcrumb,
        'page'       => $page,
        'activeMenu' => $activeMenu
    ]);
}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|min:3|max:100',
            'deskripsi' => 'nullable|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msgField' => $validator->errors(),
                'message' => 'Validasi gagal, periksa kembali inputan Anda.'
            ], 422);
        }

        Kategori::create($request->only(['nama_kategori', 'deskripsi']));

        return response()->json([
            'status' => true,
            'message' => 'Kategori berhasil ditambahkan!'
        ]);
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $kategori
        ]);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|min:3|max:100',
            'deskripsi' => 'nullable|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msgField' => $validator->errors(),
                'message' => 'Validasi gagal, periksa kembali inputan Anda.'
            ], 422);
        }

        $kategori->update($request->only(['nama_kategori', 'deskripsi']));

        return response()->json([
            'status' => true,
            'message' => 'Kategori berhasil diperbarui!'
        ]);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        $kategori->delete();

        return response()->json([
            'status' => true,
            'message' => 'Kategori berhasil dihapus!'
        ]);
    }

  

public function getData(Request $request)
{
    $query = Kategori::select(['kategori_id', 'kategori_kode', 'kategori_nama']);

    return DataTables::of($query)
        ->addColumn('aksi', function ($row) {
            return '<a href="#" class="btn btn-sm btn-warning">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger">Hapus</a>';
        })
        ->rawColumns(['aksi'])
        ->make(true);
}

public function create_ajax()
{
    return view('kategori.create_ajax'); // Pastikan file Blade ini ada
}

}
