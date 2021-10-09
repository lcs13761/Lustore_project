<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\Product\MonthCostController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Sales\ReplacementAndReturnController;
use App\Http\Controllers\Sales\HitoricSalesController;
use App\Http\Controllers\Sales\SalesProduct;

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
Route::post("/loginAdmin" , [AuthController::class , "loginAdmin"]);
Route::post("/logout" , [AuthController::class ,"logout"]);
Route::post("/refresh" , [AuthController::class ,"refresh"]);


Route::get("/products" , [ProductController::class , "getAllProducts"]);
Route::get("/product/{code}" , [ProductController::class ,"getProduct"]);
Route::get("/products/categories/{id}" , [ProductController::class , "getByCategory"]);
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
Route::post("/deleteP" , [UploadController::class , "delete"]);

Route::get("/sales" , [SalesProduct::class , "getSaleNow"]);
Route::get("/allSalesYear" , [SalesProduct::class , "getYearlyNow"]);
Route::get("/allSalesFinalised" , [SalesProduct::class , "getSalesFinally"]);
Route::post("/sale" , [SalesProduct::class , "sales"]);
Route::put("/sale/update/{id}" , [SalesProduct::class, "updateProductSales"]);
Route::put("/sale/discountAll" , [SalesProduct::class, "discountAllProducts"]);
Route::delete("/sale/delete/{id}" , [SalesProduct::class , "deleteOne"]);
Route::delete("/sale/deleteAll" , [SalesProduct::class , "deleteAll"]);


Route::post("/sale/finalizeSale",[HitoricSalesController::class , "createHistoricSales"]);

Route::post("/exchangeProductLastSale", [ReplacementAndReturnController::class , "getProductForReplacementAndReturn"]);


Route::get("/historicSalesUser", []);
Route::put("/productReturnLastSale", []);

Route::get("/client" , []);
Route::post("/client/add" , []);


Route::get("/admin/all" , []);
Route::put("/admin/update" , []);
Route::post("/admin/add" , []);
Route::delete("/admin/delete" , []);

