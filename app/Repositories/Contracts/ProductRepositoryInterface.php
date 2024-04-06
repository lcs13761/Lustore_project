<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function all();
    public function getAllWithCategory();
    public function getAllWithImages();
    public function getAllWith();
    public function find(int $id);
    public function paginate($request): LengthAwarePaginator;
    public function findWith(int $id);
    public function create(array $data);
    public function createManyImages(object $product, array $images);
    public function update(object $entity, array $data);
    public function delete(object $entity);
}
