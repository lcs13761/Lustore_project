<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class PasswordController extends Controller
{
    public function forgotPassword(Request $request): JsonResponse|string
    {
        $request->validate(["email" => "required|email"]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        if ($status === Password::RESET_LINK_SENT) {
            $this->response["result"] = "Email enviado com sucesso.";
            return Response()->json($this->response, 200);
        }
        if ($status === Password::INVALID_USER) {
            $this->response["error"] = "Email não encontrado.";
            return Response()->json($this->response, 203);
        }
        if ($status === Password::RESET_THROTTLED) {
            $this->response["error"] = "Error, tente novamente mais tarde.";
            return Response()->json($this->response, 500);
        }
        return $status;
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            "token" => "required",
            "email" => "required",
            "password" => "required",
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route("home");
        }
        return $status;
    }
}
