<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

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
        $id = request()->route('user');

        return [
            "photo" => ["nullable", "file"],
            "name" => ["required", "string"],
            "email" => ["required", "email", "unique:users,email,$id"],
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

    public function messages()
    {
        return [
            'password.min' => 'A senha deve conter no minimo 8 caracteres',
        ];
    }
}
