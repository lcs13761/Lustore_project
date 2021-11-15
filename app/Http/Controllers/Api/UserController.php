<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        return response()->json(Auth::user());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateRequest $request
     * @return JsonResponse|Response
     */
    public function store(UserCreateRequest $request): Response|JsonResponse
    {
        $created = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        if (!empty($request->address)) {
            if ($request->address) $created->address()->create($request->address);
        }
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
       // return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return JsonResponse|Response
     */
    public function update(UserUpdateRequest $request, User $user): Response|JsonResponse
    {
        $this->userValidate($user->id);
        $request->validated();
        $user->update($request->except(["address","level"]));
        if (!empty($request->address)) {
            if($request->address) $user->address()->updateOrCreate(["user_id" => $user->id], $request->address);
        }
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
