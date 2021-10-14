<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DecodeJwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\products;
use App\Models\Sales;


class SalesProduct extends Controller
{
    private array $response = ["error" => '', "result" => []];

    public function __construct()
    {
        $this->middleware("auth:api", ["except" => ["getSaleNow", "getYearlyNow"]]);
    }


    public function getSaleNow()
    {
        $sales = new Sales();
        $this->response["result"] = $sales->get();
        return $this->response;
    }

    public function createSale(Request $request)
    {

        $user = (new DecodeJwt())->decode($request->header("Authorization"))->email;
        $product = (object)$request->input("product");

        if (empty($product->code) || empty($product->qts)) {
            $this->response["error"] = $product->qts;
            return Response()->json($this->response, 400);
        }

        try {
            $ProductCreate = Products::where('code', $product->code)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $this->response["error"] = "Produto não encontrado";
            return response()->json($this->response, 404);
        } catch (\Exception $e) {
            $this->response["error"] = $e;
            return response()->json($this->response, 500);
        }

        if ($ProductCreate->qts == 0) {
            $this->response["error"] = "Produto indisponivel";
            return response()->json($this->response, 404);
        }
        if (($ProductCreate->qts - $product->qts) < 0) {
            $this->response["error"] = "{$ProductCreate->qts} Produto disponivel";
            return response()->json($this->response, 404);
        }


        $sales = new Sales();
        $sales->code = $product->code;
        $sales->client = !empty($request->input('client')) ? $request->input('client') : $user;
        $sales->product = $ProductCreate->product;
        $sales->id_product = $ProductCreate->id;
        $sales->saleValue = $ProductCreate->saleValue;
        $sales->size = $ProductCreate->size;
        $sales->qts = $product->qts;
        $sales->id_category = $ProductCreate->id_category;

        $ProductCreate->qts -= $product->qts;

        if (!$ProductCreate->save() || !$sales->save()) {
            $this->response["error"] = "erro ao salva os dados..";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = $sales::leftJoin("images", "sales.id_product", "=", "images.id_product")->select("sales.*", "images.image")->get();
        return $this->response;
    }

    public function updateProductSales(int|string $id, Request $request)
    {
        $levelPermission = (new DecodeJwt())->decode($request->header("Authorization"));

        try {
            $updateProductSales = Sales::find($id);
            $product =  Products::where('code', $updateProductSales->code)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $this->response["error"] = $e;
            return Response()->json($this->response, 404);
        } catch (\Exception $e) {
            $this->response["error"] = "error desconhecido";
            return Response()->json($this->response, 500);
        }

        $productSalesQts = (object)$request->input("product");

        if ($productSalesQts->qts > $updateProductSales->qts) {
            $product->qts -= ($productSalesQts->qts - $updateProductSales->qts);
            if ($product->qts < 0) {
                $this->response["error"] = "Produto indisponivel";
                return Response()->json($this->response, 200);
            }
        }
        if ($productSalesQts->qts < $updateProductSales->qts) {
            $product->qts += ($updateProductSales->qts - $productSalesQts->qts);
        };
        $updateProductSales->qts = $productSalesQts->qts;
        $updateProductSales->discount = $request->input('discount');

        if (!$updateProductSales->save() || !$product->save()) {
            $this->response["error"] = "Error";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = Sales::leftJoin("images", "sales.id_product", "=", "images.id_product")->select("sales.*", "images.image")->get();
        return Response()->json($this->response, 200);
    }

    public function deleteOne(int|string $id, Request $request)
    {
        $levelPermission = (new DecodeJwt())->decode($request->header("Authorization"));
        if (!Auth::check() || $levelPermission->level != 5) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }

        try {
            $deleteSaleOne = Sales::find($id);
            $product =  Products::where('code', $deleteSaleOne->code)->firstOrFail();
            $product->qts += $deleteSaleOne->qts;
            if (!$deleteSaleOne->delete() || !$product->save()) {
                $this->response["error"] = "Error";
                return Response()->json($this->response, 400);
            }
            $this->response["error"] = "Excluido com sucesso";
            return Response()->json($this->response, 200);
        } catch (ModelNotFoundException $e) {
            $this->response["error"] = $e;
            return Response()->json($this->response, 404);
        } catch (\Exception $e) {
            $this->response["error"] = "error desconhecido";
            return Response()->json($this->response, 500);
        }
    }

    
    public function deleteAll(Request $request)
    {
        $user = (new DecodeJwt())->decode($request->header("Authorization"))->email;
        $client = !empty($request->input('client')) ? $request->input('client') : $user;
        try {
            $deleteAll = Sales::where("client", $client)->get();
            if($deleteAll->isEmpty()){
                $this->response["error"] = "";
                return Response()->json($this->response, 200);
            }
            
            foreach ($deleteAll as $delete) {
                $product = Products::where("code" , $delete["code"])->first();
                if(!empty($product)) {
                    $product->qts +=  $delete["qts"];
                    $product->save();
                }

            }
            Sales::where("client", $client)->delete();
            $this->response["error"] = "Excluido com sucesso";
            return Response()->json($this->response, 200);
        } catch (ModelNotFoundException $e) {
            $this->response["error"] = "aff";
            return Response()->json($this->response, 404);
        } catch (\Exception $e) {
            $this->response["error"] = $e;
            return Response()->json($this->response, 500);
        }
        $this->response["result"] = "Excluidos com sucesso";
        return Response()->json($this->response, 200);
    }
}
