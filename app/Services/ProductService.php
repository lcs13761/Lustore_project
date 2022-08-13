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
     * @return Illuminate\Http\JsonResponse|Illuminate\Http\Response
     */
    public function create($request)
    {
        $product = $this->productRepository->create($this->data($request));

        $images = $this->handlerDataImage($request->get('images'));

        $this->productRepository->createManyImages($product, $images);

        response()->json(['sucess' => '']);
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @param [type] $id
     * @return  Illuminate\Http\JsonResponse|Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        $product = $this->findWith($id);

        $this->productRepository->update($this->find($id), $this->data($request));

        $this->syncImages($product, $request->get('images', []));

        response()->json(['sucess' => '']);
    }

    private function handlerDataImage($images)
    {
        return collect($images)->map(fn ($data) => ['image' => $data])->all();
    }

    /**
     * Undocumented function
     *
     * @param [type] $product
     * @param [type] $request
     * @return void
     */
    public function syncImages($product, $images)
    {
        foreach ($product->images as $index => $image) {

            $filterVerfiy = collect($images)->filter(fn ($data) => $image->image === $data);

            if ($filterVerfiy->isEmpty()) {

                !empty($images[$index]) ? $this->updataImage($image, $images[$index]) :  $this->imageRepository->delete($image);

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
    private function updataImage($entity, $image)
    {
        $this->imageRepository->update($entity, ['image' => $image]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function delete($id)
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
     * @return void
     */
    private function removeImages($images)
    {
        collect($images)->each(fn ($image) => $this->delete($image->image));
    }
}
