<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    /**
     *
     * @return mixed
     */
    public function all(): mixed
    {
        return $this->userRepository->all();
    }

    public function query($request): LengthAwarePaginator
    {
        return $this->userRepository->query($request);
    }

    /**
     *
     * @param integer $id
     * @return mixed
     */
    public function find(int $id): mixed
    {
        return $this->userRepository->find($id);
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return User
     */
    public function create($request): User
    {
        $user = $this->userRepository->create($request->safe()->all());

        $this->HandleAddress($user, $request->address);

        return $user;
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @param integer $id
     * @return void
     */
    public function update($request, int $id): void
    {
        $user = $this->find($id);
        $this->userRepository->update($user, $request->safe()->all());
        !$request->input('address') ?: $this->HandleAddress($user, $request->address);
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $user = $this->find($id);

        $this->userRepository->delete($user);
    }

    /**
     * Undocumented function
     *
     * @param $user
     * @param $address
     * @return void
     */
    public function HandleAddress($user, $address): void
    {
        $data = array(["user_id" => $user->id], $address);

        $this->userRepository->updateOrCreateAdressRelationShip($user, $data);
    }
}
