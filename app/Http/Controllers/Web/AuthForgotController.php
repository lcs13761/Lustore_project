<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthForgotController extends Controller
{
    public function retrievePassword(int|string $token){

   
        return view('web/retrieve_password', ["token" => $token, "email" => $_GET["email"]]);
    }
}
