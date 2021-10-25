<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GetController extends Controller
{
    public function index()
    {

        if (!Auth::check()) {
            return Response()->json([], 400);
        }

        $this->response["result"] = (new User())->get();
        return Response()->json($this->response, 400);
    }
}
