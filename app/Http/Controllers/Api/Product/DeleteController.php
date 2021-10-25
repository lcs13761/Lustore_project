<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;

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
            return Response()->json("Produto não encontrado.", 400);
        }

        if ($delete->qts > 0) {
            return Response()->json("Não é possivel excluir um produto disponivel em estoque.", 400);
        }

        $this->image($delete->id);

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
                (new Image())->delete($delete->image);
            }
        }
        return true;
    }
}
