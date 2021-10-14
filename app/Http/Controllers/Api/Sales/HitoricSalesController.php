<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
    use App\Models\HistoricSales;
use App\Http\Controllers\DecodeJwt;
use App\Models\Sales;


class HitoricSalesController extends Controller
{
    private array $response = ["error" => '', "result" => []];

    public function __construct()
    {
        $this->middleware("auth:api" );
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
        
        $codeSales = rand() % 2 . mt_rand();
        $sales = [];

        foreach ($allSalesConfirm as $allSaleConfirm) {
            $value = $allSaleConfirm->discount / 100;
            $value = $allSaleConfirm->saleValue - ($allSaleConfirm->saleValue * $value);
            $sales[] = array(
                "code" => $allSaleConfirm->code,
                "client" => $allSaleConfirm->client,
                "id_category" => $allSaleConfirm->id_category,
                "product" => "{$allSaleConfirm->product}",
                "saleValue" => (float)"{$value}",
                "discount" => (float)"{$allSaleConfirm->discount}",
                "size" => "{$allSaleConfirm->size}",
                "qts" => (int)"{$allSaleConfirm->qts}",
                "codeSales" => "{$codeSales}",
            );
        }
    
        return $this->saveHistoric($sales,$client);
    }

    private function saveHistoric(array $sales,$client){
        $salesHst = new HistoricSales();
        try {
            for ($i = 0; $i < count($sales); $i++) {
                $salesHst->create($sales[$i]);
            }
            Sales::where("client", $client)->delete();

            $this->response["result"] = "Salvo com Sucesso";
            return Response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response["error"] = $e;
            return Response()->json($this->response, 500);
        }
    }

}
