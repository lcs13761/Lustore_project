<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function all()
    {
        return $this->userRepository->getAllUser();
    }

    /**
     *
     * @param integer $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->userRepository->getUserById($id);
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return User
     */
    public function create($request)
    {
        $user = $this->userRepository->createUser($request->safe()->all());
        !$request->input('address') ?: $this->HandleAddress($user, $request->address);
        return $user;
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @param integer $id
     * @return mixed
     */
    public function update($request, int $id)
    {
        $user = $this->userRepository->getUserById($id);
        $this->userRepository->updateUser($user, $request->safe()->all());
        !$request->input('address') ?: $this->HandleAddress($user, $request->address);
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id)
    {
        $user = $this->userRepository->getUserById($id);
        $this->userRepository->destroyUser($user);
    }

    /**
     * Undocumented function
     *
     * @param [type] $address
     * @return void
     */
    public function HandleAddress($user, $address)
    {
        $data = array(["user_id" => $user->id], $address);
        $this->userRepository->updateOrCreateAdressRelationShip($user, $data);
    }
}
