<?php

namespace App\Http\Controllers\Api\Report;


use App\Http\Controllers\Controller;
use DateTime;
use App\Models\Historic;

class ReportController extends Controller
{
    public array $monthSales;
    private $month;


    public function year()
    {
        $date = date_format(new DateTime(), 'Y-m-d H:i:s');
        $date = explode("-", $date);
        $historic = Historic::with('category');
        return $historic->whereMonth("historicSales.created_at", "<=", $date[1])->whereYear("historicSales.created_at", $date[0])->get();
    
    }

    public function reportForMonthSales($salesOrCosts)
    {
        
        $this->month = date_format(new DateTime(), 'm');
        foreach ($salesOrCosts as $saleOrCost) {
            $value = (float)$saleOrCost["saleValue"] * $saleOrCost["qts"];
            $monthCreate = date_format($saleOrCost["created_at"], 'm');
            $this->salesAndCostVerification("JAN", $monthCreate, 1, $value);
            $this->salesAndCostVerification("FEV", $monthCreate, 2, $value);
            $this->salesAndCostVerification("MAR", $monthCreate, 3, $value);
            $this->salesAndCostVerification("ABR", $monthCreate, 4, $value);
            $this->salesAndCostVerification("MAI", $monthCreate, 5, $value);
            $this->salesAndCostVerification("JUN", $monthCreate, 6, $value);
            $this->salesAndCostVerification("JUL", $monthCreate, 7, $value);
            $this->salesAndCostVerification("AGO", $monthCreate, 8, $value);
            $this->salesAndCostVerification("SET", $monthCreate, 9, $value);
            $this->salesAndCostVerification("OUT", $monthCreate, 10, $value);
            $this->salesAndCostVerification("NOV", $monthCreate, 11, $value);
            $this->salesAndCostVerification("DEZ", $monthCreate, 12, $value);
        }
    }

    private function salesAndCostVerification($monthText, $monthCreate, $numberMonth, $valueCalc)
    {

        if ((!isset($this->monthSales[$monthText])) && $this->month >= $numberMonth) $this->monthSales[$monthText] = 0.0;
        if ($monthCreate == $numberMonth && $this->month >= $numberMonth) {

            $this->monthSales[$monthText] += $valueCalc;
        }
    }
}
