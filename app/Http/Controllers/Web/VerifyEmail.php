<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class VerifyEmail extends Controller
{

    public function verify(){
        return view("web.auth-verify-email");
    }

    public function verificationEmail(Request $request,$id,$hash)
    {
        $request = Request::create("/api/verification/{$id}/{$hash}",'GET');

        $response = app()->handle($request);
        return $response;
    }
}
