<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupplierController;

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
});

Route::resource('barang', BarangController::class);
Route::get('/barang/data', [BarangController::class, 'getData'])->name('barang.data');



Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
