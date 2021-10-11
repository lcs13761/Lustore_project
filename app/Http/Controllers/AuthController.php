<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    private array $response = ["error" => '', "result" => []];

    public function forgotPassword(Request $request){
            $request->validate(["email" => "required|email"]);

            $status = Password::sendResetLink(
                $request->only('email')
            ); 

            if($status === Password::RESET_LINK_SENT){
                $this->response["result"] = "Email enviado com sucesso.";
                return Response()->json($this->response, 200);
            }
            if($status === Password::INVALID_USER){
                $this->response["error"] = "Email não encontrado.";
                return Response()->json($this->response, 203);
            }

            if($status === Password::RESET_THROTTLED){
                $this->response["error"] = "Error, tente novamente mais tarde.";
                return Response()->json($this->response, 500);
            }
        
            return $status;
    }

    public function changePassword(Request $request){
        
        $request->validate([
            "token" => "required",
            "email" => "required",
            "password" => "required",
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
        
        if($status === Password::PASSWORD_RESET){
          return redirect()->route("home");
        }

        return $status;
    }

    public function login(Request $request)
    {
        $Validator  = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required"
        ]);

        if ($Validator->fails()) {
            $this->response["error"] = "campos invalidos";
            return Response()->json($this->response, 400);
        }

        $email = filter_var($request->input("email"), FILTER_VALIDATE_EMAIL);
        $password = $request->input('password');

        $token = Auth::attempt([
            'email' => $email,
            'password' => $password
        ]);

        if (!$token) {
            $this->response["error"] = "Email e/ou senha invalido!";
            return Response()->json($this->response, 401);
        }

        $this->response["token"] = $token;
        $this->response["level"] = auth()->user()->level;
        return $this->response;
    }

    public function logout()
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
        try {
            $token = Auth::refresh();
            return response()->json($token, 200);
        } catch (\Exception $e) {
            return response()->json($e, 401);
        }
    }

    public function unauthenticated()
    {
        $this->response["error"] = "Não autorizado";
        return response()->json($this->response, 401);
    }
}
