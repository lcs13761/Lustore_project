<?php

namespace App\Repositories\Contracts;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function all();
    public function getAllWithProducts();
    public function find(int $id);
    public function findWithProducts(int $id);
    public function create(array $data);
    public function update(object $entity, array $data);
    public function delete(object $entity);
}
