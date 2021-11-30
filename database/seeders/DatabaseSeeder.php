<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $created = User::create([
            "name" => "admin",
            "email" => "lks137610@gmail.com",
            "password" => "password123",
            "level" => "5"
        ]);

        event(new Registered($created));
    }
}
