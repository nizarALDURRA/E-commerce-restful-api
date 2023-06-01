<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionsShopController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::group(["prefix" => "", "middleware" => ["auth:sanctum"]], function () {

    Route::get('/logout',[AuthController::class,'logout']);
    Route::apiResources([
        'category' => CategoryController::class,
        'product' => ProductController::class,
    ]);
    Route::post('/AddCart',[SessionsShopController::class,'addItems']);
    Route::get('/GetItems',[SessionsShopController::class,'GetItems']);
    Route::get('/GetSession',[SessionsShopController::class,'GetSession']);
    Route::post('/RemoveItems',[SessionsShopController::class,'ReduceItems']);
    Route::get('/Order',[OrderController::class,'Order']);

});

///api to response for incorrect request
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});
