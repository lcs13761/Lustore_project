<?php

use App\Http\Controllers\Api\HistoricController;
use App\Http\Controllers\Api\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Auth\MailController;
use App\Http\Controllers\Api\Auth\PasswordController;
use App\Http\Controllers\Api\Report\ReportAnnualController;
use App\Http\Controllers\Api\Report\ReportCategoryAndProductController;
use App\Http\Controllers\Api\Report\ReportSalesController;
use App\Http\Controllers\Api\SaleController;

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


Route::get("/401", [AuthController::class, "unauthenticated"])->name('login');
Route::post("/login", [AuthController::class, "login"]);
Route::post("/logout", [AuthController::class, "logout"])->middleware('auth:api');
Route::post("/refresh", [AuthController::class, "refresh"]);

Route::get("/verification/{id}/{hash}", [MailController::class, "verifyEmail"]);
Route::post("/forget", [PasswordController::class, "forgotPassword"]);
Route::post("/reset-password", [PasswordController::class, "changePassword"]);
Route::post("/email/resendverification", [MailController::class, "resendVerification"])->middleware("auth:api")->name("verification.send");

Route::apiResource('user',UserController::class);
Route::apiResource('product',ProductController::class);
Route::apiResource('category',CategoryController::class);
Route::apiResource('sale',SaleController::class)->middleware("auth:api");
Route::apiResource('historic', HistoricController::class)->except(["show","update","destroy"])->middleware("auth:api");

Route::post("/upload",[ImageController::class,"store"]);


Route::middleware('auth:api')->group(function(){

  Route::prefix('report')->group(function(){
    Route::get('/sale',[ReportSalesController::class,'index']);
    Route::get('/product/category',[ReportCategoryAndProductController::class,'index']);
    Route::get('/sale/annual',[ReportAnnualController::class,'index']);
  });

});

