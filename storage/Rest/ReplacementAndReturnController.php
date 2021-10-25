<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\DecodeJwt;
use App\Models\HistoricSales;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ReplacementAndReturnController extends Controller
{
    private array $response = ["error" => '', "result" => []];
    private $codeSales;

    public function getProductForReplacementAndReturn(Request $request)
    {
        $levelPermission = (new DecodeJwt())->decode($request->header("Authorization"));
        if ($levelPermission->level < 5 && empty($request->input('codeSales'))) {
            $this->response["error"] = "codigo vazio ou usuario não autorizado";
            return Response()->json($this->response, 400);
        }
        $searchProductSale = HistoricSales::where('codeSales', $request->input('codeSales'))->orWhere('client', $request->input('codeSales'))->get();
        if ($searchProductSale->isEmpty()) {
            $this->response["error"] = "Produto não encontrado";
            return Response()->json($this->response, 200);
        }
        $this->response["result"] = $searchProductSale;
        return Response()->json($this->response, 200);
    }

    public function devolutionProduct(int|string $id)
    {

        $productDevolution = HistoricSales::find($id);
        $this->checkProduct($productDevolution);
        $product = Product::where("code", $productDevolution->code)->first();
        $this->devolution($product, $productDevolution);
    }

    public function replacementProduct(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            "codeSales" => "required",
            "products" => "required",
            "replacements" => "required"
        ]);
        if ($Validator->fails()) {
            $this->response["error"] = "campos invalidos";
            return Response()->json($this->response, 400);
        }
        $this->codeSales = rand() % 2 . mt_rand();

        foreach ($request->input('replacements') as $replacement) {
            $replacementProduct = HistoricSales::where("codeSales", $request->input('codeSales'))->where("code", $replacement["code"])->first();
            $this->checkProduct($replacementProduct);
            $getProduct = Product::where("code", $replacement["code"])->first();
            $this->checkProductQtsForReplacement($replacementProduct, $replacement["code"], $getProduct);
        }

        foreach ($request->input('products') as $product) {
            $getProduct = Product::where("code", $product["code"])->first();
            $this->checkProduct($getProduct);
            $this->saveReplacementProduct($getProduct, $replacementProduct->client, $product["qts"]);
        }
        $this->response["error"] = "Salvo com sucesso";
        return Response()->json($this->response, 200);
    }

    private function checkProduct($product)
    {
        if (empty($product)) {
            throw new \Exception('Product not found');
        }
    }

    private function checkProductQtsForReplacement(HistoricSales $replacementProduct, int $qts, $updateQtsProduct)
    {
        if (($replacementProduct->qts - $qts) <= 0 && $qts <= $replacementProduct->qts) {
            $this->devolution($updateQtsProduct, $replacementProduct);
        }

        if (($replacementProduct->qts - $qts) > 0) {
            $updateQtsProduct->qts +=  $replacementProduct->qts;
            $replacementProduct->qts -= $qts;
            if (!$replacementProduct->save() || !$updateQtsProduct->save()) {
                throw new \Exception('Error devolution');
            }
        }
    }

    private function devolution(Product $updateQtsProduct, HistoricSales $devolutionProduct)
    {
        $updateQtsProduct->qts +=  $devolutionProduct->qts;
        if (!$devolutionProduct->delete() || !$updateQtsProduct->save()) {
            throw new \Exception('Error devolution');
        }
    }

    private function saveReplacementProduct($getProduct, $client, int $qts)
    {
        if (empty($getProduct) || $getProduct->qts <= 0) {
            throw new \Exception('Product not found');
        }

        $createNewHistoricSale = new HistoricSales();
        $createNewHistoricSale->client = $client;
        $createNewHistoricSale->code = $getProduct->code;
        $createNewHistoricSale->product = $getProduct->product;
        $createNewHistoricSale->saleValue = $getProduct->saleValue;
        $createNewHistoricSale->size = $getProduct->size;
        $createNewHistoricSale->qts = $qts;
        $createNewHistoricSale->id_category = $getProduct->id_category;
        $createNewHistoricSale->codeSales = $this->codeSales;

        $getProduct->qts -= $qts;

        if (!$getProduct->save() ||  !$createNewHistoricSale->save()) {
            throw new \Exception('Error');
        }
    }
}
