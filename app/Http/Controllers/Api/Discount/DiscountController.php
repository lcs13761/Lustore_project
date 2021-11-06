<?php

namespace App\Http\Controllers\Api\Discount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
     
        // Sale::where("client", $client)->update([
        //     "discount" => $request->discount
        // ]);

        // $this->response["result"] =  Sale::leftJoin("images", "images.product_id", "=", "sales.product_id")->select("sales.*", "images.image")->get();
        // return Response()->json($this->response, 200);
    }
}
