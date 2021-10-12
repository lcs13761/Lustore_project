<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    private array $response = ["error" => '', "result" => []];
    
    public function create(Request $request)
    {
        $request->validate(
            [
                "name" => "required",
                "email" => "required",
                "password" => "required"
            ]
        );

        $email = User::where("email", $request->email)->count();
        if($email != 0){
            $this->response["result"] = "Email ja registrado.";
            return Response()->json($this->response, 400);
        }

        $createUser =  User::create([
            'name' => $request->input("name"),
            'email' => $request->input("email"),
            'password' => Hash::make($request->input("password"))]);

            

        event(new Registered($createUser));
    
        $this->response["result"] = "Usuario criado com sucesso.";
        return Response()->json($this->response, 200);


    }
    public function update()
    {
    }
}
