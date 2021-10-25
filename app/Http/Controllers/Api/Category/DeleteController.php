<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class DeleteController extends Controller
{
    public function index(Request $request, int|string $id)
    {

        if (!$this::levelAccess($request)) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }

        if (!Category::find($id)->delete()) {
            $this->response["error"] = "erro ao salva os dados";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = "sucesso";
        return $this->response;
    }
}
