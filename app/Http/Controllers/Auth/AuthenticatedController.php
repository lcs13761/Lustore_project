<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedController extends Controller
{
    public function AuthenticatedController(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email e/ou senha invalido!'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => $user,
        ]);

        // if (!$token) {
        //     $this->response["error"] = "";
        //     return Response()->json($this->response, 401);
        // }

        // $user = User::find(auth()->user()->id);
        // $this->response["verifiedEmail"] = $user->hasVerifiedEmail() ? "true" : "false";
        // $this->response["token"] = $token;
        // $this->response["name"] = auth()->user()->name;
        // $this->response["id"] = auth()->user()->id;
        // $this->response["level"] = auth()->user()->level;
        // return $this->response;
    }

    public function destroy(Request $request)
    {

    }

    public function unauthenticated()
    {

    }
}