<?php

use App\Http\Controllers\APIAuthController;
use App\Http\Controllers\APIBrandController;
use App\Http\Controllers\APIProductController;
use App\Http\Controllers\APISlidesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
    Route::post('login', 'APIAuthController@login');
    Route::post('logout',[APIAuthController::class, 'logout']);
    Route::post('refresh', 'APIAuthController@refresh');
    Route::get('me', [APIAuthController::class,'me']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[APIAuthController::class,"loGin"]);

Route::get('/product',[APIProductController::class, "listProduct"]);
Route::get('/product/{id}',[APIProductController::class, "getProductDetail"]);

Route::get('/brand',[APIBrandController::class, "listBrand"]);
Route::get('/brand/{id}',[APIBrandController::class, "getBrandDetail"]);

Route::get('/slides',[APISlidesController::class, "listSlides"]);