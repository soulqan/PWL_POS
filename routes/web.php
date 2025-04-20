<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;


Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('register.submit');

// Auth (login/logout)
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Redirect after login
Route::get('/', [WelcomeController::class, 'index'])->middleware('auth')->name('dashboard');

// Group yang butuh login
Route::middleware(['auth'])->group(function () {

    // USER
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index']);          // menampilkan halaman user
        Route::get('/list', [UserController::class, 'list']);       // menampilkan data user dalam bentuk json datatables    
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);
        Route::post('/ajax', [UserController::class, 'store_ajax']);
        Route::get('/import', [UserController::class, 'import']);
        Route::get('/edit_foto', [UserController::class, 'edit_foto']);
        Route::post('/import_ajax', [UserController::class, 'import_ajax']);
        Route::get('/export_excel', [UserController::class, 'export_excel']);
        Route::get('/export_pdf', [UserController::class, 'export_pdf']);
        Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
    });

    // // BARANG
    // Route::get('/barang', [BarangController::class, 'index']);
    // Route::post('/barang/list', [BarangController::class, 'list']);
    
    // Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // ajax form create
    // Route::post('/barang_ajax', [BarangController::class, 'store_ajax']); // ajax store
    
    // Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // ajax form edit
    // Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // ajax update
    
    // Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // ajax form confirm
    // Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // ajax delete
    
    

    // KATEGORI
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index']);
        Route::get('/list', [KategoriController::class, 'list']);
        Route::get('/create', [KategoriController::class, 'create']);
        Route::post('/', [KategoriController::class, 'store']); 
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
        Route::post('/ajax', [KategoriController::class, 'store_ajax']);
        Route::get('/import', [KategoriController::class, 'import']);
        Route::post('/import_ajax', [KategoriController::class, 'import_ajax']);
        Route::get('/export_excel', [KategoriController::class, 'export_excel']);
        Route::get('/export_pdf', [KategoriController::class, 'export_pdf']);
        Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
        Route::get('/{id}', [KategoriController::class, 'show']);
        Route::get('/{id}/edit', [KategoriController::class, 'edit']);
        Route::put('/{id}', [KategoriController::class, 'update']);
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
        Route::delete('/{id}', [KategoriController::class, 'destroy']);
    });

    // SUPPLIER
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');

    // Hanya untuk role ADM
    Route::group(['prefix' => 'level', 'middleware' => 'authorize:ADM'], function () {
        Route::get('/', [LevelController::class, 'index']);
        Route::get('/list', [LevelController::class, 'list']);
        Route::get('/create', [LevelController::class, 'create']);
        Route::post('/', [LevelController::class, 'store']);
        Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
        Route::post('/ajax', [LevelController::class, 'store_ajax']);
        Route::get('/import', [LevelController::class, 'import']);
        Route::post('/import_ajax', [LevelController::class, 'import_ajax']);
        Route::get('/export_excel', [LevelController::class, 'export_excel']);
        Route::get('/export_pdf', [LevelController::class, 'export_pdf']);
        Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
        Route::get('/{id}', [LevelController::class, 'show']);
        Route::get('/{id}/edit', [LevelController::class, 'edit']);
        Route::put('/{id}', [LevelController::class, 'update']);
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
        Route::delete('/{id}', [LevelController::class, 'destroy']);
    });


    // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager)
Route::middleware(['authorize:ADM,MNG'])->group(function(){
    Route::get('/barang',[BarangController::class,'index']);
    Route::get('/barang/list',[BarangController::class,'list']);
    Route::get('/barang/create_ajax',[BarangController::class,'create_ajax']); // ajax form create
    Route::post('/barang_ajax',[BarangController::class,'store_ajax']); // ajax store
    Route::get('/barang/{id}/edit_ajax',[BarangController::class,'edit_ajax']); // ajax form edit
    Route::get('/barang/{id}/show_ajax',[BarangController::class,'show_ajax']); // ajax form edit
    Route::put('/barang/{id}/update_ajax',[BarangController::class,'update_ajax']); // ajax update
    Route::get('/barang/{id}/delete_ajax',[BarangController::class,'confirm_ajax']); // ajax form confirm
    Route::delete('/barang/{id}/delete_ajax',[BarangController::class,'delete_ajax']); // ajax delete
    Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
    Route::get('/barang/export_excel', [BarangController::class, 'export_excel']); // ajax form upload excel
    Route::get('/barang/export_pdf', [BarangController::class, 'export_pdf']); // ajax form upload excel
    Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
    
});

});
