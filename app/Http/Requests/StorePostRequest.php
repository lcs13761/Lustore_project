<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "code" => "required|integer|unique:products,code",
            "product" => "required",
            "category_id" => "required|array",
            "category_id.id" => "required|integer",
            "costValue" => "required|numeric",
            "saleValue" => "required|numeric",
            "description" => "nullable",
            "size" => "required|integer",
            "qts" => "required|integer"
        ];
    }
}
