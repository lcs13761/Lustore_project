<?php

namespace App\Repositories;

abstract class AbstractEloquentRepository
{
    /**
     * Undocumented function
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->entity->all();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function find(int $id)
    {
        return $this->entity->find($id);
    }

    /**
     * Undocumented function
     *
     * @param array $data
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    /**
     * Undocumented function
     *
     * @param [type] $entity
     * @param [type] $data
     * @return mixed
     */
    public function update($entity, $data)
    {
        return $entity->update($data);
    }

    /**
     * Undocumented function
     * @param [type] $entity
     * @return mixed
     */
    public function delete($entity)
    {
        return $entity->delete();
    }
}
