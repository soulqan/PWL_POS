<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list'  => ['Home', 'Supplier']
        ];
    
        $page = (object) [
            'title' => 'Daftar Supplier dalam Sistem'
        ];
    
        $activeMenu = 'supplier';

        // Ambil semua data supplier
        $suppliers = Supplier::all();

        return view('supplier.index', compact('breadcrumb', 'page', 'suppliers', 'activeMenu'));
    }
}
