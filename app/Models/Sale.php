<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';
    public $timestamps = false;
    protected $fillable = ["client","product_id","salesman","saleValue","size","qts","discount"];

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
