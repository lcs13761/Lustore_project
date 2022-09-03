<?php

use App\Http\Controllers\Api\HistoricController;
use App\Http\Controllers\Api\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\Auth\MailController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Api\Report\ReportAnnualController;
use App\Http\Controllers\Api\Report\ReportCategoryAndProductController;
use App\Http\Controllers\Api\Report\ReportSalesController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\User\UserController;

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


Route::get("/401", [AuthenticatedController::class, "unauthenticated"])->name('login');
Route::post("/login", [AuthenticatedController::class, "login"]);
Route::post("/logout", [AuthenticatedController::class, "logout"])->middleware('auth:api');
Route::post("/refresh", [AuthenticatedController::class, "refresh"]);

Route::get("/verification/{id}/{hash}", [MailController::class, "verifyEmail"]);
// Route::post("/forget", [PasswordController::class, "forgotPassword"]);
// Route::post("/reset-password", [PasswordController::class, "changePassword"]);
// Route::post("/email/resendverification", [MailController::class, "resendVerification"])->middleware("auth:api")->name("verification.send");

//user
Route::apiResource('users', UserController::class);
//product
Route::apiResource('products', ProductController::class);
//category
Route::apiResource('categories', CategoryController::class);
// Route::apiResource('sales', SaleController::class)->middleware("auth:api");
// Route::apiResource('historics', HistoricController::class)->except(["show","update","destroy"])->middleware("auth:api");

// Route::post("/upload", [ImageController::class,"store"]);


// Route::middleware('auth:api')->group(function(){

//   Route::prefix('report')->group(function () {
//       Route::get('/sale', [ReportSalesController::class,'index']);
//       Route::get('/product/category', [ReportCategoryAndProductController::class,'index']);
//       Route::get('/sale/annual', [ReportAnnualController::class,'index']);
//   });

// });
