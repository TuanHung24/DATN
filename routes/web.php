<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\LoaiSanPhamController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::middleware('auth')->group(function(){
    Route::get('san-pham/them-moi', [SanPhamController::class, 'themMoi'])->name('san-pham.them-moi');
    Route::post('san-pham/them-moi', [SanPhamController::class, 'xuLyThemMoi'])->name('san-pham.xl-them-moi');
    Route::get('san-pham', [SanPhamController::class, 'danhSach'])->name('san-pham.danh-sach');
    Route::get('san-pham/cap-nhat/{id}', [SanPhamController::class, 'capNhat'])->name('san-pham.cap-nhat');
    Route::post('san-pham/cap-nhat/{id}', [SanPhamController::class, 'xuLyCapNhat'])->name('san-pham.xl-cap-nhat');
    Route::get('san-pham/xoa/{id}', [SanPhamController::class, 'xoa'])->name('san-pham.xoa');

    Route::prefix('admin')->group(function(){
        Route::name('admin.')->group(function(){
            Route::get('add-new', [AdminController::class, 'addNew'])->name('add-new');
            Route::post('add-new', [AdminController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('list', [AdminController::class, 'getList'])->name('list');
            Route::get('update/{id}', [AdminController::class, 'upDate'])->name('update');
            Route::post('update/{id}', [AdminController::class, 'hdUpdate'])->name('hd-update');
            Route::get('delete/{id}', [AdminController::class, 'xoa'])->name('delete');
        });
        
    });
    

    Route::get('loai-san-pham', [LoaiSanPhamController::class, 'danhSach'])->name('loai-san-pham.danh-sach');
    Route::get('loai-san-pham/them-moi',[LoaiSanPhamController::class, 'themMoi'])->name('loai-san-pham.them-moi');
    Route::post('loai-san-pham/them-moi',[LoaiSanPhamController::class, 'xuLyThemMoi'])->name('loai-san-pham.xl-them-moi');
    Route::get('loai-san-pham/cap-nhat/{id}', [LoaiSanPhamController::class, 'capNhat'])->name('loai-san-pham.cap-nhat');
    Route::post('loai-san-pham/cap-nhat/{id}', [LoaiSanPhamController::class, 'xuLyCapNhat'])->name('loai-san-pham.xl-cap-nhat');
    Route::get('loai-san-pham/xoa/{id}', [LoaiSanPhamController::class, 'xoa'])->name('loai-san-pham.xoa');

    Route::get('main',[MainController::class, 'main'])->name('main');
    Route::get('logout',[LoginController::class, 'logOut'])->name('logout');
// });
// Route::middleware('guest')->group(function(){
    Route::get('login',[LoginController::class, 'Login'])->name('login');
    Route::post('login',[LoginController::class, 'hdLogin'])->name('hd-login');
    
    Route::get('password-reset',[LoginController::class, 'passWordReset'])->name('password-reset');
// });