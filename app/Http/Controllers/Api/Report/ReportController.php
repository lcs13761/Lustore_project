<?php

namespace App\Http\Controllers\Api\Report;


use App\Http\Controllers\Controller;
use DateTime;
use App\Models\Historic;

class ReportController extends Controller
{
    public $costMonth;
    public $monthSales;
    private $month;


    public function year()
    {
        $date = date_format(new DateTime(), 'Y-m-d H:i:s');
        $date = explode("-", $date);
        return Historic::join('categories', 'categories.id', "=", "historicsales.category_id")->whereMonth("historicsales.created_at", "<=", $date[1])->whereYear("historicsales.created_at", $date[0])->select("categories.*", "historicsales.*")->get();
    }

    public function reportForMonthSales($type, $salesOrCosts)
    {
        $this->month = date_format(new DateTime(), 'm');
        foreach ($salesOrCosts as $saleOrCost) {
            $value = $type == 'sales' ? (float)$saleOrCost["saleValue"] * $saleOrCost["qts"] : (float)$saleOrCost["value"];
            $month = date_format($saleOrCost["created_at"], 'm');
            $this->salesAndCostVerification($type, "JAN", $month, 1, $value);
            $this->salesAndCostVerification($type, "FEV", $month, 2, $value);
            $this->salesAndCostVerification($type, "MAR", $month, 3, $value);
            $this->salesAndCostVerification($type, "ABR", $month, 4, $value);
            $this->salesAndCostVerification($type, "MAI", $month, 5, $value);
            $this->salesAndCostVerification($type, "JUN", $month, 6, $value);
            $this->salesAndCostVerification($type, "JUL", $month, 7, $value);
            $this->salesAndCostVerification($type, "AGO", $month, 8, $value);
            $this->salesAndCostVerification($type, "SET", $month, 9, $value);
            $this->salesAndCostVerification($type, "OUT", $month, 10, $value);
            $this->salesAndCostVerification($type, "NOV", $month, 11, $value);
            $this->salesAndCostVerification($type, "DEZ", $month, 12, $value);
        }
    }

    private function salesAndCostVerification($type, $monthText, $month, $numberMonth, $valueCalc)
    {

        if (($type != "cost" && !isset($this->monthSales[$monthText]))  &&  $this->month >= $numberMonth) $this->monthSales[$monthText] = 0.0;
        if (($type != "sales") &&  $this->month >= $numberMonth)  $this->costMonth[$monthText] = 0.0;
        if ($month == $numberMonth && $this->month >= $numberMonth) {

            $type != "cost" ? ($this->monthSales[$monthText] += $valueCalc) : ($this->costMonth[$monthText] += $valueCalc);
        }
    }
}
