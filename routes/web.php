<?php

use App\Http\Controllers\Api\Auth\PasswordController;
use App\Http\Controllers\web\Mail\MailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\AuthForgotController;
use App\Http\Controllers\Web\VerifyEmail;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Break_;

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


dd('aa');


})->name("home");


