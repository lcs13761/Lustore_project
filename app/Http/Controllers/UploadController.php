<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class UploadController extends Controller
{
    //
    private array $response = ["error" => '', "result" => []];

    public function __construct()
    {
        //$this->middleware("auth:api");
    }

    public function uploadPhoto(Request $request): JsonResponse
    {

        $validate = Validator::make($request->only("image") , [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validate->fails()) {
            $this->response["result"] = "Imagem inexistente, ou tipo de arquivo invalido";
            return response()->json($this->response);

        }
        $url = $request->file("image")->store("images", "public");
        $path = asset("storage/". $url);
        $this->response["result"] = $path;
        return response()->json($this->response);
    }

    public function delete(Request $request): JsonResponse
    {



        $file = str_replace("http://127.0.0.1:8000/storage/", "", $request->input("image"));
        $test = Storage::disk("public")->delete($file);
        $this->response["a"] = $file;
        $this->response["result"] = $test;
        return response()->json($this->response);

    }

}
