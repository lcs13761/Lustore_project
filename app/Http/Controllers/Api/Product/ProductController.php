<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DecodeJwt;
use App\Models\Images;
use App\Models\Products;
use Faker\Provider\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private array $response = ["error" => '', "result" => []];
    private String $code;
    private String $product;
    private int $category;
    private float $saleValue;
    private String $size;
    private int $qts;
    private int $allQts;
    private String|null $description;

    public function __construct()
    {
        $this->middleware("auth:api");
    }

    private function product(Products $product): Products
    {

        $product->code = $this->code;
        $product->product = $this->product;
        $product->id_category = (int)$this->category;
        $product->saleValue = (float)$this->saleValue;
        $product->size = $this->size;
        $product->qts = (int)$this->qts;
        $product->allQts = $this->allQts;
        $product->description = $this->description;

        return $product;
    }

    public function createProduct(Request $request): JsonResponse|array
    {

        $levelPermission = (new DecodeJwt())->decode($request->header("Authorization"));
        if (!Auth::check() || $levelPermission->level != 5) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }

        $Validator = Validator::make($request->all(), [
            "code" => "required",
            "product" => "required",
            "saleValue" => "required",
            "size" => "required",
            "qts" => "required",
        ]);
        if ($Validator->fails()) {
            $this->response["error"] = "campos invalidos";
            return Response()->json($this->response, 401);
        }
        $checkProduct = Products::where('code', $request->input('code'))->exists();
        if ($checkProduct) {
            $this->response["error"] = "Produto ja registrado";
            return Response()->json($this->response, 400);
        }

        $this->code = $request->input('code');
        $this->product = $request->input('product');
        $this->id_category = (int)$request->input('category')["id"];
        $this->saleValue = (float)$request->input('saleValue');
        $this->size = $request->input('size');
        $this->qts = (int)$request->input('qts');
        $this->allQts = $this->qts;
        $this->description = null;

        $product = new Products();
        $createProduct = $this->product($product);

        if (!$createProduct->save()) {
            $this->response["error"] = "erro ao salva os dados";
            return Response()->json($this->response, 400);
        }

        if (!empty($request->input("image"))) {
            $image = $request->input("image");
            $saveImage = new Images();
            $saveImage->image = $image;
            $saveImage->id_product = $createProduct->id;

            if (!$saveImage->save()) {
                $this->response["error"] = "erro ao salva os dados";
                return Response()->json($this->response, 400);
            }
        }

        $this->response["result"] = "sucesso ao adicionar produto";
        return $this->response;
    }

    public function updateProduct(Request $request, int|string $code): JsonResponse|array
    {

        $levelPermission = (new DecodeJwt())->decode($request->header("Authorization"));
        if (!Auth::check() || $levelPermission->level != 5) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }

        $Validator = Validator::make($request->all(), [
            "product" => "required",
            "saleValue" => "required",
            "code" => "required",
            "qts" => "required",
            "size" => "required",
        ]);

        if ($Validator->fails()) {
            $this->response["error"] = "campos invalidos";
            return Response()->json($this->response, 400);
        }
        $this->code = $request->input("code");
        $this->product = $request->input("product");
        $this->category = (int)$request->input('category')["id"];
        $this->saleValue = (float)$request->input("saleValue");
        $this->size = $request->input("size");
        $this->qts = (int)$request->input("qts");
        $this->description = !empty($request->input('description')) ? $request->input('description') : null;

        try {

            $updateProduct = Products::where('code', $code)->firstOrFail();

            if ($updateProduct->qts != $this->qts) {
                $newQtsAll =  abs($this->qts - $updateProduct->qts);
                $this->allQts =  $updateProduct->allQts + $newQtsAll;
            }

            $updateProduct = $this->product($updateProduct);

            if (!$updateProduct->save()) {
                $this->response["error"] = "erro ao salva os dados";
                return Response()->json($this->response, 400);
            }

            $this->response["result"] = "sucesso ao editar";
            return $this->response;
        } catch (ModelNotFoundException $e) {
            $this->response["error"] = "Produto não encontrado";
            return Response()->json($this->response, 404);
        } catch (\Exception $e) {
            $this->response["error"] =  $e;
            return Response()->json($this->response, 500);
        }
    }

    public function delProduct(Request $request, int|string $code): JsonResponse|array
    {

        $levelPermission = (new DecodeJwt())->decode($request->header("Authorization"));
        if (!Auth::check() || $levelPermission->level != 5) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }

        if (empty($code)) {
            $this->response["error"] = "informe o produto que deseja deletar";
            return Response()->json($this->response, 400);
        }
        try {

            $deleteProduct = Products::where("code", $code)->firstOrFail();
            if ($deleteProduct->qts > 0) {
                return Response()->json("Não é possivel excluir um produto com quantidade disponivel", 400);
            }
            $deleteImage = Images::where("id_product", $deleteProduct->id)->get();
            if ($deleteImage->isNotEmpty()) {

                foreach ($deleteImage as $delete) {
                    $image = str_replace("http://127.0.0.1:8000/storage/", "", $delete->image);
                    if (Storage::disk("public")->exists($image)) Storage::disk("public")->delete($image);
                }
            }
            if (!$deleteProduct->delete()) {
                $this->response["error"] = "Error ao deletar";
                return Response()->json($this->response, 400);
            }
            $this->response["result"] = "excluido com sucesso";
            return Response()->json($this->response, 200);
        } catch (ModelNotFoundException $e) {
            $this->response["error"] = "Produto não encontrado";
            return Response()->json($this->response, 404);
        } catch (\Exception $e) {
            $this->response["error"] = $e;
            return Response()->json($this->response, 500);
        }
    }
}
