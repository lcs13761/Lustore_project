<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\DecodeJwt;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public array $response = ["error" => '', "result" => []];


    static function levelAccess($level){
        $levelPermission = (new DecodeJwt())->decode($level->header("Authorization"));
        if (!Auth::check() || $levelPermission->level != 5) {
            return false;
        } 
        return true;
    }

    static function emailAccess($request){
     return (new DecodeJwt())->decode($request->header("Authorization"))->email;
    }
}
