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
    public function definition()
    {
        return [
            "code" => $this->faker->randomNumber($nbDigits = 9, $strict = false),
            "product" => $this->faker->sentence($nbWords = 4, $variableNbWords = true),
            "category_id" => $this->faker->numberBetween($min = 1, $max = 10),
            "costValue" => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
            "saleValue"  => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
            "description" => $this->faker->sentence($nbWords = 6, $variableNbWords = true) ,
            "size" => $this->faker->randomNumber($nbDigits = NULL, $strict = false),
            "qts" => $this->faker->randomNumber($nbDigits = NULL, $strict = false)
        ];
    }
}
