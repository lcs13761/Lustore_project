<?php

namespace App\Services\Product;

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

    public function update($request, $id)
    {
        $this->find($id)->update($request->all());
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
