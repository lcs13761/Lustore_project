<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Sales;
use App\Http\Controllers\DecodeJwt;
use Illuminate\Support\Facades\Auth;

class DiscountProductSale extends Controller
{
    public function discountAllProducts(Request $request)
    {

        $user = (new DecodeJwt())->decode($request->header("Authorization"));

        if (!Auth::check() || $user->level != 5) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }
        
        $Validator = Validator::make($request->all(), [
            "discount" => "required",
        ]);

        if ($Validator->fails()) {
            $this->response["error"] = "campos invalidos";
            return Response()->json($this->response, 400);
        }

        $client = !empty($request->input('client')) ? $request->input('client') : $user->email;
        $discountAllProducts = Sales::where("client", $client)->get();

        if ($discountAllProducts->isEmpty()) {
            $this->response["error"] = "cliente não tem produto para adicionar desconto";
            return Response()->json($this->response, 400);
        }
        $discount = $request->input('discount');
        Sales::where("client", $client)->update([
            "discount" => $discount,
        ]);

        $this->response["result"] =  Sales::leftJoin("images", "sales.id_product", "=", "images.id_product")->select("sales.*", "images.image")->get();
        return Response()->json($this->response, 200);
    }

}
