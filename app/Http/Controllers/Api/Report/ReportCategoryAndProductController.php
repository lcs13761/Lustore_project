<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Report\ReportController;

class ReportCategoryAndProductController extends Controller
{
  private $categories;
  private $products;
  private int $allQts = 0;

  public function index()
  {
    $controller = new ReportController();
    $categoyYearSales = $controller->year();
    if ($categoyYearSales->isNotEmpty()) {

      $this->calculateCategoryMoreSales($categoyYearSales);
    }
    $this->response["result"]["categories"] = $this->categories;
    $this->response["result"]["products"] = $this->products;
    return $this->response;
  }

  private function calculateCategoryMoreSales($categoriesAndProducts)
  {
    foreach ($categoriesAndProducts as $value) {
      if (!isset($this->categories[$value["category"]])) {
        $this->categories[$value["category"]] =  0;
      }
      if (!isset($this->categories[$value["product"]])) {
        $this->products[$value["product"]] =  0;
      }

      $this->allQts += $value["qts"];
      $this->categories[$value["category"]] = $this->categories[$value["category"]] + $value["qts"];
      $this->products[$value["product"]] +=  $value["qts"];
    }
    foreach ($this->categories as $key => $value) {
      $this->categories[$key]  = round(($value / $this->allQts) * 100);
    }
    foreach ($this->products as $key => $value) {
      $this->products[$key]  = round(($value / $this->allQts) * 100);
    }
  }
}
