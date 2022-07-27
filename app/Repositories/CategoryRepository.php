<?php

namespace App\Repositories;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository extends AbstractEloquentRepository implements CategoryRepositoryInterface
{
    protected $entity;

    public function __construct(Category $category)
    {
        $this->entity = $category;
    }

     /**
     * Undocumented function
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllWithProducts()
    {
        return $this->entity->with('products')->get();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return mixed
     */
    public function findWithProducts(int $id)
    {
        return $this->entity->with('products')->find($id);
    }

}
