
<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getAllUser();
    public function getUserById(int $id);
    public function createUser(array $user);
    public function updateUser(User $user, array $data);
    public function destroyUser(User $user);
    public function updateOrCreateAdressRelationShip(User $user, array $data);
}
