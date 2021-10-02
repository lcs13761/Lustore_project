<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DecodeJwt;
use App\Models\HistoricSales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\products;
use App\Models\Sales;
use DateTime;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeUnit\FunctionUnit;

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

    public function getYearlyNow()
    {
        $date = date_format(new DateTime(), 'Y-m-d H:i:s');
        $date = explode("-", $date);
        $sales = DB::table('historicsales')->join('categories', 'categories.id', "=", "historicsales.id_category")->whereMonth("historicsales.created_at", "<=", $date[1])->whereYear("historicsales.created_at", $date[0])->select("categories.*", "historicsales.*")->get();
        $this->response["result"] = $sales;
        return $this->response;
    }
    public function getSalesFinally()
    {

        $sales =   DB::table('categories')->join('historicsales', 'historicsales.id_category', "=", "categories.id")->select("categories.*", "historicsales.*")->get();
        $this->response["result"] = $sales;
        return $this->response;
    }

    public function sales(Request $request)
    {

        $user = (new DecodeJwt())->decode($request->header("Authorization"))->email;
        $product = (object)$request->input("product");

        if(empty($product->code) || empty($product->qts)){
            $this->response["error"] = $product->qts;
            return Response()->json($this->response, 400);
        }

        try {
            $ProductCreate = Products::where('code', $product->code)->firstOrFail();
            if ($ProductCreate->qts == 0) {
                $this->response["error"] = "Produto indisponivel";
                return response()->json($this->response, 404);
            }
            if (($ProductCreate->qts - $product->qts) < 0) {
                $this->response["error"] = "{$ProductCreate->qts} Produto disponivel";
                return response()->json($this->response, 404);
            }
        } catch (ModelNotFoundException $e) {
            $this->response["error"] = "Produto não encontrado";
            return response()->json($this->response, 404);
        } catch (\Exception $e) {
            $this->response["error"] = $e;
            return response()->json($this->response, 500);
        }

        $sales = new Sales();
        $sales->code = $product->code;
        $sales->client = !empty($request->input('client')) ? $request->input('client') : $user;
        $sales->product = $ProductCreate->product;
        $sales->id_product = $ProductCreate->id;
        $sales->saleValue = $ProductCreate->saleValue;
        $sales->size = $ProductCreate->size;
        $sales->qts = $product->qts;
        $sales->category = $ProductCreate->id_category;

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
        if ($levelPermission->email != $updateProductSales->client) {
            $this->response["error"] = "produto não encontrado";
            return Response()->json($this->response, 400);
        }

        $productSalesQts = (object)$request->input("product");
       
        if ($productSalesQts->qts > $updateProductSales->qts) {
            $product->qts -= ($productSalesQts->qts - $updateProductSales->qts);
            if( $product->qts < 0){
                $this->response["error"] = "Produto indisponivel";
                return Response()->json($this->response, 200);
            }
        }
        if ($productSalesQts->qts < $updateProductSales->qts){
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

    public function discountAllProducts(Request $request)
    {

        $user = (new DecodeJwt())->decode($request->header("Authorization"));

        if (!Auth::check() || $user->level != 5) {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }

        $Validator = Validator::make($request->all(), [
            "discount" => "required",
        ]);

        if ($Validator->fails()) {
            $this->response["error"] = "campos invalidos";
            return Response()->json($this->response, 400);
        }

        $client = !empty($request->input('client')) ? $request->input('client') : $user->email;
        $discountAllProducts = Sales::where("client", $client)->get();

        if ($discountAllProducts->isEmpty()) {
            $this->response["error"] = "cliente não tem produto para adicionar desconto";
            return Response()->json($this->response, 400);
        }
        $discount = $request->input('discount');
        Sales::where("client", $client)->update([
            "discount" => $discount,
        ]);

        $this->response["result"] =  Sales::leftJoin("images", "sales.id_product", "=", "images.id_product")->select("sales.*", "images.image")->get();
        return Response()->json($this->response, 200);
    }

    public function deleteAll(Request $request)
    {


        $user = (new DecodeJwt())->decode($request->header("Authorization"))->email;
        $client = !empty($request->input('client')) ? $request->input('client') : $user;
        try {
            $deleteSaleOne = Sales::where("client", $client)->delete();
            $this->response["error"] = "Excluido com sucesso";
            return Response()->json($this->response, 200);
        } catch (ModelNotFoundException $e) {
            $this->response["error"] = "aff";
            return Response()->json($this->response, 404);
        } catch (\Exception $e) {
            $this->response["error"] = "error desconhecido";
            return Response()->json($this->response, 500);
        }
        $this->response["error"] = "Excluidos com sucesso";
        return Response()->json($this->response, 200);
    }

    public function finalizeSale(Request $request)
    {

        $user = (new DecodeJwt())->decode($request->header("Authorization"))->email;
        $client = !empty($request->input('client')) ? $request->input('client') : $user;

        try {
            $allSalesConfirm = Sales::where("client", $client)->get();
            $deleteSaleOne = Sales::where("client", $client)->delete();
        } catch (ModelNotFoundException $e) {
            $this->response["error"] = "aff";
            return Response()->json($this->response, 404);
        } catch (\Exception $e) {
            $this->response["error"] = "error desconhecido";
            return Response()->json($this->response, 500);
        }
        $salesHst = new historicSales();
        $codeSales = rand() % 2 . mt_rand();
        $sales = [];

        foreach ($allSalesConfirm as $allSaleConfirm) {
            $value = $allSaleConfirm->discount / 100;
            $value = $allSaleConfirm->saleValue - ($allSaleConfirm->saleValue * $value);
            $sales[] = array(
                "code" => $allSaleConfirm->code,
                "client" => $allSaleConfirm->client,
                "id_category" => $allSaleConfirm->category,
                "product" => "{$allSaleConfirm->product}",
                "saleValue" => (float)"{$value}",
                "discount" => (float)"{$allSaleConfirm->discount}",
                "size" => "{$allSaleConfirm->size}",
                "qts" => (int)"{$allSaleConfirm->qts}",
                "codeSales" => "{$codeSales}",
            );
        }

        try {
            for ($i = 0; $i < count($sales); $i++) {
                $salesHst->create($sales[$i]);
            }

            $this->response["error"] = "Salvo com Sucesso";
            return Response()->json($this->response, 200);
        } catch (ModelNotFoundException $e) {
            $this->response["error"] = "asfasdfsda";
            return Response()->json($this->response, 404);
        } catch (\Exception $e) {
            $this->response["error"] = $e;
            return Response()->json($this->response, 500);
        }
        return;
    }
}
