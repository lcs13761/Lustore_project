<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Image\ImageController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StorePostRequest;
use App\Http\Requests\Product\StorePutRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth:api", ["except" => ["index", "show"]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::with(["image", "category"]);
        return (new ProductCollection($product->paginate(10)))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $this->levelAccess();

        $product = Product::create($request->all());
        abort_if(!$product, 500, "Error ao registra o produto");
        if ($request->images) {
            foreach ($request->images as $image) {
                $product->image()->create($image);
            }
        }
        Log::info("Product created successfully.");
        $this->response["result"] = "sucesso";
        return response()->json($this->response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StorePutRequest $request, Product $product)
    {
        $this->levelAccess();


        abort_if(!$product->update($request->all()), 500, "Error ao editar o produto");
        if ($request->images) {

            $image = new ImageController();
            foreach ($request->images as $value) {

                if ($value["image"] == null || $image->existFIle($value["image"])) {
                    $imageFind = $value["id"]  ? $product->image()->find($value['id']) : false;
                    if ($imageFind && $imageFind->image != $value["image"]) {
                        $image->destroy($imageFind->image);
                    }
                    $value["image"] ? $product->image()->updateOrCreate(["id" => $value["id"]], $value) : $imageFind->delete();
                }
            }
        }

        Log::info("Product created successfully.");
        $this->response["result"] = "sucesso";
        return response()->json($this->response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $images = $product->image()->getResults();
        if($images) {
            foreach($images as $value) {
                $image = new ImageController();
                $image->existFIle($value->image) ? $image->destroy($value->image) : null;
            }
        }
        abort_if(!$product->delete(), 500, "Error ao excluir.");
        Log::info("Product removed successfully.");
        $this->response["result"] = "sucesso";
        return response()->json($this->response, 200);
    }
}
