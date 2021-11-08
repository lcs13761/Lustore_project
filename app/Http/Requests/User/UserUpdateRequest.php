<?php

namespace App\Http\Requests\User;

use Error;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\throwException;

class UserUpdateRequest extends FormRequest
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
            "photo" => ["nullable", "file"],
            "name" => ["required", "string"],
            "email" => ["required", "email:rfc,dns", "unique:users,email," . Auth::user()->id . ",id"],
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

 
}
