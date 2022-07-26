<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public array $response = ["error" => '', "result" => []];
    // protected function token()
    // {
    //     $token = JWTAuth::getToken();
    //     $response = JWTAuth::getPayload($token)->toArray();
    //     return $response["user"];
    // }

}
