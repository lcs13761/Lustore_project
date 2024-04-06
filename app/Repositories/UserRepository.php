<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends AbstractEloquentRepository implements UserRepositoryInterface
{
    protected User $entity;

    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    /**
     * @param $request
     * @return LengthAwarePaginator
     */
    public function query($request): LengthAwarePaginator
    {
        return $this->entity->query()->paginate($request->get('limit', 10));
    }

    /**
     * Undocumented function
     *
     * @return Collection
     */
    public function getAllWithAddresses(): Collection
    {
        return $this->entity->with('address')->get();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return object
     */
    public function findWithAdresses(int $id): object
    {
        return $this->entity->with('address')->find($id);
    }

    /**
     * Undocumented function
     *
     * @param object $user
     * @param array $data
     * @return void
     */
    public function updateOrCreateAdressRelationShip(object $user, array $data): void
    {
        $user->address()->updateOrCreate($data);
    }
}
