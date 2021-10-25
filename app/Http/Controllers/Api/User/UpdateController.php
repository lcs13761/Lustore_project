<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;

class UpdateController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            "id" => "required",
            "address" => []
        ]);

        $user = User::find($request->input("id"));
        if ($user->email != $request->email) {

            $email = User::where("email", $request->email)->count();
            if ($email != 0) {
                $this->response["result"] = "Email ja registrado.";
                return Response()->json($this->response, 400);
            }
        }

        $user->photo = $request->photo ?? $user->photo;
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->cpf = $request->cpf ?? $user->cpf;
        $user->phone = $request->phone ?? $user->phone;
        $user->save();
        $this->address($user, $request);
        $this->response["result"] = "Informação modificadas com sucesso.";
        return Response()->json($this->response, 400);
    }

    private function address(User $user, $request)
    {

        if (empty($request->address)) {
            return;
        }
        foreach ($request->address as $address) {
            $verifyAddress = Address::where("cep", $request->cep)->where("user_id", $user->id)->exists();
            if ($verifyAddress) {
                $address = (object)$address;
                $updateAddress = Address::where("cep", $address->cep)->first();
                $updateAddress->cep = $address->cep;
                $updateAddress->state = $address->state ?? $updateAddress->state;
                $updateAddress->district = $address->district ?? $updateAddress->district;
                $updateAddress->street = $address->street ?? $updateAddress->street;
                $updateAddress->number = $address->number ?? $updateAddress->number;
                $updateAddress->complement = $address->complement ?? $updateAddress->complement;
                $updateAddress->save();
            } else {
                $this->createAddress($user, $address);
            }
        }
    }

    private function createAddress(User $user, $address)
    {
        $address = (object)$address;
        $user->address()->create([
            "cep" => $address->cep,
            "state" => $address->state,
            "district" => $address->district,
            "street" => $address->street,
            "number" => $address->number,
            "complement" => $address->complement ?? null,
        ]);
    }
}
