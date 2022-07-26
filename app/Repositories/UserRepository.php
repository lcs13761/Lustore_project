<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    protected $entity;

    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    /**
     * Get all Products
     * @return array
     */
    public function getAllUser()
    {
        return $this->entity->with('address')->paginate();
    }

    /**
     * Seleciona o Produto por ID
     * @param int $id
     * @return object
     */
    public function getUserById(int $id)
    {
        return $this->entity->where('id', $id)->with('address')->first();
    }

    /**
     * Cria um novo Produto
     * @param User $user
     * @return User
     */
    public function createUser(array $user)
    {
        return $this->entity->create($user);
    }

    /**
     * Atualiza um produto
     * @param User $user
     * @param int
     */
    public function updateUser(User $user, array $data)
    {
        return $user->update($data);
    }

    /**
     * Deleta um produto
     * @param User $user
     */
    public function destroyUser(User $user)
    {
        return $user->delete();
    }

    /**
     * Undocumented function
     *
     * @param object $user
     * @return void
     */
    public function updateOrCreateAdressRelationShip(object $user, array $data)
    {
        $user->address()->updateOrCreate($data);
    }
}
