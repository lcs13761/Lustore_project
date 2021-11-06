<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\DecodeJwt;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public array $response = ["error" => '', "result" => []];



    private function user()
    {
        $token = JWTAuth::getToken();
        $response = JWTAuth::getPayload($token)->toArray();
        return $response["user"];
    }

    protected function levelAccess($level)
    {
        if (!Auth::check() || $this->user["level"] != 5) {
            return false;
        }
        return true;
    }

    protected function name(){
        $name = $this->user()->name;
        return $name;
    }

    protected function emailAccess($request)
    {
        $email = $this->user()->email;
        return $email;
    }
}
