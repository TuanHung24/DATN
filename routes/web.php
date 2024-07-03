<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
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
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SlideShowController;
use App\Http\Controllers\StatisticalController;

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

Route::middleware(['auth', 'check.status'])->group(function(){
    Route::prefix('admin')->middleware('role:1')->group(function(){
        Route::name('admin.')->group(function(){
            Route::get('add-new', [AdminController::class, 'addNew'])->name('add-new');
            Route::post('add-new', [AdminController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('list', [AdminController::class, 'getList'])->name('list');
            Route::get('search', [AdminController::class, 'search'])->name('search');
            Route::get('update/{id}', [AdminController::class, 'upDate'])->name('update');
            Route::put('update/{id}', [AdminController::class, 'hdUpdate'])->name('hd-update');
            Route::get('lock/{id}', [AdminController::class, 'lock'])->name('lock');
            Route::get('unlock/{id}', [AdminController::class, 'unlock'])->name('unlock');
            Route::get('delete/{id}', [AdminController::class, 'delete'])->name('delete');
            Route::get('info', [AdminController::class, 'inFo'])->name('info');
            Route::post('info', [AdminController::class, 'updateInfo'])->name('update-info');
            Route::get('reset-password', [AdminController::class, 'resetPassword'])->name('reset-password');
            Route::post('reset-password', [AdminController::class, 'hdResetPassword'])->name('hd-reset-password');
        });
        
    });
    
    Route::prefix('customer')->middleware('role:1,2')->group(function(){
        Route::name('customer.')->group(function(){
            Route::get('search', [CustomerController::class, 'search'])->name('search');
            Route::get('add-new', [CustomerController::class, 'addNew'])->name('add-new');
            Route::post('add-new', [CustomerController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('list', [CustomerController::class, 'getList'])->name('list');
            Route::get('update/{id}', [CustomerController::class, 'upDate'])->name('update');
            Route::put('update/{id}', [CustomerController::class, 'hdUpdate'])->name('hd-update');
            Route::get('delete/{id}', [CustomerController::class, 'delete'])->name('delete');
            Route::get('lock/{id}', [CustomerController::class, 'lock'])->name('lock');
            Route::get('unlock/{id}', [CustomerController::class, 'unlock'])->name('unlock');
            Route::get('get-invoice/{id}', [CustomerController::class, 'getInvoice'])->name('get-invoice');
            Route::get('get-invoice-detail/{customer_id}/{id}', [CustomerController::class, 'getInvoiceDetail'])->name('get-invoice-detail');
        });
        
    });

    Route::prefix('news')->middleware('role:1,2')->group(function(){
        Route::name('news.')->group(function(){
            Route::get('search', [NewsController::class, 'search'])->name('search');
            Route::get('list', [NewsController::class, 'getList'])->name('list');
            Route::get('add-new',[NewsController::class, 'addNew'])->name('add-new');
            Route::post('add-new',[NewsController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('update/{id}', [NewsController::class, 'upDate'])->name('update');
            Route::put('update/{id}', [NewsController::class, 'hdUpdate'])->name('hd-update');
            Route::get('delete/{id}', [NewsController::class, 'delete'])->name('delete');
        });
    });
    Route::post('logo.update/{id}',[SlideShowController::class, 'updateLogo'])->name('logo.update');
    Route::prefix('slide-show')->middleware('role:1,2')->group(function(){
        Route::name('slide-show.')->group(function(){
            Route::get('search', [SlideShowController::class, 'search'])->name('search');
            Route::get('list', [SlideShowController::class, 'getList'])->name('list');
            Route::get('add-new',[SlideShowController::class, 'addNew'])->name('add-new');
            Route::post('add-new',[SlideShowController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('update/{id}', [SlideShowController::class, 'upDate'])->name('update');
            Route::put('update/{id}', [SlideShowController::class, 'hdUpdate'])->name('hd-update');
            Route::get('delete/{id}', [SlideShowController::class, 'delete'])->name('delete');
        });
    });
    Route::prefix('comment')->middleware('role:1,2')->group(function(){
        Route::name('comment.')->group(function(){
            Route::get('search', [SlideShowController::class, 'search'])->name('search');
            Route::get('list', [CommentController::class, 'getList'])->name('list');
            Route::get('rep/{id}',[CommentController::class, 'Rep'])->name('rep');
            Route::post('rep',[CommentController::class, 'hdRep'])->name('hd-rep');
        });
    });
    Route::prefix('provider')->middleware('role:1,3')->group(function(){
        Route::name('provider.')->group(function(){
            Route::get('search', [ProviderController::class, 'search'])->name('search');
            Route::get('list', [ProviderController::class, 'getList'])->name('list');
            Route::get('add-new',[ProviderController::class, 'addNew'])->name('add-new');
            Route::post('add-new',[ProviderController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('update/{id}', [ProviderController::class, 'upDate'])->name('update');
            Route::post('update/{id}', [ProviderController::class, 'hdUpdate'])->name('hd-update');
            Route::get('delete/{id}', [ProviderController::class, 'delete'])->name('delete');
        });
    });
    
    Route::prefix('brand')->middleware('role:1,2')->group(function(){
        Route::name('brand.')->group(function(){
            Route::get('search', [BrandController::class, 'search'])->name('search');
            Route::get('list', [BrandController::class, 'getList'])->name('list');
            Route::get('add-new',[BrandController::class, 'addNew'])->name('add-new');
            Route::post('add-new',[BrandController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('update/{id}', [BrandController::class, 'upDate'])->name('update');
            Route::post('update/{id}', [BrandController::class, 'hdUpdate'])->name('hd-update');
            Route::get('restore/{id}', [BrandController::class, 'restore'])->name('restore');
            Route::get('deleted/{id}', [BrandController::class, 'deleted'])->name('deleted');
            Route::get('delete/{id}', [BrandController::class, 'delete'])->name('delete');
        });
    });
    Route::prefix('color')->middleware('role:1,2')->group(function(){
        Route::name('color.')->group(function(){
            Route::get('list', [CapacityColorController::class, 'getListColor'])->name('list');
            Route::post('add-new',[CapacityColorController::class, 'hdAddNewColor'])->name('hd-add-new');     
            Route::get('delete/{id}',[CapacityColorController::class, 'deleteColor'])->name('delete');
        });
    });

    Route::prefix('capacity')->middleware('role:1,2')->group(function(){
        Route::name('capacity.')->group(function(){
            Route::get('list', [CapacityColorController::class, 'getListCapacity'])->name('list');
            Route::post('add-new',[CapacityColorController::class, 'hdAddNewCapacity'])->name('hd-add-new');
            Route::get('delete/{id}',[CapacityColorController::class, 'deleteCapacity'])->name('delete');        
        });
    });


    Route::prefix('product')->middleware('role:1,2')->group(function(){
        Route::name('product.')->group(function(){
            Route::get('search', [ProductController::class, 'search'])->name('search');
            Route::get('list', [ProductController::class, 'getList'])->name('list');
            Route::get('detail/{id}', [ProductController::class, 'getProductDetail'])->name('detail');
            Route::get('add-new',[ProductController::class, 'addNew'])->name('add-new');
            Route::post('add-new',[ProductController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('update/{id}', [ProductController::class, 'upDate'])->name('update');
            Route::post('update/{id}', [ProductController::class, 'hdUpdate'])->name('hd-update');
            Route::get('restore/{id}', [ProductController::class, 'restore'])->name('restore');
            Route::get('deleted/{id}', [ProductController::class, 'deleted'])->name('deleted');
            Route::get('delete/{id}', [ProductController::class, 'delete'])->name('delete');
            Route::get('update-images/{id}',[ProductController::class, 'updateImg'])->name('update-images');
            Route::post('update-images/{id}',[ProductController::class, 'hdUpdateImg'])->name('hd-update-images');
            Route::delete('delete-image/{image}', [ProductController::class, 'deleteImage'])->name('delete-image');
            Route::get('edit-image/{image}', [ProductController::class, 'editImage'])->name('edit-image');
            Route::post('add-detail/{id}', [ProductController::class, 'addDetail'])->name('add-detail');
            Route::delete('delete-detail/{id}', [ProductController::class, 'deleteDetail'])->name('delete-detail');
            Route::put('update-color/{id}', [ProductController::class, 'updateImage'])->name('update-color');
        });
    });

    Route::prefix('discount')->middleware('role:1')->group(function(){
        Route::name('discount.')->group(function(){
            Route::get('search', [DiscountController::class, 'search'])->name('search');
            Route::get('list', [DiscountController::class, 'getList'])->name('list');
            Route::get('detail/{id}', [DiscountController::class, 'getDetail'])->name('detail');
            Route::get('add-new',[DiscountController::class, 'addNew'])->name('add-new');
            Route::post('add-new',[DiscountController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('get-product-ajax',[DiscountController::class, 'getProduct'])->name('get-product-ajax');
            Route::get('update/{id}', [DiscountController::class, 'upDate'])->name('update');
            Route::post('update/{id}', [DiscountController::class, 'hdUpdate'])->name('hd-update');
            Route::get('delete/{id}', [DiscountController::class, 'delete'])->name('delete');
        });
    });

    Route::prefix('invoice')->middleware('role:1,2')->group(function(){
        Route::name('invoice.')->group(function(){
            Route::get('search', [InvoiceController::class, 'search'])->name('search');
            Route::get('list', [InvoiceController::class, 'getList'])->name('list');
            Route::get('add-new',[InvoiceController::class, 'addNew'])->name('add-new');
            Route::get('detail/{id}', [InvoiceController::class, 'invoiceDetail'])->name('detail');
            Route::get('get-product',[InvoiceController::class, 'getProduct'])->name('get-product-ajax');
            Route::post('add-new',[InvoiceController::class, 'hdAddNew'])->name('hd-add-new');
            Route::get('update-status-cancel/{id}', [InvoiceController::class, 'updateStatusCancel'])->name('update-status-cancel');
            Route::get('update-status-approved/{id}', [InvoiceController::class, 'updateStatusApproved'])->name('update-status-approved');
            Route::get('update-status-delivering/{id}', [InvoiceController::class, 'updateStatusDelivering'])->name('update-status-delivering');
            Route::get('update-status-complete/{id}', [InvoiceController::class, 'updateStatusComplete'])->name('update-status-complete');
            Route::get('export/{id}',[PDFController::class, 'exportInvoice'])->name('export');
        });
    });
    
   
    Route::get('/get-product-ajax',[InvoiceController::class, 'getProduct'])->name('get-product-ajax')->middleware('role:1,2');
    Route::prefix('warehouse')->middleware('role:1,3')->group(function(){
        Route::name('warehouse.')->group(function(){
            Route::get('search', [WarehouseController::class, 'search'])->name('search');
            Route::get('list', [WarehouseController::class, 'getList'])->name('list');
            Route::get('add-new',[WarehouseController::class, 'addNew'])->name('add-new');
            Route::get('detail/{id}', [WarehouseController::class, 'warehouseDetail'])->name('detail');
            Route::get('get-product',[WarehouseController::class, 'getProduct'])->name('get-product');
            Route::post('add-new',[WarehouseController::class, 'hdAddNew'])->name('hd-add-new');
            Route::post('import', [WareHouseController::class, 'importExcel'])->name('import');
            Route::get('/getProductDetailsBySeries/{id}', [WareHouseController::class, 'getProductDetailsBySeries']);
        });
    });

    Route::get('main',[MainController::class, 'main'])->name('main');
    Route::get('logout',[LoginController::class, 'logOut'])->name('logout');
    Route::get('statistical',[StatisticalController::class, 'getListYear'])->name('statistical')->middleware('role:1');
    Route::get('statistical-day',[StatisticalController::class, 'statisticalDay'])->name('statistical-day')->middleware('role:1');
    Route::get('statistical-month',[StatisticalController::class, 'getListMonth'])->name('statistical-month')->middleware('role:1');

    Route::get('statistical-month-1',[StatisticalController::class, 'statisticalMonth'])->name('statistical-month-1')->middleware('role:1');
    Route::post('statistical-month-tr',[StatisticalController::class, 'hdstatisticalMonth'])->name('statistical-month-tr')->middleware('role:1');

    Route::get('statistical-year-1',[StatisticalController::class, 'statisticalYear1'])->name('statistical-year-1')->middleware('role:1');
    Route::get('statistical-year-tr',[StatisticalController::class, 'hdstatisticalYear'])->name('statistical-year-tr')->middleware('role:1');

    Route::get('statistical-year',[StatisticalController::class, 'statisticalYear'])->name('statistical-year')->middleware('role:1');
    Route::post('invoices/status-counts', [StatisticalController::class, 'hdstatisticalDay'])->name('statistical-counts')->middleware('role:1');

});
Route::middleware('guest')->group(function(){
    Route::get('/',[LoginController::class, 'Login'])->name('login');
    Route::post('/',[LoginController::class, 'hdLogin'])->name('hd-login');
    Route::get('password-reset',[LoginController::class, 'passWordReset'])->name('password-reset');
    Route::post('password-reset',[LoginController::class, 'hdPasswordReset'])->name('hd-password-reset');
});