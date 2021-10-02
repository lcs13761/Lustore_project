<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\DecodeJwt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    private array $response = ["error" => '', "result" => []];

    public function __construct()
    {
        $this->middleware("auth:api", ["except" => ["getAllCategories"]]);
    }

    public function getAllCategories(){

        $categories = new Categories();
        $this->response["result"] = $categories->get();
        return $this->response;
    }

    public function createCategory(Request $request){
        
        $Validator = Validator::make($request->all(), [
            "category" => "required"
        ]);


        if ($Validator->fails()) {
            $this->response["error"] = "campos invalidos";
            return $this->response;
        }
        
        $createCost = new Categories();
        $createCost->category = $request->input('category');
    
        if (!$createCost->save()) {
            $this->response["error"] = "erro ao salva os dados";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = "sucesso";
        return $this->response;
    }

    public function updateCategory(Request $request , int|string $id){

        $levelPermission = (new DecodeJwt())->decode($request->header("Authorization"));
        if (!Auth::check() || $levelPermission->level != 5) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }
        
        $createCost = Categories::find($id);
        $createCost->category = $request->input('category');
    
        if (!$createCost->save()) {
            $this->response["error"] = "erro ao salva os dados";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = "sucesso";
        return $this->response;
    }

    public function deleteCategory(Request $request , int|string $id){

        $levelPermission = (new DecodeJwt())->decode($request->header("Authorization"));
        if (!Auth::check() || $levelPermission->level != 5) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }
        
        $createCost = Categories::find($id)->delete();
        if (!$createCost) {
            $this->response["error"] = "erro ao salva os dados";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = "sucesso";
        return $this->response;
    }
}

