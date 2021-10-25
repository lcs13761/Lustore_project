<?php

namespace App\Http\Controllers\Api\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Sale;

class DeleteController extends Controller
{
    public function one(int|string $id, Request $request)
    {
        $user = $this::emailAccess($request);
        $remove = Sale::find($id);
        if ($remove->isEmpty() || $remove->client != $user) {
            $this->response["error"] = "Error";
            return Response()->json($this->response, 400);
        }

        $product = Product::find($remove->product_id);
        if ($product->isEmpty()) {
            $remove->delete();
            $this->response["response"] = "Excluido com sucesso.";
            return Response()->json($this->response, 200);
        }

        $product->qts += $remove->qts;
        if (!$remove->delete() || !$product->save()) {
            $this->response["error"] = "Error";
            return Response()->json($this->response, 400);
        }
        $this->response["response"] = "Excluido com sucesso";
        return Response()->json($this->response, 200);
    }

    public function all(Request $request)
    {
        $user = $this::emailAccess($request);
        $client = $request->client ?? $user;

        $removeAll = Sale::where("client", $client)->get();
        if($removeAll->isEmpty()){
            $this->response["result"] = "";
            return Response()->json($this->response, 200);
        }
        
        foreach ($removeAll as $remove) {
            $product = Product::find($remove["product_id"]);
            if($product->isNotEmpty()) {
                $product->qts +=  $remove["qts"];
                $product->save();
            }
        }
        Sale::where("client", $client)->delete();
        $this->response["result"] = "Excluidos com sucesso";
        return Response()->json($this->response, 200);
    }
}
