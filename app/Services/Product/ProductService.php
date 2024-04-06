<?php

namespace App\Services\Product;

use App\Repositories\Contracts\ImageRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Traits\HandlerImages;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    use HandlerImages;

    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ImageRepositoryInterface $imageRepository
    )
    {
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function all(): mixed
    {
        return $this->productRepository->all();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return mixed
     */
    public function find(int $id): mixed
    {
        return $this->productRepository->find($id);
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return mixed
     */
    public function findWith(int $id): mixed
    {
        return $this->productRepository->findWith($id);
    }

    public function paginate($request): LengthAwarePaginator
    {
        return $this->productRepository->paginate($request);
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     */
    public function create($request): void
    {
        $product = $this->productRepository->create($this->data($request));

        $images = $this->handlerDataImage($request->get('images'));

        $this->productRepository->createManyImages($product, $images);
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @param [type] $id
     */
    public function update($request, $id): void
    {
        $product = $this->findWith($id);

        $this->productRepository->update($this->find($id), $this->data($request));

        $this->syncImages($product, $request->get('images', []));
    }

    private function handlerDataImage($images): array
    {
        return collect($images)->map(fn($data) => ['image' => $data])->all();
    }

    /**
     * Undocumented function
     *
     * @param [type] $product
     * @param [type] $request
     * @return void
     */
    public function syncImages($product, $images): void
    {
        foreach ($product->images as $index => $image) {

            $filterVerfiy = collect($images)->filter(fn($data) => $image->image === $data);

            if ($filterVerfiy->isEmpty()) {

                !empty($images[$index]) ? $this->updataImage($image, $images[$index]) : $this->imageRepository->delete($image);

                $this->deleteImage($image->image);

            } else {
                $key = $filterVerfiy->keys()->first();

                unset($images[$key]);
            }
        }

        $images = $this->handlerDataImage($images);

        $this->productRepository->createManyImages($product, $images);
    }

    /**
     * Undocumented function
     *
     * @param [type] $entity
     * @param [type] $image
     * @return void
     */
    private function updataImage($entity, $image): void
    {
        $this->imageRepository->update($entity, ['image' => $image]);
    }

    /**
     * Undocumented function
     *
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $product = $this->findWith($id);

        $this->removeImages($product->images);

        $this->productRepository->delete($product);
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
     * @param $images
     * @return void
     */
    private function removeImages($images): void
    {
        collect($images)->each(fn($image) => $this->delete($image->image));
    }
}
