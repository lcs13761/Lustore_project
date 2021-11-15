<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AuthForgotController extends Controller
{
    public function retrievePassword(int|string $token): Factory|View|Application
    {
        return view('web/retrieve_password', ["token" => $token, "email" => $_GET["email"]]);
    }
}
