<?php

namespace App\Services;

use App\Models\Product;
use App\Traits\HandlerImages;

class ProductService
{
    use HandlerImages;

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product->with(["image", "category"]);
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function all()
    {
        return $this->product->get();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->product->find($id);
    }

    public function create($request)
    {
        return $this->product->create($this->data($request));
    }

    public function update()
    {
    }

    public function delete()
    {
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
            "code" => $request->get('code'),
            "product" => $request->get('product'),
            "category_id" => $request->get('category.id'),
            "saleValue" => $request->get('saleValue'),
            "costValue" => $request->get('costValue'),
            "size" => $request->get('size'),
            "qts" => $request->get('qts'),
            "description" => $request->get('description')
        ];
    }

    private function handlerImagesUpload(array $images)
    {
    }
}
