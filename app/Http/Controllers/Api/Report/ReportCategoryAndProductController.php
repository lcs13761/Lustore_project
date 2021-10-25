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
}
