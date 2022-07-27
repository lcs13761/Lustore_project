<?php

namespace App\Repositories\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function all();
    public function getAllWithCategory();
    public function getAllWithImages();
    public function getAllWith();
    public function find(int $id);
    public function findWithCategory(int $id);
    public function findWithImages(int $id);
    public function findWith(int $id);
    public function create(array $data);
    public function update(object $entity, array $data);
    public function delete(object $entity);
}
