<?php

namespace App\Repositories\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function getAllProducts();
    public function getProductById(int $id);
    public function createProduct(array $product);
    public function updateProduct(Product $product, array $data);
    public function destroyProduct(Product $product);
}
