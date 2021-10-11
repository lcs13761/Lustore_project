<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\AuthForgotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name("home");


Route::get('/retrieve_password/{token}', [AuthForgotController::class,"retrievePassword"])->name('password.reset');
Route::post('/reset-password', [AuthController::class,"changePassword"]);

Route::get('/reset-password', [AuthController::class,"changePassword"]);