<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'color' => $this->faker->safeColorName,
            'brand_id' => $this->faker->numberBetween(1, 5),
            'stock_quantity' => $this->faker->numberBetween(1, 100),
            'sku' => $this->faker->unique()->numerify('SKU-#####'),
            'barcode' => $this->faker->unique()->ean13,
            'material' => $this->faker->randomElement(['cotton', 'polyester', 'wool']),
            'gender' => $this->faker->randomElement(['male', 'female', 'unisex']),
            'weight' => $this->faker->randomFloat(2, 0.1, 5),
            'dimensions' => $this->faker->randomElement(['10x10x1', '20x15x2', '30x20x3']),
            'is_active' => $this->faker->boolean,
        ];
    }
}
