<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $token = Auth::attempt($request->all());

        if (!$token) {
            $this->response["error"] = "Email e/ou senha invalido!";
            return Response()->json($this->response, 401);
        }

        $user = User::find(auth()->user()->id);
        $this->response["verifiedEmail"] = $user->hasVerifiedEmail() ? "true" : "false";
        $this->response["token"] = $token;
        $this->response["level"] = auth()->user()->level;
        return $this->response;
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            $this->response["result"] =  "voce saiu com sucesso";
            return Response()->json($this->response, 200);
        }
        $this->response["error"] = "erro ao deslogar";
        return Response()->json($this->response, 400);
    }

    public function refresh()
    {

        try {
            $this->response["result"] = Auth::refresh();
            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response["error"] = "Error ao gerar o token.";
            return response()->json($this->response, 500);
        }
    }

    public function unauthenticated()
    {
        $this->response["error"] = "Não autorizado";
        return response()->json($this->response, 401);
    }
}
