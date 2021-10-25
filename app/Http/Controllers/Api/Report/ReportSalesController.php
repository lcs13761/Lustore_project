<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Report\ReportController;

class ReportSalesController extends Controller
{
    public function index()
    {
        $controller = new ReportController();
        $sales = $controller->year();
        $controller->reportForMonthSales("sales", $sales);
        $this->response["result"] = $controller->monthSales;
        return Response()->json($this->response, 200);
    }
}
