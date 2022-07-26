<?php

namespace App\Services\Category;

use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Selecione todas as categorias
     * @return array
    */
    public function all()
    {
        return $this->categoryRepository->getAllCategories();
    }

    /**
     * Seleciona uma categoria pelo ID
     * @param int $id
     * @return object
    */
    public function find(int $id)
    {
        return $this->categoryRepository->getCategoryById($id);
    }

    /**
     * Cria uma nova categoria
     * @param  $request
     * @return object
    */
    public function create($request)
    {
        return $this->categoryRepository->createCategory($request->safe()->all());
    }

    /**
     * Atualiza uma categoria
     * @param int $id
     * @param $categorie
     * @return
    */
    public function update(int $id, $request)
    {
        $category = $this->categoryRepository->getCategoryById($id);
        $this->categoryRepository->updateCategory($category, $request->all());
    }

    /**
     * Deleta uma categoria
     * @param int $id
     * @return
    */
    public function destroy(int $id)
    {
        $category = $this->categoryRepository->getCategoryById($id);
        $this->categoryRepository->destroyCategory($category);

    }
}
