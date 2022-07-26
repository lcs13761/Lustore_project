<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Traits\HandlerImages;

class ProductService
{
    use HandlerImages;

    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function all()
    {
        return $this->productRepository->getAllProducts();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->productRepository->getProductById($id);
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return void
     */
    public function create($request)
    {
        return $this->productRepository->createProduct($this->data($request));
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @param [type] $id
     * @return void
     */
    public function update($request, $id)
    {
        $product = $this->productRepository->getProductById($id);
        $this->productRepository->updateProduct($product,$this->data($request));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function delete($id)
    {
        $product = $this->productRepository->getProductById($id);
        $this->productRepository->destroyProduct($product);
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return array
     */
    private function data($request): array
    {
        $data = [
            "code_product" => $request->get('code_product'),
            'barcode' => $request->get('barcode'),
            "product" => $request->get('product'),
            "category_id" => $request->get('category'),
            "saleValue" => $request->get('saleValue'),
            "costValue" => $request->get('costValue'),
            "size" => $request->get('size'),
            "qts" => $request->get('qts'),
            "description" => $request->get('description')
        ];

        return array_filter($data);
    }

    private function handlerImagesUpload(array $images)
    {
    }
}
