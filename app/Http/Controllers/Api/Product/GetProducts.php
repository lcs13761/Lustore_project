<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetProducts extends Controller
{

    private array $response = ["error" => '', "result" => []];

    public function getAllProducts(){

        $Products = Categories::join('products', 'products.id_category', "=", "categories.id")->select("categories.*", "products.*")->get();
        $this->response["result"] = $Products;
        return $this->response;

    }

    public function getByCategory(int|string $id){

        if (empty($id)) {
            $this->response["result"] = "error";
            return $this->response;
        }
        $Products =  Products::leftJoin('images', 'images.id_product', "=", "products.id")->where('products.id_category', $id)->select("products.*", "images.image")->get();
        $this->response["result"] = $Products;
        return $this->response;
    }

    public function getProduct(int|string $code): JsonResponse|array{

        try {
            $Product = Products::where('code', $code)->firstOrFail();
            $this->response["result"] = $Product;
            return $this->response;
        } catch (ModelNotFoundException $e) {
            $this->response["error"] = "Produto não encontrado";
            return response()->json($this->response, 404);
        } catch (\Exception $e) {
            $this->response["error"] = "error desconhecido";
            return response()->json($this->response, 500);
        }
    }

}
