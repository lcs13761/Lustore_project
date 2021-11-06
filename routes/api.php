<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Cost;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Api\Discount;
use App\Http\Controllers\Api\Historic;
use App\Http\Controllers\Api\User;
use App\Http\Controllers\Api\Mail\MailController;
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



// Route::get("/401", [AuthController::class, "unauthenticated"])->name('login');
// Route::post("/login", [AuthController::class, "login"]);
// Route::post("/forget", [AuthController::class, "forgotPassword"]);
// Route::post("/reset-password", [AuthController::class, "changePassword"]);
// Route::post("/logout", [AuthController::class, "logout"])->middleware('auth:api');
// Route::post("/refresh", [AuthController::class, "refresh"])->middleware('auth:api');;

// //user
// Route::get("/user", [User\GetController::class, "index"])->middleware("auth:api");
// Route::post("/user/create", [User\CreateController::class, 'index']);
// Route::put("/user/update", [User\UpdateController::class, 'index'])->middleware("auth:api");

// //mail
// Route::get("/verification/{id}/{hash}", [MailController::class, "verifyEmail"]);
// Route::post("/email/resendverification", [MailController::class, "resendVerification"])->middleware("auth:api")->name("verification.send");



Route::middleware("auth:api")->group(function () {

  Route::apiResource('product',ProductController::class);
  Route::apiResource('sale',SaleController::class);
  Route::apiResource('categories',CategoryController::class);

// //upload
// Route::post("/upload", [UploadController::class, "index"]);


// //report
// Route::get("/reports/sales", [Report\ReportSalesController::class, "index"]);
// Route::get("/reports/cost", [Report\ReportCostController::class, "index"]);
// Route::get("/reports/best/category/product", [Report\ReportCategoryAndProductController::class, "index"]);
// Route::get("/reports/annual-profit", [Report\ReportAnnualController::class, "index"]);

// //historic
// Route::post("/sale/finalizeSale", [Historic\CreateController::class, "index"]);

// //cost month
// Route::post("/monthCost/add", [Cost\MonthCostController::class, "saveMonthCost"]);

// //discount
// Route::put("/sale/discountAll", [Discount\DiscountController::class, "index"]);

});
