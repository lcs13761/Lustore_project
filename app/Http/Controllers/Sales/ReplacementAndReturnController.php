<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\DecodeJwt;
use App\Models\HistoricSales;

class ReplacementAndReturnController extends Controller
{
    private array $response = ["error" => '', "result" => []];
    private $product;

    public function getProductForReplacementAndReturn(Request $request){

        $levelPermission = (new DecodeJwt())->decode($request->header("Authorization"));

        if ($levelPermission->level < 5 && empty($request->input('codeSales'))) {
            $this->response["error"] = "codigo vazio ou usuario não autorizado";
            return Response()->json($this->response, 400);
        }

        $searchProductSale = HistoricSales::where('codeSales', $request->input('codeSales'))->orWhere('client', $request->input('codeSales'))->get();
        if($searchProductSale->isEmpty()){
            $this->response["error"] = "Produto não encontrado";
            return Response()->json($this->response, 200);
        }

        $this->response["result"] = $searchProductSale;
        return Response()->json($this->response, 200);
    }

    public function replacementProduct(Request $request){
            
        $Validator = Validator::make($request->all(), [
            "discount" => "required",
        ]);

        if ($Validator->fails()) {
            $this->response["error"] = "campos invalidos";
            return Response()->json($this->response, 400);
        }


    }
}
