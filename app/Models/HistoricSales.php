<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricSales extends Model
{
    use HasFactory;
    protected $table = 'historicsales';
    
    protected $guarded = [];  

    
}
