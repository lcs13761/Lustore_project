<?php

namespace App\Services\Category;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Traits\HandlerImages;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    use HandlerImages;

    protected string $folder = "category";

    public function __construct(private readonly CategoryRepositoryInterface $categoryRepository)
    {
    }

    /**
     * Selecione todas as categorias
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->categoryRepository->all();
    }

    public function paginate($request): LengthAwarePaginator
    {
        return $this->categoryRepository->paginate($request);
    }

    /**
     * Seleciona uma categoria pelo ‘ID’
     * @param int $id
     * @return object
     */
    public function find(int $id): object
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * Undocumented function
     *
     * @param $request
     * @param null $id
     * @return \Illuminate\Support\Collection
     */
    public function uploadFile($request, $id = null): \Illuminate\Support\Collection
    {
        $category = !$id ? null : $this->find($id);

        $upload = $this->upload($request->file('image'), $category?->image);

        return collect($request->validated())->replace(['file' => $upload->saveIn()]);
    }

    /**
     * Cria uma categoria
     * @param  $request
     * @return object
     */
    public function create($request): object
    {
        return $this->categoryRepository->create($this->data($request));
    }

    /**
     * Atualiza uma categoria
     * @param int $id
     * @param $request
     * @return void
     */
    public function update(int $id, $request): void
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
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $this->categoryRepository->delete($this->find($id));
    }
}
