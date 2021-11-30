<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;


class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $hidden = ["password" , "created_at" , "updated_at"];
    protected $table = 'users';
    protected $fillable = ["photo","name","email","cpf","level","phone","password"];
    protected $casts = 
    [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }

    public function address(){
        return $this->hasMany(Address::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'user' => [
                'name' => $this->name,
                'email' => $this->email,
                "level" => $this->level
            ]
        ];
    }

}
