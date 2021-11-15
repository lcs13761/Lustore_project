<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StorePostRequest;
use App\Http\Requests\Product\StorePutRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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
     * @return JsonResponse|Response
     */
    public function index(): Response|JsonResponse
    {
        $product = Product::with(["image", "category"]);
        return (new ProductCollection($product->paginate(10)))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostRequest $request
     * @return JsonResponse|Response
     */
    public function store(StorePostRequest $request): Response|JsonResponse
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
        return response()->json($this->response);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse|Response
     */
    public function show(Product $product): Response|JsonResponse
    {
        return (new ProductResource($product->loadMissing(["image", "category"])))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePutRequest $request
     * @param Product $product
     * @return JsonResponse|Response
     */
    public function update(StorePutRequest $request, Product $product): Response|JsonResponse
    {
        $this->levelAccess();
        abort_if(!$product->update($request->all()), 500, "Error ao editar o produto");
        if ($request->images) {

            $image = new ImageController();
            foreach ($request->images as $value) {

                if ($value["image"] == null || $image->existFile($value["image"])) {
                    $imageFind = $value["id"] ? $product->image()->find($value['id']) : false;
                    if ($imageFind && $imageFind->image != $value["image"]) {
                        $image->destroy($imageFind->image);
                    }
                    $value["image"] ? $product->image()->updateOrCreate(["id" => $value["id"]], $value) : $imageFind->delete();
                }
            }
        }
        Log::info("Product created successfully.");
        $this->response["result"] = "sucesso";
        return response()->json($this->response);
    }

    /**
     * Remove the specified resource from storage.
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $images = $product->image()->getResults();
        if ($images) {
            $imageController = new ImageController();
            foreach ($images as $value) {

                if ($imageController->existFile($value->image)) $imageController->destroy($value->image);

            }
        }
        abort_if(!$product->delete(), 500, "Error ao excluir.");
        Log::info("Product removed successfully.");
        $this->response["result"] = "sucesso";
        return response()->json($this->response);
    }
}
