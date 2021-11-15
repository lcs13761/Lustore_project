<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmail extends Controller
{

    /**
     * @throws \Exception
     */
    public function verificationEmail(Request $request, $id, $hash): Factory|View|Application
    {
        $request = Request::create("/api/verification/{$id}/{$hash}",'GET');

        app()->handle($request);
        return view("web.auth-verify-email",[
            "value" => (object)[
                "title" => "Muito Obrigado!",
                "desc" => "Seu e-mail foi confirmado com sucesso.",
                "image" => "storage/images/optin-success.svg",
            ],
        ]);
    }
}
