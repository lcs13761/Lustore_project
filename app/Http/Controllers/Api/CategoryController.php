<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        abort_if(!$category->delete(),500,"Error");
        Log::info("category deleted successfully.");
        $this->response["result"] = "sucesso";
        return response()->json($this->response,200);
    }
}
