<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    private array $response = ["error" => '', "result" => []];

    public function __construct()
    {
        $this->middleware("auth:api", ['except' => ["create", "login","loginAdmin", "unauthenticated", "refresh"]]);
    }



    public function login(Request $request)
    {

        $Validator  = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required"
        ]);

        if ($Validator->fails()) {
            $this->response["error"] = "campos invalidos";
            return $this->response;
        }

        $email = $request->input('email');
        $password = $request->input('password');

        $token = Auth::attempt([
            'email' => $email,
            'password' => $password
        ]);

        if (!$token) {
            $this->response["error"] = "Usuario e/ou senha invalidos!";
            return $this->response;
        }

        $this->response["token"] = $token;

        return $this->response;
    }

    
    public function loginAdmin(Request $request)
    {

        $Validator  = Validator::make($request->all(), [
            "token" => "required",
        ]);

        if ($Validator->fails()) {
            $this->response["error"] = "campos invalidos";
            return $this->response;
        }

        $permission = (new DecodeJwt())->decode($request->input("token"));
        if ($permission != "admin") {
            $this->response["error"] = "Não autorizado";
            return Response()->json($this->response, 401);
        }

        $email ="lcs13761@hotmail.com";
        $password = "0131280997Lc";

        $token = Auth::attempt([
            'email' => $email,
            'password' => $password
        ]);

        if (!$token) {
            $this->response["error"] = "Usuario e/ou senha invalidos!";
            return $this->response;
        }

        $this->response["token"] = $token;

        return $this->response;
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $this->response["error"] = "voce saiu com sucesso";
            return Response()->json($this->response, 200);
        }

        $this->response["error"] = "erro ao deslogar";
        return Response()->json($this->response, 200);
    }

    public function refresh()
    {
        try{
            $token = Auth::refresh();
            return response()->json($token, 200);
        }catch(\Exception $e){
            return response()->json($e, 401);
        }
        // $token = Auth::refresh();
        // if (!$token) {
        //     $this->response["error"] = "error ao fazer o refresh";
        //     return Response()->json($this->response, 401);
        // }
    
        // $this->response["token"] = $token;
        // return Response()->json($this->response, 200);
    }

    public function unauthenticated()
    {
        $this->response["error"] = "Não autorizado";
        return response()->json($this->response, 401);
    }
}
