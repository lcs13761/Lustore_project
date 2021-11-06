<?php

namespace App\Http\Controllers\Api\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{
    public function index(Request $request)
    {
        $validate = Validator::make($request->product,[
                "id" => "required",
                "qts" => "required"
            ]);

            if($validate->fails()){
                $this->response["error"] = "Informe todos os dados.";
                return Response()->json($this->response, 123);
            }

        $user = $this->emailAccess($request);
        $product = (object)$request->product;

        $product_sale =  Product::find($request->product["id"]);
        if (!$product_sale) {
            $this->response["error"] = "Produto não encontrado";
            return response()->json($this->response, 400);
        }
        if ($product_sale->qts == 0) {
            $this->response["error"] = "Produto indisponivel";
            return response()->json($this->response, 400);
        }
        if (($product_sale->qts - $product->qts) < 0) {
            $this->response["error"] = "{$product_sale->qts} Produto disponivel";
            return response()->json($this->response, 400);
        }
        
        $create = [
            "code" => $product_sale->code,
            "client" => $request->client ??  $user,
            "product" => $product_sale->product,
            "product_id" => $product_sale->id,
            "saleValue" => $product_sale->saleValue,
            "size" => $product_sale->size,
            "qts" => $product->qts ?? 1,
            "category_id" => $product_sale->category_id,
        ];

        $product_sale->qts -= $product->qts;

        if (!$product_sale->save() || !Sale::create($create)) {
            $this->response["error"] = "erro ao salva os dados..";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = Sale::leftJoin("images", "sales.product_id", "=", "images.product_id")->select("sales.*", "images.image")->get();
        return response()->json($this->response, 200);
    }
}
