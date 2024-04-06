<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserCollection;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return (new UserCollection($this->userService->query($request)))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return JsonResponse
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $user = $this->userService->create($request);

        event(new Registered($user));

        return response()->json(['result' => __('locale.email_confirmed')]);
    }

    /**
     * Display the specified resource.
     *
     * @param int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
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

        return response()->json(['result' => __('locale.message_update')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int  $id): JsonResponse
    {
        $this->userService->destroy($id);

        return response()->json(['result' => __('locale.message_delete')]);
    }
}
