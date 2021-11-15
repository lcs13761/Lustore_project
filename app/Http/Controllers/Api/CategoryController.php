<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
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
        $category = Category::paginate();
        return (new CategoryCollection($category))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return JsonResponse|Response
     */
    public function store(CategoryRequest $request): Response|JsonResponse
    {
        $this->levelAccess();
        $request->validated();
        abort_if(!Category::create($request->all()),500,"Error");
        Log::info("category created successfully.");
        $this->response["result"] = "sucesso";
        return response()->json($this->response,200);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return (new CategoryResource($category->loadMissing(["products"])))->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return JsonResponse|Response
     */
    public function update(CategoryRequest $request, Category $category): Response|JsonResponse
    {
        $this->levelAccess();
        $request->validated();
        abort_if(!$category->update($request->all()),500,"Error");
        Log::info("category updated successfully.");
        $this->response["result"] = "sucesso";
        return response()->json($this->response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return JsonResponse|Response
     */
    public function destroy(Category $category): Response|JsonResponse
    {
        abort_if(!$category->delete(),500,"Error");
        Log::info("category deleted successfully.");
        $this->response["result"] = "sucesso";
        return response()->json($this->response,200);
    }
}
