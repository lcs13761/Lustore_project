<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "image" => $this->faker->imageUrl($width = 640, $height = 480),
            "product_id" => $this->faker->numberBetween($min = 1, $max = 10) 
        ];
    }
}
