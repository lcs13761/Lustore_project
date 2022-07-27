<?php

namespace App\Repositories;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository extends AbstractEloquentRepository implements ProductRepositoryInterface
{

    protected $entity;

    public function __construct(Product $product)
    {
        $this->entity = $product;
    }

    /**
     * Undocumented function
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllWithCategory()
    {
        return $this->entity->with('category')->get();
    }

    /**
     * Undocumented function
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllWithImages()
    {
        return $this->entity->with('images')->get();
    }

    /**
     * Undocumented function
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllWith()
    {
        return $this->entity->with(['category', 'images'])->get();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return mixed
     */
    public function findWithCategory(int $id)
    {
        return $this->entity->with('category')->find($id);
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return mixed
     */
    public function findWithImages(int $id)
    {
        return $this->entity->with('images')->find($id);
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return mixed
     */
    public function findWith(int $id)
    {
        return $this->entity->with(['category', 'images'])->find($id);
    }
}
