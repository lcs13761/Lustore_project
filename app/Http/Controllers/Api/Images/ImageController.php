<?php

namespace App\Http\Controllers\Api\Images;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    //
    private array $response = ["error" => '', "result" => []];

    public function __construct()
    {
        //$this->middleware("auth:api");
    }

    public function postImage(Request $request)
    {


    }
}
