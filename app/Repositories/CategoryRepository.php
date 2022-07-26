<?php

namespace App\Repositories;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $entity;

    public function __construct(Category $category)
    {
        $this->entity = $category;
    }

    /**
     * Get all Categories
     * @return array
     */
    public function getAllCategories()
    {
        return $this->entity->paginate();
    }

    /**
     * Seleciona a Categoria por ID
     * @param int $id
     * @return object
     */
    public function getCategoryById(int $id)
    {
        return $this->entity->where('id', $id)->with('products')->first();
    }

    /**
     * Cria uma nova categoria
     * @param array $data
     * @return object
     */
    public function createCategory(array $data)
    {
        return $this->entity->create($data);
    }

    /**
     * Atualiza os dados da categoria
     * @param object $category
     * @param array $data
     * @return object
     */
    public function updateCategory(object $category, array $data)
    {
        return $category->update($data);
    }

    /**
     * Deleta uma categoria
     * @param object $category
     */
    public function destroyCategory(object $category)
    {
        return $category->delete();
    }
}
