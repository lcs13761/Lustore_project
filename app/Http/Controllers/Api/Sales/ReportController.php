<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Api\Product\MonthCostController;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use DateTime;
use App\Models\HistoricSales;

class ReportController extends Controller
{
    private array $response = ["error" => '', "result" => []];

    private $costMonth;
    private $monthSales;
    private $month;
    private $categories;
    private $products;
    private int $allQts = 0;

    public function __construct()
    {
        $this->middleware("auth:api");
    }

    public function annualProfit(){

        $annualProfit = Categories::join('historicsales', 'historicsales.id_category', "=", "categories.id")->select("categories.*", "historicsales.*")->get();
        $this->response["result"] = $this->annualProfitCalculations($annualProfit);
        return $this->response;
    }

    private function annualProfitCalculations($annualProfit){

        $yearList = array();
        foreach ($annualProfit as $value){
            
            $year = date_format($value["created_at"],"Y");
            if(!isset($yearList[$year])){
                $yearList[$year] = 0.0;
            }

            $yearList[$year] += $value["saleValue"] * $value["qts"];
        }
        return $yearList;
    }

    public function getAllSalesReportsCost()
    {
        return $this->reportForMonthCost();
    }

    private function reportForMonthCost()
    {
        $costs = (new MonthCostController())->getCost();
        $this->reportForMonthSales("cost", $costs);
        $this->response["result"] = $this->costMonth;
        return $this->response;
    }

    public function getAllSalesReportsSales()
    {

        $sales = $this->year();
        $this->reportForMonthSales("sales", $sales);
        $this->response["result"] = $this->monthSales;
        return $this->response;
    }

    public function getCategoryAndProductBestSelling()
    {
        $categoySales = $this->year();
        $this->calculateCategoryMoreSales($categoySales);
        $this->response["result"]["categories"] = $this->categories;
        $this->response["result"]["products"] = $this->products;
        return $this->response;
    }

    private function calculateCategoryMoreSales($categories)
    {
        foreach ($categories as $category) {
            if (!isset($this->categories[$category["category"]])) {
                $this->categories[$category["category"]] =  0;
            }
            if (!isset($this->categories[$category["product"]])) {
                $this->products[$category["product"]] =  0;
            }

            $this->allQts += $category["qts"];
            $this->categories[$category["category"]] = $this->categories[$category["category"]] + $category["qts"];
            $this->products[$category["product"]] += $category["qts"];
        }
        foreach ($this->categories as $key => $value) {
            $this->categories[$key]  = round(($value / $this->allQts) * 100);
        }
        foreach ($this->products as $key => $value) {
            $this->products[$key]  = round(($value / $this->allQts) * 100);
        }    
    }

    private function year(){

        $date = date_format(new DateTime(), 'Y-m-d H:i:s');
        $date = explode("-", $date);
        return HistoricSales::join('categories', 'categories.id', "=", "historicsales.id_category")->whereMonth("historicsales.created_at", "<=", $date[1])->whereYear("historicsales.created_at", $date[0])->select("categories.*", "historicsales.*")->get();
    }

    private function reportForMonthSales($type, $salesOrCosts)
    {

        $this->month = date_format(new DateTime(), 'm');
        foreach ($salesOrCosts as $saleOrCost) {
            $value = $type == 'sales' ? (float)$saleOrCost["saleValue"] * $saleOrCost["qts"] : (float)$saleOrCost["value"];
            $month = date_format($saleOrCost["created_at"], 'm');
            $this->salesAndCostVerification($type, "janeiro", $month, 1, $value);
            $this->salesAndCostVerification($type, "fevereiro", $month, 2, $value);
            $this->salesAndCostVerification($type, "março", $month, 3, $value);
            $this->salesAndCostVerification($type, "abril", $month, 4, $value);
            $this->salesAndCostVerification($type, "maio", $month, 5, $value);
            $this->salesAndCostVerification($type, "junho", $month, 6, $value);
            $this->salesAndCostVerification($type, "julho", $month, 7, $value);
            $this->salesAndCostVerification($type, "agosto", $month, 8, $value);
            $this->salesAndCostVerification($type, "setembro", $month, 9, $value);
            $this->salesAndCostVerification($type, "outubro", $month, 10, $value);
            $this->salesAndCostVerification($type, "novembro", $month, 11, $value);
            $this->salesAndCostVerification($type, "dezembro", $month, 12, $value);
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
