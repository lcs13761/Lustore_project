<?php

namespace App\Http\Controllers\Images;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Images;

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
