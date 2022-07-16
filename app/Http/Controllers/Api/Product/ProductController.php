<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    public function __construct(private readonly ProductService $productService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): Response|JsonResponse
    {
        $product = Product::with(["image", "category"]);
        if ($request->product) {
            $product =  $product->where('product', 'LIKE', "%" . $request->product . "%")->get();
            return (new ProductCollection($product))->response();
        }
        if ($request->all) {
            return (new ProductCollection($product->get()))->response();
        }

        return (new ProductCollection($product->paginate(10)))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return JsonResponse|Response
     */
    public function store(ProductStoreRequest $request)
    {
        $this->levelAccess();

        $product = $this->productService->create($request);

        abort_if(!$product, 500, "Error ao registra o produto");
        if ($request->image && is_array($request->image)) {

            foreach ($request->image as $image) {
                if (isset($image['image'])) {
                    $product->image()->create($image);
                }
            }
        }

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
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return JsonResponse|Response
     */
    public function update(ProductUpdateRequest $request, Product $product): Response|JsonResponse
    {
        $this->levelAccess();
        $update = [
            "code" => $request->code,
            "product" => $request->product,
            "category_id" => $request->category["id"],
            "saleValue" => $request->saleValue,
            "costValue" => $request->costValue,
            "size" => $request->size,
            "qts" => $request->qts,
            "description" => $request->description
        ];

        abort_if(!$product->update($request->all()), 500, "Error ao editar o produto");

        if ($request->image && is_array($request->image)) {

            $image = new ImageController();
            foreach ($request->image as $value) {

                if ($value["image"] == null || $image->existFile($value["image"])) {
                    $imageFind = $value["id"] ? $product->image()->find($value['id']) : false;
                    if ($imageFind && $imageFind->image != $value["image"]) {
                        $image->destroy($imageFind->image);
                    }
                    $value["image"] ? $product->image()->updateOrCreate(["id" => $value["id"]], $value) : $imageFind->delete();
                }
            }
        }

        Log::info("Product update successfully.");
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
