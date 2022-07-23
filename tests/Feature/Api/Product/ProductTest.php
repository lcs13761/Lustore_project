<?php

namespace Tests\Feature\Api\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_product_index()
    {
        $this->getJson(route('products.index'))->assertOk();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_user_store()
    {
        $password =  $this->faker->word();

        Category::factory()->create();

        $data = [
            "code_product" => $this->faker->randomNumber($nbDigits = 9, $strict = false),
            'barcode' => $this->faker->randomNumber($nbDigits = 9, $strict = false),
            "product" => $this->faker->sentence($nbWords = 4, $variableNbWords = true),
            "category" => 1,
            "costValue" => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
            "saleValue"  => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
            "description" => $this->faker->sentence($nbWords = 6, $variableNbWords = true) ,
            "size" => $this->faker->randomNumber($nbDigits = NULL, $strict = false),
            "qts" => $this->faker->randomNumber($nbDigits = NULL, $strict = false)
        ];;


        $this->postJson(route('products.store', $data))->assertJsonMissingValidationErrors();

        $this->assertDatabaseHas('products',collect($data)->except('category')->all());
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_user_show()
    {
        Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => 1
        ]);

        $this->getJson(route('products.show', ['product' => $product->id]))->assertOk();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_user_update()
    {
        Category::factory()->create();

        $product = Product::factory()->create([
            'category_id' => 1
        ]);

        $data = [
            "description" => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        ];

        $this->putJson(route('products.update', ['product' => $product->id]), $data)->assertJsonMissingValidationErrors();

        $this->assertDatabaseHas('products', $data);
    }
}
