<?php

namespace App\Http\Controllers\Api\Cost;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MonthCost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MonthCostController extends Controller
{

    public function getCost()
    {
        $cost = new MonthCost();
        return  $cost->get();
    }

    public function saveMonthCost(Request $request)
    {

        $Validator = Validator::make($request->all(), [
            "value" => "required",
            "month" => "required",
        ]);
        if ($Validator->fails()) {
            $this->response["error"] = "campos invalidos";
            return $this->response;
        }

        try {
            $costVerificacion = MonthCost::where("month", (int)$request->input("month"))->firstOrFail();
            if (!$costVerificacion->update(["value" => (float)$request->input('value')])) {
                $this->response["error"] = "erro ao salva os dados";
                return Response()->json($this->response, 400);
            }
            $this->response["result"] = "sucesso ao adicionar os custo";
            return $this->response;
        } catch (ModelNotFoundException $e) {
        }

        $createCost = [
            "value" =>  (float)$request->input('value'),
            "month" => (int)$request->input('month')
        ];


        if (!MonthCost::create()) {
            $this->response["error"] = "erro ao salva os dados";
            return Response()->json($this->response, 400);
        }
        $this->response["result"] = "sucesso ao adicionar os custo";
        return $this->response;
    }
}
