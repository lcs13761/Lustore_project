<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;


class UploadController extends Controller
{
    public function index(Request $request): JsonResponse
    {

        $validate = Validator::make($request->only("image"), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validate->fails()) {
            $this->response["result"] = "Imagem inexistente, ou tipo de arquivo invalido";
            return response()->json($this->response);
        }
        $url = $request->file("image")->store("images", "public_upload");
        $path = asset("storage/" . $url);
        $this->response["result"] = $path;
        return response()->json($this->response);
    }

  
}
