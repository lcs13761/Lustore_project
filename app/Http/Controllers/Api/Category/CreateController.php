<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CreateController extends Controller
{
    public function index(Request $request){
        
        if(!$this->levelAccess($request)){
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }

        $request->validate([
            "category" => "required"
        ]);

        $category = ["category" => $request->category];
        if (!Category::create($category)) {
            $this->response["error"] = "erro ao salva os dados";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = "sucesso ao adicionar a categoria.";
        return $this->response;
    }
}
