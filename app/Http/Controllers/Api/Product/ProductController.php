<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        return $this->productService->create($request);
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
        return $this->productService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $this->productService->delete($id);

        return response()->json($this->response);
    }
}
