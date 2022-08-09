
<?php

namespace App\Repositories\Contracts;


interface ImageRepositoryInterface
{
    public function all();
    public function getAllWithProduct();
    public function find(int $id);
    public function findWithProduct(int $id);
    public function create(array $data);
    public function update(object $entity, array $data);
    public function delete(object $entity);
    public function getAllImageForProduct(int $id);
    public function updateOrCreate(array $verify, array $data);
}
