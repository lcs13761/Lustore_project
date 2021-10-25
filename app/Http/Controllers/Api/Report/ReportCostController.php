<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Cost\MonthCostController;
use App\Http\Controllers\Api\Report\ReportController;

class ReportCostController extends Controller
{
    public function index()
    {
        $costs = (new MonthCostController())->getCost();
        $controller = new ReportController();
        $controller->reportForMonthSales("cost", $costs);
        $this->response["result"] = $controller->costMonth;
        return Response()->json($this->response, 200);
    }
}
