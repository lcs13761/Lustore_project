<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Categories\CategoriesController;
use App\Http\Controllers\Api\Product\GetProducts;
use App\Http\Controllers\Api\Product\MonthCostController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Sales\DiscountProductSale;
use App\Http\Controllers\Api\Sales\HitoricSalesController;
use App\Http\Controllers\Api\Sales\SalesProduct;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Mail\MailController;

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

Route::get("/401" , [AuthController::class , "unauthenticated"])->name('login');
Route::post("/login" , [AuthController::class , "login"]);
Route::post("/forget" , [AuthController::class , "forgotPassword"]);
Route::post("/reset-password" , [AuthController::class , "changePassword"]);
Route::post("/logout" , [AuthController::class ,"logout"])->middleware('auth:api');
Route::post("/refresh" , [AuthController::class ,"refresh"]);

Route::get("/verification/{id}/{hash}", [MailController::class, "verifyEmail"]);
Route::post("/email/resendverification" , [MailController::class,"resendVerification"])->middleware("auth:api")->name("verification.send");

Route::get("/products" , [GetProducts::class , "getAllProducts"]);
Route::get("/product/{code}" , [GetProducts::class ,"getProduct"]);
Route::get("/products/categories/{id}" , [GetProducts::class , "getByCategory"]);
Route::post("/product/add" , [ProductController::class , "createProduct"]);
Route::put("/product/update/{code}" , [ProductController::class , "updateProduct"]);
Route::delete("/product/delete/{code}" , [ProductController::class , "delProduct"]);

Route::get("/categories" , [CategoriesController::class ,"getAllCategories"]);
Route::post("/category/add" , [CategoriesController::class , "createCategory"]);
Route::put("/category/update/{id}" , [CategoriesController::class , "updateCategory"]);
Route::delete("/category/delete/{id}" , [CategoriesController::class , "deleteCategory"]);

Route::get("/monthCost" , [MonthCostController::class ,"getCost"]);
Route::post("/monthCost/add" , [MonthCostController::class ,"saveMonthCost"]);


Route::post("/upload" , [UploadController::class , "uploadPhoto"]);


Route::get("/sale" , [SalesProduct::class , "getSaleNow"]);
Route::get("/allSalesYear" , [HitoricSalesController::class , "getHistoricYearlyNow"]);
Route::get("/allSalesFinalised" , [HitoricSalesController::class , "getSalesFinally"]);



Route::post("/sale/add" , [SalesProduct::class , "createSale"]);
Route::put("/sale/update/{id}" , [SalesProduct::class, "updateProductSales"]);
Route::delete("/sale/delete/{id}" , [SalesProduct::class , "deleteOne"]);
Route::delete("/sale/deleteAll" , [SalesProduct::class , "deleteAll"]);

Route::put("/sale/discountAll" , [DiscountProductSale::class, "discountAllProducts"]);

Route::post("/sale/finalizeSale",[HitoricSalesController::class , "createHistoricSales"]);

// Route::post("/exchangeProductLastSale", [ReplacementAndReturnController::class , "getProductForReplacementAndReturn"]);
// Route::post("/replacementProduct" , [ReplacementAndReturnController::class , "replacementProduct"]);
// Route::delete("/devolutionProduct/{id}" , [ReplacementAndReturnController::class , "devolutionProduct"]);

Route::get("/historicSalesUser", []);
Route::put("/productReturnLastSale", []);

Route::get("/user" , []);
Route::post("/user/create" , [UserController::class, 'create']);


Route::get("/admin/all" , []);
Route::put("/admin/update" , []);
Route::post("/admin/add" , []);
Route::delete("/admin/delete" , []);

