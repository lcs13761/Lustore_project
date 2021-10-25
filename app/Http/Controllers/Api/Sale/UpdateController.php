<?php

namespace App\Http\Controllers\Api\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\product;

class UpdateController extends Controller
{
    public function index(int|string $id, Request $request)
    {

        $request->validate([
            "product" => "required"
        ]);

        $user = $this::emailAccess($request);
        $sale = Sale::find($id);
        if($sale->isEmpty || $sale->client != $user){
            $this->response["error"] = "Venda não encontrada para o usuario.";
            return Response()->json($this->response, 400);
        }

        $product = Product::find($sale->product_id);
        if($product->isEmpty()){
            $this->response["error"] = "Produto não encontrado.";
            return Response()->json($this->response, 400);
        }

        $productSalesQts = (object)$request->product;
        $sale_qts_product = $productSalesQts->qts ?? 1;
        
        if ($sale_qts_product > $sale->qts) {
            $product->qts -= ($sale_qts_product - $sale->qts);
            if ($product->qts < 0) {
                $this->response["error"] = "Produto indisponivel";
                return Response()->json($this->response, 200);
            }
        }

        if ($sale_qts_product < $sale->qts) {
            $product->qts += ($sale->qts - $sale_qts_product);
        };
        $sale->qts = $sale_qts_product;
        $sale->discount = $request->discount;

        if (!$sale->save() || !$product->save()) {
            $this->response["error"] = "Error";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = Sale::leftJoin("images", "sales.id_product", "=", "images.id_product")->select("sales.*", "images.image")->get();
        return Response()->json($this->response, 200);
    }
}
