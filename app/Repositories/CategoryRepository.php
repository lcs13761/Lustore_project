<?php

namespace App\Repositories;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends AbstractEloquentRepository implements CategoryRepositoryInterface
{
    protected Category $entity;

    public function __construct(Category $category)
    {
        $this->entity = $category;
    }

    public function paginate($request): LengthAwarePaginator
    {
        return $this->entity->query()->paginate($request->get('limit', 10));
    }

    /**
     * Undocumented function
     *
     * @return Collection
     */
    public function getAllWithProducts(): Collection
    {
        return $this->entity->with('products')->get();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return Category|null
     */
    public function findWithProducts(int $id): ?Category
    {
        return $this->entity->with('products')->find($id);
    }

}
