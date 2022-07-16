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

        $product = explode("/", $this->path())[2];
        return [
            "code" => "required|integer|unique:products,code," . $product . ",id",
            "product" => "required|string",
            "images" => "nullable|array",
            "images.id" => "nullable|integer",
            "images.image" => "nullable|string",
            "category" => "required|array",
            "category.id" => "required|integer",
            "costValue" => "required|numeric",
            "saleValue" => "required|numeric",
            "description" => "nullable",
            "size" => "required|string",
            "qts" => "required|integer"
        ];
    }
}
