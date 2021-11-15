<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Category;

class ReportAnnualController extends Controller
{
    public function index()
    {
        $annualProfit = Category::join('historicsales', 'historicsales.category_id', "=", "categories.id")->select("categories.*", "historicsales.*")->get();
        $this->response["result"] = $this->annualProfitCalculations($annualProfit);
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
