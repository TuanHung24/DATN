<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\LoaiSanPhamController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\CapacityColorController;
use App\Http\Controllers\DiscountController;

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

Route::middleware('auth')->group(function(){
   

    Route::prefix('admin')->group(function(){
        Route::name('admin.')->group(function(){
            Route::get('add-new', [AdminController::class, 'addNew'])->name('add-new');
            Route::post('add-new', [AdminController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('list', [AdminController::class, 'getList'])->name('list');
            Route::get('update/{id}', [AdminController::class, 'upDate'])->name('update');
            Route::post('update/{id}', [AdminController::class, 'hdUpdate'])->name('hd-update');
            Route::get('delete/{id}', [AdminController::class, 'delete'])->name('delete');
        });
        
    });
    
    Route::prefix('customer')->group(function(){
        Route::name('customer.')->group(function(){
            Route::get('add-new', [CustomerController::class, 'addNew'])->name('add-new');
            Route::post('add-new', [CustomerController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('list', [CustomerController::class, 'getList'])->name('list');
            Route::get('update/{id}', [CustomerController::class, 'upDate'])->name('update');
            Route::post('update/{id}', [CustomerController::class, 'hdUpdate'])->name('hd-update');
            Route::get('delete/{id}', [CustomerController::class, 'delete'])->name('delete');
        });
        
    });

    
    Route::prefix('news')->group(function(){
        Route::name('news.')->group(function(){
            Route::get('list', [NewsController::class, 'getList'])->name('list');
            Route::get('add-new',[NewsController::class, 'addNew'])->name('add-new');
            Route::post('add-new',[NewsController::class, 'hdAddNew'])->name('hd-add-new');
        });
    });
    Route::prefix('provider')->group(function(){
        Route::name('provider.')->group(function(){
            Route::get('list', [ProviderController::class, 'getList'])->name('list');
            Route::get('add-new',[ProviderController::class, 'addNew'])->name('add-new');
            Route::post('add-new',[ProviderController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('update/{id}', [ProviderController::class, 'upDate'])->name('update');
            Route::post('update/{id}', [ProviderController::class, 'hdUpdate'])->name('hd-update');
            Route::get('delete/{id}', [ProviderController::class, 'delete'])->name('delete');
        });
    });
    Route::prefix('brand')->group(function(){
        Route::name('brand.')->group(function(){
            Route::get('list', [BrandController::class, 'getList'])->name('list');
            Route::get('add-new',[BrandController::class, 'addNew'])->name('add-new');
            Route::post('add-new',[BrandController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('update/{id}', [BrandController::class, 'upDate'])->name('update');
            Route::post('update/{id}', [BrandController::class, 'hdUpdate'])->name('hd-update');
            Route::get('delete/{id}', [BrandController::class, 'delete'])->name('delete');
        });
    });
    Route::prefix('capacity_color')->group(function(){
        Route::name('capacity_color.')->group(function(){
            Route::get('list', [CapacityColorController::class, 'getList'])->name('list');
            Route::get('add-new-capacity',[CapacityColorController::class, 'addNewCapacity'])->name('add-new-capacity');
            Route::post('add-new-capacity',[CapacityColorController::class, 'hdAddNewCapacity'])->name('hd-add-new-capacity');
            Route::get('add-new-color',[CapacityColorController::class, 'addNewColor'])->name('add-new-color');
            Route::post('add-new-color',[CapacityColorController::class, 'hdAddNewColor'])->name('hd-add-new-color');     
            // Route::get('update/{id}', [CapacityColorController::class, 'upDate'])->name('update');
            // Route::post('update/{id}', [CapacityColorController::class, 'hdUpdate'])->name('hd-update');
            // Route::get('delete/{id}', [CapacityColorController::class, 'delete'])->name('delete');
        });
    });


    Route::prefix('product')->group(function(){
        Route::name('product.')->group(function(){
            Route::get('list', [ProductController::class, 'getList'])->name('list');
            Route::get('detail/{id}', [ProductController::class, 'getProductDetail'])->name('detail');
            Route::get('add-new',[ProductController::class, 'addNew'])->name('add-new');
            Route::post('add-new',[ProductController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('update/{id}', [ProductController::class, 'upDate'])->name('update');
            Route::post('update/{id}', [ProductController::class, 'hdUpdate'])->name('hd-update');
            Route::get('delete/{id}', [ProductController::class, 'delete'])->name('delete');
        });
    });

    Route::prefix('discount')->group(function(){
        Route::name('discount.')->group(function(){
            Route::get('list', [DiscountController::class, 'getList'])->name('list');
            Route::get('detail/{id}', [DiscountController::class, 'getProductDetail'])->name('detail');
            Route::get('add-new',[DiscountController::class, 'addNew'])->name('add-new');
            Route::post('add-new',[DiscountController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('update/{id}', [DiscountController::class, 'upDate'])->name('update');
            Route::post('update/{id}', [DiscountController::class, 'hdUpdate'])->name('hd-update');
            Route::get('delete/{id}', [DiscountController::class, 'delete'])->name('delete');
        });
    });

    Route::prefix('invoice')->group(function(){
        Route::name('invoice.')->group(function(){
            Route::get('list', [InvoiceController::class, 'getList'])->name('list');
            Route::get('add-new',[InvoiceController::class, 'addNew'])->name('add-new');
            Route::get('detail/{id}', [InvoiceController::class, 'invoiceDetail'])->name('detail');
            Route::get('get-product',[InvoiceController::class, 'getProduct'])->name('get-product-ajax');
            Route::post('add-new',[InvoiceController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('update-status-cancel/{id}', [InvoiceController::class, 'updateStatusCancel'])->name('update-status-cancel');
            Route::get('update-status-approved/{id}', [InvoiceController::class, 'updateStatusApproved'])->name('update-status-approved');
            Route::get('update-status-delivering/{id}', [InvoiceController::class, 'updateStatusDelivering'])->name('update-status-delivering');
            Route::get('update-status-complete/{id}', [InvoiceController::class, 'updateStatusComplete'])->name('update-status-complete');
        });
    });
    Route::get('/get-product-ajax',[InvoiceController::class, 'getProduct'])->name('get-product-ajax');
    Route::prefix('warehouse')->group(function(){
        Route::name('warehouse.')->group(function(){
            Route::get('list', [WarehouseController::class, 'getList'])->name('list');
            Route::get('add-new',[WarehouseController::class, 'addNew'])->name('add-new');
            Route::get('detail/{id}', [WarehouseController::class, 'warehouseDetail'])->name('detail');
            Route::get('get-product',[WarehouseController::class, 'getProduct'])->name('get-product');
            Route::post('add-new',[WarehouseController::class, 'hdAddNew'])->name('hd-add-new');
        });
    });

    Route::get('/',[MainController::class, 'main'])->name('main');
    Route::get('logout',[LoginController::class, 'logOut'])->name('logout');
});
Route::middleware('guest')->group(function(){
    Route::get('login',[LoginController::class, 'Login'])->name('login');
    Route::post('login',[LoginController::class, 'hdLogin'])->name('hd-login');
    
    Route::get('password-reset',[LoginController::class, 'passWordReset'])->name('password-reset');
});