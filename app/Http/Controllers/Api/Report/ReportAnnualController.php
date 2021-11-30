<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Historic;

class ReportAnnualController extends Controller
{
    public function index()
    {
        $annualProfit = Historic::with('category')->get();
        if($annualProfit->isNotEmpty()){
            $this->response["result"] = $this->annualProfitCalculations($annualProfit);
        }
        return Response()->json($this->response, 200);
    }

    private function annualProfitCalculations($annualProfit)
    {
        $yearList = array();
        foreach ($annualProfit as $value) {

            $year = date_format($value["created_at"], "Y");
            if (!isset($yearList[$year])) {
                $yearList[$year] = 0.0;
            }

            $yearList[$year] += $value["saleValue"] * $value["qts"];
        }
        return $yearList;
    }
}
