<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::factory()->count(5)->create();
        //
        $products = Product::factory()->count(10)->create();

        $products->each(function ($product) {
            $product->categories()->attach(rand(1, 5));

            $product->addMediaFromUrl(fake()->imageUrl(640, 480, 'fashion'))
                ->toMediaCollection('products');
        });
    }
}
