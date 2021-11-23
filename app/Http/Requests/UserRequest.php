<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
        switch($this->method()){
            case 'POST': {
                return [
                    "name" => ["required", "string"],
                    "email" => ["required", "email:rfc,dns","unique:users,email"],
                    "password" => ["required", Password::min(8)->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()]
                ];
            }
            case 'PUT': 
                case 'PATCH' : {
                    return [
                        "photo" => ["nullable", "file"],
                        "name" => ["required", "string"],
                        "email" => ["required", "email:rfc,dns", "unique:users,email," . $this->user()->id . ",id"],
                        "current_password" => ["nullable", "current_password:api"],
                        "password" => ["nullable", "confirmed", Password::min(8)->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()],
                        "cpf" => ["required", "cpf"],
                        "address" => "nullable|array|size:6",
                        "address.cep" => ["required", "formato_cep"],
                        "address.state" => ["required", "uf", "string", "size:2"],
                        "address.district" => ["required", "string"],
                        "address.street" => ["required", "string"],
                        "address.number" => ["required", "integer"],
                        "address.complement" => ["nullable"]
                    ];
                }
            default:
            break;
        }
    }
}
