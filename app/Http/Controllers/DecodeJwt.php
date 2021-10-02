<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;


class DecodeJwt
{


    /**
     * @param $token
     * @return mixed
     */
    public function decode($token): mixed
    {
        
        $values = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]))));
        return $values->user;


    }


}