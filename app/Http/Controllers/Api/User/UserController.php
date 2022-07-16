<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Services\Api\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Auth\Events\Registered;


class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->userService->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return JsonResponse|Response
     */
    public function store(UserStoreRequest $request): Response|JsonResponse
    {
        $user = $this->userService->create($request);

        event(new Registered($user));

        return response()->json(['result' => __('locale.email_confirmed')], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int  $id
     * @return Response
     */
    public function show(int $id)
    {
        return response()->json($this->userService->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param int  $id
     * @return JsonResponse|Response
     */
    public function update(UserUpdateRequest $request, int $id): Response|JsonResponse
    {
        $this->userService->update($request, $id);

        return response()->json(['result' => __('locale.message_update')], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int  $id)
    {
        $this->userService->destroy($id);

        return response()->json(['result' => __('locale.message_delete')], 200);
    }
}
