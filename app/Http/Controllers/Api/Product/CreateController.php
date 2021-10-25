<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CreateController extends Controller
{
    public function index(Request $request)
    {

        if (!$this->levelAccess($request)) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }

        $request->validate([
            "code" => "required|int",
            "product" => "required",
            "saleValue" => "required",
            "costValue" => "required",
            "size" => "required|int",
            "qts" => "required|int",
            'category' => [
                "id" => "required"
            ]
        ]);

        $checkProduct = Product::where('code', $request->input('code'))->exists();
        if ($checkProduct) {
            $this->response["error"] = "Produto ja registrado";
            return Response()->json($this->response, 400);
        }

        $create = [
            "code" => $request->code,
            "product" =>  $request->product,
            "saleValue" => $request->saleValue,
            "costValue" => $request->costValue,
            "size" => $request->size,
            "qts" => $request->qts,
            "allQts" => $request->qts,
            "category_id" => $request->category["id"],
            "description" => $request->description
        ];

        $product = Product::create($create);

        if (!$product) {
            $this->response["error"] = "erro ao salva os dados";
            return Response()->json($this->response, 400);
        }

        if (!empty($request->image)) {
            $product->image()->create(["image" => $request->image]);
        }

        $this->response["result"] = "sucesso ao adicionar produto";
        return $this->response;
    }
}
