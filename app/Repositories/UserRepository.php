<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends AbstractEloquentRepository implements UserRepositoryInterface
{
    protected $entity;

    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    /**
     * Undocumented function
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWithAddresses()
    {
        return $this->entity->with('address')->get();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return object
     */
    public function findWithAdresses(int $id)
    {
        return $this->entity->with('address')->find($id);
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
