<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Traits\HandlerImages;

class CategoryService
{
    use HandlerImages;

    protected $categoryRepository;
    protected $folder = "category";

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
     * Undocumented function
     *
     * @return
     */
    public function uploadFile($request, $id = null)
    {
        $category = !$id ? null : $this->find($id);

        $upload = $this->upload($request->file('image'), $category?->image);

        return collect($request->validated())->replace(['file' => $upload->saveIn()]);
    }

    /**
     * Cria uma nova categoria
     * @param  $request
     * @return object
     */
    public function create($request)
    {
        return $this->categoryRepository->create($this->data($request));
    }

    /**
     * Atualiza uma categoria
     * @param int $id
     * @param $categorie
     * @return
     */
    public function update(int $id, $request)
    {
        $this->categoryRepository->update($this->find($id), $this->data($request));
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return array
     */
    private function data($request): array
    {
        return [
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'active' => $request->get('active'),
            'parent_id' => $request->get('parent_id'),
            'image' => $request->get('image'),
        ];
    }

    /**
     * Deleta uma categoria
     * @param int $id
     * @return
     */
    public function destroy(int $id)
    {
        $this->categoryRepository->delete($this->find($id));
    }
}
