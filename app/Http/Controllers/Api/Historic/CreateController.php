<?php

namespace App\Http\Controllers\Api\Historic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Historic;
use App\Models\Sale;

class CreateController extends Controller
{
    public function index(Request $request)
    {
        $client = $request->client ?? $this::emailAccess($request);

        $allSale = Sale::where("client", $client)->get();

        if($allSale->isEmpty()){
            $this->response["error"] = "Cliente não encontrado";
            return Response()->json($this->response, 404);
        }
        
        $codeSales = rand() % 2 . mt_rand();
        $sales = [];

        foreach ($allSale as $sale) {
            $value = $sale->discount / 100;
            $value = $sale->saleValue - ($sale->saleValue * $value);
            $sales[] = array(
                "code" => $sale->code,
                "client" => $sale->client,
                "category_id" => $sale->category_id,
                "product" => "{$sale->product}",
                "saleValue" => (float)"{$value}",
                "discount" => (float)"{$sale->discount}",
                "size" => "{$sale->size}",
                "qts" => (int)"{$sale->qts}",
                "codeSales" => "{$codeSales}",
            );
        }
    
        return $this->saveHistoric($sales,$client);
    }

    private function saveHistoric(array $sales,$client){

        $salesHst = new Historic();
        try {
            for ($i = 0; $i < count($sales); $i++) {
                $salesHst->create($sales[$i]);
            }
            Sale::where("client", $client)->delete();

            $this->response["result"] = "Salvo com Sucesso";
            return Response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response["error"] = $e;
            return Response()->json($this->response, 500);
        }
    }
}
