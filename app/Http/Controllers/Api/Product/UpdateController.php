<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\Image\ImageController;
use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class UpdateController extends Controller
{
    public function index(Request $request, int|string $id)
    {

        if (!$this->levelAccess($request)) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }

        $request->validate([
            "product" => "required",
            "saleValue" => "required",
            "costValue" => "required",
            "code" => "required",
            "qts" => "required|int",
            "size" => "required|int",
            "category" => "required",
            "description" => "required",
            "image" => []
        ]);

        $update = Product::find($id);
        if (!$update) {
            $this->response["error"] = "Produto não encontrado.";
            return Response()->json($this->response, 400);
        }


        if($update->code != $request->code){
            $exist = Product::where("code",$request->code)->exists();
            if($exist){
                $this->response["error"] = "Codigo do produto ja foi registrado.";
                return Response()->json($this->response, 400);
            }
        }

        if ($update->qts != $request->qts) {
            $newQtsAll =  abs($request->qts - $update->qts);
            $request->allQts =  $update->allQts + $newQtsAll;
        }

        $updateProduct = [
            "code" => $request->code,
            "product" => $request->product,
            "category" => $request->category["id"],
            "saleValue" => $request->saleValue,
            "costValue" =>  $request->costValue,
            "size" => $request->size,
            "qts" => $request->qts,
            "allQts" => $request->allQts,
            "description" => $request->description
        ];

        if ($request->image) {

            foreach ($request->image as $image) {

               $this->image($image["image"], $image["id"],$update->id);
            }
        }

        if (!$update->update($updateProduct)) {
            $this->response["error"] = "erro ao salva os dados";
            return Response()->json($this->response, 400);
        }

        $this->response["result"] = "sucesso ao editar";
        return Response()->json($this->response, 200);
    }

    private function image($image,$id, $product)
    {

        if(!empty($id)){
            Image::create([
                "image" => $image,
                "product_id" => $product
            ]);
            return;
        }

        $img = Image::find($id);
        $img->image = $image;
        if($img->image != $image){
            if (!(new ImageController())->delete($img->image)) {
                return false;
            }
            return true;
        }
    
        $img->save();
        return true;
    }



}
