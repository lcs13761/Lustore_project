<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';
    protected $fillable = ["cep","state","district","street","number","complement","user_id"];


    public function user(){
        return $this->hasOne(User::class);
    }
}
