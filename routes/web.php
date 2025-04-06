<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthController;

Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']); 
    Route::post('/list', [UserController::class, 'list']); 
    Route::get('/create', [UserController::class, 'create']); 
    Route::post('/', [UserController::class, 'store']); 
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']); 
    Route::put('/{id}', [UserController::class, 'update']); 
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); 
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); 
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);  
    Route::delete('/{id}', [UserController::class, 'destroy']); 
});



// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);
// Route::get('/user/tambah',[UserController::class, 'tambah']);
// Route::post('/user/tambah_simpan',[UserController::class, 'tambah_simpan']);
// Route::get('/user/ubah/{id}',[UserController::class, 'ubah']);
// Route::put('/user/ubah_simpan/{id}',[UserController::class, 'ubah_simpan']);
// Route::get('/user/hapus/{id}',[UserController::class, 'hapus']);use App\Http\Controllers\LevelController;


Route::prefix('level')->group(function () {
    Route::get('/', [LevelController::class, 'index'])->name('level.index');
    Route::post('/list', [LevelController::class, 'getData'])->name('level.list');
});



Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::post('/ajax', [KategoriController::class, 'store'])->name('kategori.store');
    Route::post('/kategori/list', [KategoriController::class, 'getData'])->name('kategori.list');
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::get('/kategori/list', [KategoriController::class, 'getData'])->name('kategori.getData');
    Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax'])->name('kategori.create_ajax');
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});

Route::resource('barang', BarangController::class);
Route::get('/barang/data', [BarangController::class, 'getData'])->name('barang.data');



Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');



Route::pattern('id','[0-9]+');

Route::get('login', [AuthController::class,'login'])->name('login');
Route::post('login', [AuthController::class,'postLogin']); 
Route::get('logout', [AuthController::class,'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function(){
    Route::get('/', [UserController::class, 'index']); 
}); 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
