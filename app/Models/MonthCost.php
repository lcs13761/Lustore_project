<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthCost extends Model
{
    use HasFactory;
    protected $table = 'monthcost';
    protected $fillable = ["value","month"];


}
