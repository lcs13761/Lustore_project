<?php

namespace App\Http\Controllers\Api\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class CreateController extends Controller
{
    public function index(Request $request)
    {

        $user = $this::emailAccess($request);
        $product = (object)$request->product;

        if (empty($product->code)) {
            $this->response["error"] = "Informe o produto.";
            return Response()->json($this->response, 400);
        }

        $product_sale =  Product::where('code', $product->code)->first();
        if ($product_sale->isEmpty()) {
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
            "client" => $request->client ?? $user,
            "product" => $product_sale->product,
            "product_id" => $product_sale->id,
            "saleValue" => $product_sale->saleValue,
            "sizes" => $product_sale->size,
            "qts" => $product->qts ?? 1,
            "category_id" => $product_sale->category_id,
        ];

        $product_sale->qts -= $product->qts;

        if (!$product_sale->save() || !Sale::create($create)) {
            $this->response["error"] = "erro ao salva os dados..";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = Sale::leftJoin("images", "sales.id_product", "=", "images.id_product")->select("sales.*", "images.image")->get();
        return response()->json($this->response, 200);
    }
}
