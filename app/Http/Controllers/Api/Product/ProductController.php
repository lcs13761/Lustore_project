<?php

namespace App\Http\Controllers\Api\Product;


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
    public function index(): Response|JsonResponse
    {
        return (new ProductCollection($this->productService->all()))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return JsonResponse|Response
     */
    public function store(ProductStoreRequest $request)
    {
        $product = $this->productService->create($request);
        $this->productService->handlerImagesUpload($product, $request);
        return response()->json($this->response);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse|Response
     */
    public function show(int $id): Response|JsonResponse
    {
        return (new ProductResource($this->productService->findWith($id)))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param int  $id
     * @return JsonResponse|Response
     */
    public function update(ProductUpdateRequest $request, int $id)
    {
        $product = $this->productService->update($request, $id);
        // if ($request->image && is_array($request->image)) {

        //     $image = new ImageController();
        //     foreach ($request->image as $value) {

        //         if ($value["image"] == null || $image->existFile($value["image"])) {
        //             $imageFind = $value["id"] ? $product->image()->find($value['id']) : false;
        //             if ($imageFind && $imageFind->image != $value["image"]) {
        //                 $image->destroy($imageFind->image);
        //             }
        //             $value["image"] ? $product->image()->updateOrCreate(["id" => $value["id"]], $value) : $imageFind->delete();
        //         }
        //     }
        // }

        // $this->response["result"] = "sucesso";
        // return response()->json($this->response);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $this->productService->delete($id);
        // $this->response["result"] = "sucesso";
        // return response()->json($this->response);
    }
}
