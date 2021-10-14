<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
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
        if ($email != 0) {
            $this->response["result"] = "Email ja registrado.";
            return Response()->json($this->response, 400);
        }

        $createUser =  User::create([
            'name' => $request->input("name"),
            'email' => $request->input("email"),
            'password' => Hash::make($request->input("password"))
        ]);

        event(new Registered($createUser));

        $this->response["result"] = "Usuario criado com sucesso.";
        return Response()->json($this->response, 200);
    }

    public function update(Request $request)
    {
        $request->validate(
            ["id" => "required"]
        );

        $user = User::find($request->input("id"));
        if ($user->email != $request->email) {

            $email = User::where("email", $request->email)->count();
            if ($email != 0) {
                $this->response["result"] = "Email ja registrado.";
                return Response()->json($this->response, 400);
            }
        }

        $this->updateUser($user,$request);
        $this->response["result"] = "Informação modificadas com sucesso.";
        return Response()->json($this->response, 400);


    }
    private function updateUser(User $user, $request){
        
        $user->photo = $request->photo;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cpf = $request->cpf;
        $user->phone = $request->phone;
        $user->save();
        $this->updateAddress($user,$request);
        return $user;
        

    }

    private function createAddress($user,$address){
        $address = (object)$address;
        $createAddress = new Address();
        $createAddress->cep = $address->cep;
        $createAddress->state = $address->state ?? null;
        $createAddress->district = $address->district ?? null;
        $createAddress->street = $address->street ?? null;
        $createAddress->number = $address->number ?? null;
        $createAddress->complement = $address->complement ?? null;
        $createAddress->address_user = $user->id;
        $createAddress->save();
    }

    private function updateAddress($user,$request){


        foreach($request->address as $address){
            
            if($address["id"] == null){
                $this->createAddress($user,$address);
            }else{
                $address = (object)$address;
                $updateAddress = Address::where("id",$address->id)->first();
                $updateAddress->cep = $address->cep;
                $updateAddress->state = $address->state ?? null;
                $updateAddress->district = $address->district ?? null;
                $updateAddress->street = $address->street ?? null;
                $updateAddress->number = $address->number ?? null;
                $updateAddress->complement = $address->complement ?? null;
                $updateAddress->save();
            }
        
        }
    }
}
