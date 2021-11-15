<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Historic;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HistoricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function store(Request $request): Response|JsonResponse
    {
        $salesSaveHistoric = Sale::where("salesman" , $this->token()->level == 5 ? $this->emailAccess() : "system")->get();

        if($salesSaveHistoric->isEmpty()){
            $this->response["error"] = "Cliente nâo encontrado";
            return Response()->json($this->response, 404);
        }

        $salesSaveHistoric->loadMissing("product");
        $codeSales = rand() % 2 . mt_rand();
        foreach ($salesSaveHistoric as $allSaleConfirm) {
            $value = $allSaleConfirm->discount / 100;
            $value = $allSaleConfirm->product->saleValue - ($allSaleConfirm->product->saleValue * $value);
            $sales = array(
                "code" => $allSaleConfirm->product->code,
                "client" => $allSaleConfirm->client,
                "category_id" => $allSaleConfirm->product->category_id,
                "product" => "{$allSaleConfirm->product->product}",
                "saleValue" => (float)"{$value}",
                "discount" => (float)"{$allSaleConfirm->discount}",
                "size" => "{$allSaleConfirm->product->size}",
                "qts" => (int)"{$allSaleConfirm->qts}",
                "codeSales" => "{$codeSales}",
            );
            Historic::create($sales);
        }

        $salesSaveHistoric->each->delete();
        $this->response["result"] = "Salvo com Sucesso";
        return Response()->json($this->response);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Historic  $historic
     * @return Response
     */
    public function show(Historic $historic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Historic  $historic
     * @return Response
     */
    public function update(Request $request, Historic $historic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Historic  $historic
     * @return Response
     */
    public function destroy(Historic $historic)
    {
        //
    }
}
