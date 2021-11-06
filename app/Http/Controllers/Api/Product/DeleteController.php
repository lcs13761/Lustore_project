<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use App\Http\Controllers\Api\Image\ImageController;

class DeleteController extends Controller
{
    public function index(Request $request, int|string $id)
    {

        if (!$this->levelAccess($request)) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }

        $delete = Product::find($id);
        if (!$delete) {
            $this->response["error"] = "Produto não encontrado.";
            return Response()->json($this->response, 400);
        }

        if ($delete->qts > 0) {
            $this->response["error"] = "Não é possivel excluir um produto disponivel em estoque.";
            return Response()->json($this->response, 400);
        }
       
        if (!$this->image($delete->id)) {
            $this->response["error"] = "Error ao deletar a image.";
            return Response()->json($this->response, 400);
        }

        if (!$delete->delete()) {
            $this->response["error"] = "Error ao deletar";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = "excluido com sucesso";
        return Response()->json($this->response, 200);
    }

    private function image($product)
    {
        $deleteImage = Image::where("product_id", $product)->get();
        if ($deleteImage->isNotEmpty()) {
            foreach ($deleteImage as $delete) {
                    if (!(new ImageController())->delete($delete["image"])) {
                    return false;
                }
            }
        }
        return true;
    }
}
