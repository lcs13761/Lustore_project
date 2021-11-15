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
          "password" => Hash::make("password123"),
          "level" => "5"
      ]);

        event(new Registered($created));

        \App\Models\Category::factory(10)->create();
        \App\Models\Product::factory(10)->create();
        \App\Models\Image::factory(10)->create();

    }
}
