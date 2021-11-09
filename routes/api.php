<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Image\ImageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\MailController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Api\Report;
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
Route::post("/refresh", [AuthController::class, "refresh"])->middleware('auth:api');

Route::get("/verification/{id}/{hash}", [MailController::class, "verifyEmail"]);
Route::post("/forget", [PasswordController::class, "forgotPassword"]);
Route::post("/reset-password", [PasswordController::class, "changePassword"]);
Route::post("/email/resendverification", [MailController::class, "resendVerification"])->middleware("auth:api")->name("verification.send");

Route::apiResource('user',UserController::class);
Route::apiResource('product',ProductController::class);

Route::post("/upload",[ImageController::class,"store"]);
Route::middleware("auth:api")->group(function () {


  Route::delete('/sale/all', [SaleController::class, 'destroyAll'])->name('sale.destroy.all');
  Route::apiResource('sale',SaleController::class);
  Route::apiResource('category',CategoryController::class);
  

});
