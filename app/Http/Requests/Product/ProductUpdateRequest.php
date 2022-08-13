<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = request()->route('product');

        return [
            "code_product" => "nullable|integer|unique:products,code_product,$id",
            "barcode" => "nullable|integer|unique:products,barcode,$id",
            "product" => "nullable|string",
            "images" => "nullable|array",
            "category" => "nullable|integer",
            "costValue" => "nullable|numeric",
            "saleValue" => "nullable|numeric",
            "description" => "nullable",
            "size" => "nullable|string",
            "qts" => "nullable|integer"
        ];
    }
}
