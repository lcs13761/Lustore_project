<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\Sale\SaleCollection;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index(): Response|JsonResponse
    {
        $sale = Sale::where("salesman" , $this->token()->level == 5 ? $this->emailAccess() : "system" )->get();
        return (new SaleCollection($sale->loadMissing(["product"])))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaleRequest $request
     * @return JsonResponse|Response
     */
    public function store(SaleRequest $request): Response|JsonResponse
    {
        $product = Product::find($request->product["id"]);
        $product->qts  -= $request->qts;
        abort_if($product->qts < 0,500,"error quantdade");
        $verifySale = Sale::where("client", $request->client)->where(function($query) use ($request){
            $query->where("product_id", $request->product["id"])->where("salesman", $request->salesman);
        })->first();

        if ($verifySale) {
            abort_if(!$verifySale->update(["qts" => $verifySale->qts + $request->qts]) || !$product->save(), 500, "Error");
        } else {
            $create = [
                "client" => $request->client,
                "salesman" => $this->token()->level == 5 ? $this->emailAccess() : "system",
                "product_id" => $request->product["id"],
                "saleValue" => $product->saleValue,
                "discount" => $request->discount,
                "qts" => $request->qts,
            ];
            abort_if(!Sale::create($create) || !$product->save(), 500, "Error");
        }
        Log::info("sale created successfully.");
        $this->response["result"] = "sucesso";
        return response()->json($this->response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Sale $sale
     * @return Response
     */
    public function show(Sale $sale)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaleRequest $request
     * @param Sale $sale
     * @return JsonResponse|Response
     */
    public function update(SaleRequest $request, Sale $sale): Response|JsonResponse
    {
        $product = Product::find($sale->product_id);

        if($request->qts > $sale->qts) {
            $newQts = $request->qts - $sale->qts;
            $product->qts -= $newQts;
        }
        if($request->qts < $sale->qts && $request->qts > 0) {
            $newQts = $sale->qts - $request->qts;
            $product->qts += $newQts;
        
        }

        abort_if(!$sale->update($request->all()) || !$product->save(), 500, "Error");
        Log::info("Product created successfully.");
        $this->response["result"] = "sucesso ao modificar";
        return response()->json($this->response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Sale $sale
     * @return JsonResponse|Response
     */
    public function destroy(Sale $sale): Response|JsonResponse
    {
        $product = Product::find($sale->product_id);
        $product->qts += $sale->qts;
        abort_if(!$sale->delete() || !$product->save(), 500, "Error ao excluir.");
        Log::info("Product removed successfully.");
        $this->response["result"] = "sucesso";
        return response()->json($this->response);
    }

}
