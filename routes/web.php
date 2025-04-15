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
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/list', [UserController::class, 'list'])->name('list');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/create_ajax', [UserController::class, 'create_ajax'])->name('create_ajax');
        Route::post('/ajax', [UserController::class, 'store_ajax'])->name('store_ajax');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax'])->name('edit_ajax');
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax'])->name('update_ajax');
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax'])->name('confirm_ajax');
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax'])->name('delete_ajax');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
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
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('/create', [KategoriController::class, 'create'])->name('create');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::post('/ajax', [KategoriController::class, 'store'])->name('store_ajax');
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax'])->name('create_ajax');
        Route::post('/list', [KategoriController::class, 'getData'])->name('list');
        Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('edit');
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit'])->name('edit_ajax');
        Route::put('/{id}', [KategoriController::class, 'update'])->name('update');
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update'])->name('update_ajax');
        Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy');
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'destroy'])->name('destroy_ajax');
    });

    // SUPPLIER
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');

    // Hanya untuk role ADM
    Route::middleware(['authorize:ADM'])->prefix('level')->name('level.')->group(function () {
        Route::get('/', [LevelController::class, 'index'])->name('index');
        Route::post('/list', [LevelController::class, 'list'])->name('list');
        Route::get('/create', [LevelController::class, 'create'])->name('create');
        Route::post('/', [LevelController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [LevelController::class, 'edit'])->name('edit');
        Route::put('/{id}', [LevelController::class, 'update'])->name('update');
        Route::delete('/{id}', [LevelController::class, 'destroy'])->name('destroy');
    });

    // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager)
Route::middleware(['authorize:ADM,MNG'])->group(function(){
    Route::get('/barang',[BarangController::class,'index']);
    Route::get('/barang/list',[BarangController::class,'list']);
    Route::get('/barang/create_ajax',[BarangController::class,'create_ajax']); // ajax form create
    Route::post('/barang_ajax',[BarangController::class,'store_ajax']); // ajax store
    Route::get('/barang/{id}/edit_ajax',[BarangController::class,'edit_ajax']); // ajax form edit
    Route::put('/barang/{id}/update_ajax',[BarangController::class,'update_ajax']); // ajax update
    Route::get('/barang/{id}/delete_ajax',[BarangController::class,'confirm_ajax']); // ajax form confirm
    Route::delete('/barang/{id}/delete_ajax',[BarangController::class,'delete_ajax']); // ajax delete
    Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
    Route::get('/barang/export_excel', [BarangController::class, 'export_excel']); // ajax form upload excel
    Route::get('/barang/export_pdf', [BarangController::class, 'export_pdf']); // ajax form upload excel
    Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
    
});

});
