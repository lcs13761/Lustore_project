<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Product;

class GetController extends Controller
{
    public function getOne(int|string $code, Request $request)
    {
        $Product = Product::where('code', $code)->orWhere("product", $request->product)->get();
        $this->response["result"] = $Product;
        return $this->response;
    }

    public function getAll()
    {
        $Products = (new Product())->get();

        $this->response["result"]  = $this->responseProduct($Products);
        return $this->response;
    }

    private function responseProduct($product)
    {
        if ($product->isEmpty()) {
            return $product;
        }

        $arrayProduct = array();
        $i = 0;
        foreach ($product as $value => $key){
            $arrayProduct[$i] = $key;
            $category = Category::find($key["category_id"]);
            $arrayProduct[$i]["category"] = $category;
            $image = Image::where("product_id", $key["id"])->get();
            $arrayProduct[$i]["image"] = $image;
            $i++;
        }
        return $arrayProduct;
    }
    
}
