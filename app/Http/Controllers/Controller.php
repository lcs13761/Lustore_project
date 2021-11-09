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

    protected function userValidate(int $user)
    {
        abort_if(Auth::user()->id != $user, 403, "Não autorizado.");
    }

    private function token()
    {
        $token = JWTAuth::getToken();
        $response = JWTAuth::getPayload($token)->toArray();
        return $response["user"];
    }

    protected function levelAccess()
    {
        abort_if($this->token()->level != 5, 403, "Não autorizado.");
    }

    protected function name(){
        $name = $this->user()->name;
        return $name;
    }

    protected function emailAccess($request)
    {
        $email = $this->token()->email;
        return $email;
    }

 
}
