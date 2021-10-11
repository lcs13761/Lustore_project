<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MonthCost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MonthCostController extends Controller
{
    private array $response = ["error" => '', "result" => []];

    public function __construct()
    {
        $this->middleware("auth:api", ["except" => ["getAllProducts", "getProduct"]]);
    }

    public function getCost(){
        $cost = new MonthCost();
        $this->response["result"] = $cost->get();
        return $this->response;
    }

    public function saveMonthCost(Request $request){

        $Validator = Validator::make($request->all(), [
            "value" => "required",
            "month" => "required",
        ]);
        if ($Validator->fails()) {
            $this->response["error"] = "campos invalidos";
            return $this->response;
        }
        
        try{
            $costVerificacion = MonthCost::where("month" , (int)$request->input("month"))->firstOrFail();
            $costVerificacion->value = (float)$request->input('value');
            if (!$costVerificacion->save()) {
                $this->response["error"] = "erro ao salva os dados";
                return Response()->json($this->response, 400);
            }
            $this->response["result"] = "sucesso ao adicionar os custo";
            return $this->response;
        }catch (ModelNotFoundException $e) {
        }

        $createCost = new MonthCost();
        $createCost->value = (float)$request->input('value');
        $createCost->month = (int)$request->input('month');
    
        if (!$createCost->save()) {
            $this->response["error"] = "erro ao salva os dados";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = "sucesso ao adicionar os custo";
        return $this->response;
    }
}
