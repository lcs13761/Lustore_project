<?php

namespace App\Repositories;

use App\Repositories\Contracts\ImageRepositoryInterface;
use App\Models\Image;

class ImageRepository extends AbstractEloquentRepository implements ImageRepositoryInterface
{
    protected $entity;

    public function __construct(Image $image)
    {
        $this->entity = $image;
    }

    /**
     * Undocumented function
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllWithProduct()
    {
        return $this->entity->with('product')->get();
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return mixed
     */
    public function findWithProduct(int $id)
    {
        return $this->entity->with('product')->find($id);
    }


    /**
     * Undocumented function
     *
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllImageForProduct(int $id)
    {
        return $this->entity->where('product_id', $id)->get();
    }
}
