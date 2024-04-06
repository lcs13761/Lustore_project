<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\ProductService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function index(Request $request): Response|JsonResponse
    {
        return (new ProductCollection($this->productService->paginate($request)))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        try {
            $this->productService->create($request);
            return response()->json(['result' => 'success']);
        } catch (Exception $e) {
            return response()->json(['result' => 'error'], $e->getCode());
        }
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
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $this->productService->update($request, $id);
            return response()->json(['result' => 'success']);
        } catch (Exception $e) {
            return response()->json(['result' => 'error'], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->productService->delete($id);
            return response()->json(['result' => 'success']);
        } catch (Exception $e) {
            return response()->json(['result' => 'error'], $e->getCode());
        }
    }
}
