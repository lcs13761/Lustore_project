<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ImageRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Traits\HandlerImages;

class ProductService
{
    use HandlerImages;

    private $productRepository;
    private $imageRepository;

    public function __construct(ProductRepositoryInterface $productRepository, ImageRepositoryInterface $imageRepository)
    {
        $this->productRepository = $productRepository;
        $this->imageRepository = $imageRepository;
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function all()
    {
        return $this->productRepository->all();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->productRepository->find($id);
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return mixed
     */
    public function findWith(int $id)
    {
        return $this->productRepository->findWith($id);
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return
     */
    public function create($request)
    {
        return $this->productRepository->create($this->data($request));
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
        $this->productRepository->update($this->find($id), $this->data($request));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function delete($id)
    {
        $this->removeImages($id);

        $this->productRepository->delete($this->find($id));
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

    /**
     * Undocumented function
     *
     * @param [type] $product
     * @param [type] $request
     * @return void
     */
    public function handlerImagesUpload($product, $request)
    {
        collect($request->get('images', []))->each(function ($image) use ($product) {

            if ($product->images) {
                collect($product->images)->each(function ($data) use ($image) {
                    $data->image === $image['url'] ?: $this->deleteImage($data->image);
                });
            }

            $this->imageRepository->updateOrCreate(
                ['id' => $image['id']],
                ['image' => $image['url'], 'product_id' => $product->id]
            );
        });
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function removeImages(int $id)
    {
        $images = $this->imageRepository->getAllImageForProduct($id);

        $images->each(fn ($image) => $this->delete($image));
    }
}
