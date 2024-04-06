<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Services\Category\CategoryService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(private readonly CategoryService $categoryService)
    {
        // $this->middleware("auth:api", ["except" => ["index", "show"]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return (new CategoryCollection($this->categoryService->paginate($request)))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryStoreRequest $request
     * @return JsonResponse
     */
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        try {
            $result = $this->categoryService->uploadFile($request);
            $this->categoryService->create($result);
            return response()->json(['result' => 'sucess']);
        } catch (Exception $e) {
            return response()->json(['result' => 'error'], $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return (new CategoryResource($this->categoryService->find($id)))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CategoryUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $result = $this->categoryService->uploadFile($request, $id);
            $this->categoryService->update($id, $result);
            return response()->json(['result' => 'Success']);
        } catch (Exception $e) {
            return response()->json(['result' => 'error'], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->categoryService->destroy($id);

        return response()->json(['result' => 'Success']);
    }
}
