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
        $level = $this::levelAccess($request);

        if (!Auth::check() || $level != 5) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }

        $request->validate([
            "discount" => "required",
        ]);

        $client = $request->client ?? $this::emailAccess($request);
        $discountProduct = Sale::where("client", $client)->get();

        if ($discountProduct->isEmpty()) {
            $this->response["error"] = "cliente não tem produto para adicionar desconto";
            return Response()->json($this->response, 400);
        }

        Sale::where("client", $client)->update([
            "discount" => $request->discount
        ]);

        $this->response["result"] =  Sale::leftJoin("images", "images.product_id", "=", "sales.product_id")->select("sales.*", "images.image")->get();
        return Response()->json($this->response, 200);
    }
}
