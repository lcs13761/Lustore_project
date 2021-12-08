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
                    "password" => ["required","confirmed", Password::min(8)->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()],
                    "address" => "nullable|array",
                        "address.cep" => ["nullable", "formato_cep"],
                        "address.city" => ["nullable", "string"],
                        "address.state" => ["nullable", "uf", "string", "size:2"],
                        "address.district" => ["nullable", "string"],
                        "address.street" => ["nullable", "string"],
                        "address.number" => ["nullable", "integer"],
                        "address.complement" => ["nullable"]
                ];
            }
            case 'PUT': 
                case 'PATCH' : {
                    return [
                        "photo" => ["nullable", "file"],
                        "name" => ["required", "string"],
                        "email" => ["required", "email:rfc,dns", "unique:users,email," .$this->route('user')->id  . ",id"],
                        "current_password" => ["nullable", "current_password:api"],
                        "password" => ["nullable", "confirmed", Password::min(8)->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()],
                        "address" => "nullable|array",
                        "address.cep" => ["nullable", "formato_cep"],
                        "address.city" => ["nullable", "string"],
                        "address.state" => ["nullable", "uf", "string", "size:2"],
                        "address.district" => ["nullable", "string"],
                        "address.street" => ["nullable", "string"],
                        "address.number" => ["nullable", "integer"],
                        "address.complement" => ["nullable"]
                    ];
                }
            default:
            break;
        }
    }

    public function messages(){

        return [
            'password.min' => 'A senha deve conter no minimo 8 caracteres',
        ];
    }
}
