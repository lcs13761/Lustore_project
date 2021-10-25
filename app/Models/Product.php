<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $hidden = [ "created_at" , "updated_at"];
    protected $table = 'products';
    protected $fillable = ["code" , "product" , "category_id","saleValue","costValue","size","qts","allQts","description"];


    public function image(){
        return $this->hasMany(Image::class);
    }

}
