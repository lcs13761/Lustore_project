<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware("auth:api",["except" => "store"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = User::with('address');
        return response()->json($user->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse|Response
     */
    public function store(UserRequest $request): Response|JsonResponse
    {
        $created = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            'level' => $request->level
            
        ]);
        if (!empty($request->address) && is_array($request->address))$created->address()->create($request->address);
        event(new Registered($created));
        $this->response["result"] = "Verifique sua caixa de email para confirmar a sua conta.";
        return response()->json($this->response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {   
            $this->userValidate($user->id);
            return response()->json($user->loadMissing('address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse|Response
     */
    public function update(UserRequest $request, User $user): Response|JsonResponse
    {
        $this->userValidate($user->id);

        $user->update($request->except(["address","level"]));
        if (!empty($request->address)) $user->address()->updateOrCreate(["user_id" => $user->id], $request->address);
        $this->response["result"] = "Usuario modificado om sucesso.";
        return response()->json($this->response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        //
    }
}
