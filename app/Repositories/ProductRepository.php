<?php

namespace App\Repositories;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{

    protected $entity;

    public function __construct(Product $product)
    {
        $this->entity = $product;
    }

    /**
     * Get all Products
     * @return array
     */
    public function getAllProducts()
    {
        return $this->entity->with(['category','images'])->paginate();
    }

    /**
     * Seleciona o Produto por ID
     * @param int $id
     * @return object
     */
    public function getProductById(int $id)
    {
        return $this->entity->where('id', $id)->with(['category','images'])->first();
    }

    /**
     * Cria um novo Produto
     * @param array $product
     * @return Product
     */
    public function createProduct(array $product)
    {
        return $this->entity->create($product);
    }

    /**
     * Atualiza um produto
     * @param Product $product
     * @param array $data
     */
    public function updateProduct(Product $product, array $data)
    {
        return $product->update($data);
    }

    /**
     * Deleta um produto
     * @param Product $product
     */
    public function destroyProduct(Product $product)
    {
        return  $product->delete();
    }
}
