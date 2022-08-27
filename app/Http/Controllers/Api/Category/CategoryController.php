<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    public function __construct(private readonly CategoryService $categoryService)
    {
        // $this->middleware("auth:api", ["except" => ["index", "show"]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index(): Response|JsonResponse
    {
        return (new CategoryCollection($this->categoryService->all()))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return JsonResponse|Response
     */
    public function store(CategoryRequest $request): Response|JsonResponse
    {
        $result = $this->categoryService->uploadFile($request);
        $this->categoryService->create($result);

        return response()->json(['result' => 'sucess'], 200);
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
     * @param CategoryRequest $request
     * @param int $id
     * @return JsonResponse|Response
     */
    public function update(CategoryRequest $request, int $id): Response|JsonResponse
    {
        $result = $this->categoryService->uploadFile($request, $id);
        $this->categoryService->update($id, $result);

        return response()->json(['result' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|Response
     */
    public function destroy(int $id): Response|JsonResponse
    {
        $this->categoryService->destroy($id);

        return response()->json(['result' => 'Success'], 500);
    }
}
