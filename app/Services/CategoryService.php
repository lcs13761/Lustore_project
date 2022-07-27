<?php

namespace App\Services;

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
        return $this->categoryRepository->all();
    }

    /**
     * Seleciona uma categoria pelo ID
     * @param int $id
     * @return object
    */
    public function find(int $id)
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * Cria uma nova categoria
     * @param  $request
     * @return object
    */
    public function create($request)
    {
        return $this->categoryRepository->create($request->safe()->all());
    }

    /**
     * Atualiza uma categoria
     * @param int $id
     * @param $categorie
     * @return
    */
    public function update(int $id, $request)
    {
        $category = $this->find($id);
        $this->categoryRepository->update($category, $request->all());
    }

    /**
     * Deleta uma categoria
     * @param int $id
     * @return
    */
    public function destroy(int $id)
    {
        $category = $this->find($id);
        $this->categoryRepository->delete($category);

    }
}
