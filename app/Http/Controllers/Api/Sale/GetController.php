<?php

namespace App\Http\Controllers\Api\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;

class GetController extends Controller
{
    public function index(Request $request)
    {

        $user = $this->emailAccess($request);
        $this->response["result"] = Sale::where("client" , $user)->get();
        return Response()->json($this->response, 200);
    }
}
