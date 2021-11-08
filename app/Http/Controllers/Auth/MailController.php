<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public array $response = ["error" => '', "result" => []];

    public function verifyEmail($id,$hash){

        $user = User::find($id);
        
        abort_if(!$user,403);
        abort_if(!hash_equals($hash,sha1($user->getEmailForVerification())),403);

        if(!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        $this->response["result"] = "Email verificado";
        return Response()->json($this->response, 200);
        
    }

    public function resendVerification(Request $request){
        $request->user()->sendEmailVerificationNotification();

        $this->response["result"] = "Email enviado";
        return Response()->json($this->response, 200);
        
    }
}
