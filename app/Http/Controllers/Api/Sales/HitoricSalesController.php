<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoricSales;
use App\Http\Controllers\DecodeJwt;
use App\Models\Categories;
use App\Models\Sales;
use DateTime;

class HitoricSalesController extends Controller
{
    private array $response = ["error" => '', "result" => []];

    public function __construct()
    {
        $this->middleware("auth:api" , ["except" => ["getSalesFinally" , "getHistoricYearlyNow"]]);
    }

    
    public function getHistoricYearlyNow()
    {
        $date = date_format(new DateTime(), 'Y-m-d H:i:s');
        $date = explode("-", $date);
        $sales = HistoricSales::join('categories', 'categories.id', "=", "historicsales.id_category")->whereMonth("historicsales.created_at", "<=", $date[1])->whereYear("historicsales.created_at", $date[0])->select("categories.*", "historicsales.*")->get();
        $this->response["result"] = $sales;
        return $this->response;
    }

    public function getSalesFinally()
    {
        $sales = Categories::join('historicsales', 'historicsales.id_category', "=", "categories.id")->select("categories.*", "historicsales.*")->get();
        $this->response["result"] = $sales;
        return $this->response;
    }
    
    public function createHistoricSales(Request $request)
    {
        $user = (new DecodeJwt())->decode($request->header("Authorization"))->email;
        $client = !empty($request->input('client')) ? $request->input('client') : $user;

        $allSalesConfirm = Sales::where("client", $client)->get();

        if($allSalesConfirm->isEmpty()){
            $this->response["error"] = "Cliente nâo encontrado";
            return Response()->json($this->response, 404);
        }

        Sales::where("client", $client)->delete();
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

        return $this->saveHistoric($sales);
    }


    private function saveHistoric(array $sales){

        $salesHst = new HistoricSales();

        try {
            for ($i = 0; $i < count($sales); $i++) {
                $salesHst->create($sales[$i]);
            }
            $this->response["result"] = "Salvo com Sucesso";
            return Response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response["error"] = $e;
            return Response()->json($this->response, 500);
        }
    }

}
