<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';
    public $timestamps = false;
    protected $fillable = ["code" ,"client","product","product_id","saleValue","size","qts","category_id"];
}
