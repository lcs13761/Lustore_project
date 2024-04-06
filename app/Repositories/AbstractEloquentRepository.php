<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

abstract class AbstractEloquentRepository
{
    /**
     * Undocumented function
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->entity->all();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return Object|null
     */
    public function find(int $id): ?Object
    {
        return $this->entity->find($id);
    }

    /**
     * Undocumented function
     *
     * @param array $data
     * @return Object|null
     */
    public function create(array $data): ?Object
    {
        return $this->entity->create($data);
    }

    /**
     * Undocumented function
     *
     * @param [type] $entity
     * @param [type] $data
     * @return bool
     */
    public function update($entity, $data): bool
    {
        return $entity->update($data);
    }

    /**
     * Undocumented function
     * @param [type] $entity
     * @return bool
     */
    public function delete($entity): bool
    {
        return $entity->delete();
    }
}
