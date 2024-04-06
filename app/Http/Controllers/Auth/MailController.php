<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public array $response = ["error" => '', "result" => []];

    public function verifyEmail($id, $hash)
    {

    }

    public function resendVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        $this->response["result"] = "Email enviado";
        return Response()->json($this->response, 200);

    }
}