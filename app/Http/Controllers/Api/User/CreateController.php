<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class CreateController extends Controller
{
    public function index(Request $request)
    {

        $request->validate(
            [
                "name" => "required",
                "email" => "required|email:rfc,dns",
                "password" => "required"
            ]
        );

        $email = User::where("email", $request->email)->exists();
        if ($email) {
            $this->response["result"] = "Email ja registrado.";
            return Response()->json($this->response, 400);
        }

        $createUser =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($createUser));

        $this->response["result"] = "Usuario criado com sucesso.";
        return Response()->json($this->response, 200);
    }
}
