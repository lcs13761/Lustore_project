<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Report\ReportController;
use App\Models\MonthCost;

class ReportCostController extends Controller
{
    public function index()
    {
        $costs = (new MonthCost())->get();
        if($costs->isEmpty){
            $this->response["result"] = $costs;
            return Response()->json($this->response, 200);
        }
        $controller = new ReportController();
        $controller->reportForMonthSales("cost", $costs);
        $this->response["result"] = $controller->costMonth;
        return Response()->json($this->response, 200);
    }
}
