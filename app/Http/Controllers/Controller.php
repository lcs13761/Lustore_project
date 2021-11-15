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

    protected function token()
    {
        $token = JWTAuth::getToken();
        $response = JWTAuth::getPayload($token)->toArray();
        return $response["user"];
    }

    protected function levelAccess()
    {
        abort_if($this->token()->level != 5, 403, "Não autorizado.");
    }

    protected function name()
    {
        return $this->user()->name;
    }

    protected function emailAccess()
    {
        return $this->token()->email;
    }
}
