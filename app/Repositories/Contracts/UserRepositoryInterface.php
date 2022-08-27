<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all();
    public function getAllWithAddresses();
    public function find(int $id);
    public function findWithAdresses(int $id);
    public function create(array $data);
    public function update(object $entity, array $data);
    public function delete(object $entity);
    public function updateOrCreateAdressRelationShip(User $user, array $data);
}
