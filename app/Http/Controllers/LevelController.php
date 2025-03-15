<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list'  => ['Home', 'Level']
        ];
    
        $page = (object) [
            'title' => 'Daftar level dalam sistem'
        ];
    
        $activeMenu = 'level'; // 👈 Tambahkan ini
    
        $levels = LevelModel::all();
    
        return view('level.index', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'levels'     => $levels,
            'activeMenu' => $activeMenu // 👈 Pastikan ini dikirim ke view
        ]);
    }
    public function getData(Request $request) {
        $data = LevelModel::select(['level_id', 'level_nama']);
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
}


