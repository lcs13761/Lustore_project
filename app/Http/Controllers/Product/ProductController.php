<?php

namespace App\Http\Controllers\Product;

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

    public function __construct()
    {
        $this->middleware("auth:api", ["except" => ["getAllProducts", "getProduct", "getByCategory"]]);
    }

    public function getAllProducts()
    {

        $Products =  DB::table('categories')->join('products', 'products.id_category', "=", "categories.id")->select("categories.*", "products.*")->get();
        $this->response["result"] = $Products;
        return $this->response;
    }

    public function getByCategory(int|string $id)
    {
        if(empty($id)){
            $this->response["result"] = "error";
            return $this->response;
        }
        $Products =  Products::leftJoin('images', 'images.id_product', "=", "products.id")->where('products.id_category', $id)->select("products.*", "images.image")->get();
        $this->response["result"] = $Products;
        return $this->response;
    }

    public function getProduct(int|string $code): JsonResponse|array
    {
        try {
            $Product = Products::where('code', $code)->firstOrFail();
            $this->response["result"] = $Product;
            return $this->response;
        } catch (ModelNotFoundException $e) {
            $this->response["error"] = "Produto não encontrado";
            return response()->json($this->response, 404);
        } catch (\Exception $e) {
            $this->response["error"] = "error desconhecido";
            return response()->json($this->response, 500);
        }
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
        if($checkProduct){
            $this->response["error"] = "Produto ja registrado";
            return Response()->json($this->response, 400);
        }  
        $createProduct = new Products();
        $createProduct->code = $request->input('code');
        $createProduct->product = $request->input('product');
        $createProduct->id_category = (int)$request->input('category')["id"];
        $createProduct->saleValue = (float)$request->input('saleValue');
        $createProduct->size = $request->input('size');
        $createProduct->qts = (int)$request->input('qts');
        $createProduct->allQts =  $createProduct->qts;

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


    /**
     * 401 - nao aautorz
     * 400 - bad request
     * 200 - ok
     * 500 - error desconhecido
     */
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
        $code = $request->input("code");
        $product = $request->input("product");
        $category = (int)$request->input('category');
        $saleValue = (float)$request->input("saleValue");
        $size = $request->input("size");
        $qts = (int)$request->input("qts");
        $description = !empty($request->input('description')) ? $request->input('description') : null;

        try {
            $updateProduct = Products::where('code', $code)->firstOrFail();
            $updateProduct->code = $code;
            $updateProduct->product = $product;
            $updateProduct->id_category = $category;
            $updateProduct->saleValue = $saleValue;
            $updateProduct->size = $size;
            if ($updateProduct->qts != $qts) {
                $newQtsAll =  abs($qts - $updateProduct->qts);
                $updateProduct->allQts += $newQtsAll;
            }
            $updateProduct->qts = $qts;
            $updateProduct->description = $description;
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
            $this->response["error"] = "erro desconhecido";
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
