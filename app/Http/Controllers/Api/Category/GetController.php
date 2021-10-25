<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class GetController extends Controller
{
    public function index(){
        $this->response["result"] = (new Category())->get();
        return $this->response;
    }
}
