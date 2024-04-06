<?php

namespace App\Repositories;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends AbstractEloquentRepository implements ProductRepositoryInterface
{
    protected Product $entity;

    public function __construct(Product $product)
    {
        $this->entity = $product;
    }

    /**
     * Undocumented function
     *
     * @param object $product
     * @param array $images
     * @return mixed
     */
    public function createManyImages(object $product, array $images): mixed
    {
       return $product->images()->createMany($images);
    }

    public function paginate($request): LengthAwarePaginator
    {
        return $this->entity->query()->paginate($request->get('limit', 10));
    }

    /**
     * Undocumented function
     *
     */
    public function getAllWithCategory(): array|Collection
    {
        return $this->entity->with('category')->get();
    }

    /**
     * Undocumented function
     *
     * @return array|Collection
     */
    public function getAllWithImages(): array|Collection
    {
        return $this->entity->with('images')->get();
    }

    /**
     * Undocumented function
     *
     * @return array|Collection
     */
    public function getAllWith(): array|Collection
    {
        return $this->entity->with(['category', 'images'])->get();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return Product|null
     */
    public function findWith(int $id): ?Product
    {
        return $this->entity->with(['category','images' ])->find($id);
    }
}
