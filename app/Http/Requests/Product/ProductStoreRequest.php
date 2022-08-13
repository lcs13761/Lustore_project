<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
        return [
            "code_product" => "required|integer|unique:products,code_product",
            "barcode" => "required|integer|unique:products,barcode",
            "product" => "required",
            "images" => "nullable|array",
            "category" => "required|integer",
            "costValue" => "required|numeric",
            "saleValue" => "required|numeric",
            "description" => "nullable",
            "size" => "required|string",
            "qts" => "required|integer"
        ];
    }
}
