<?php



//class ProductTest extends TestCase
//{
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function test_product_index()
//    {
//        $this->getJson(route('products.index'))->assertOk();
//    }
//
//    /**
//     * Undocumented function
//     *
//     * @return void
//     */
//    public function test_product_store()
//    {
//        Category::factory()->create();
//
//        $data = [
//            "code_product" => $this->faker->randomNumber($nbDigits = 9, $strict = false),
//            'barcode' => $this->faker->randomNumber($nbDigits = 9, $strict = false),
//            "product" => $this->faker->sentence($nbWords = 4, $variableNbWords = true),
//            "category" => 1,
//            "costValue" => $this->faker->randomFloat($nbMaxDecimals = null, $min = 0, $max = null),
//            "saleValue"  => $this->faker->randomFloat($nbMaxDecimals = null, $min = 0, $max = null),
//            "description" => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
//            "size" => $this->faker->randomNumber($nbDigits = null, $strict = false),
//            "qts" => $this->faker->randomNumber($nbDigits = null, $strict = false),
//            "images" => [$this->faker->imageUrl(), $this->faker->imageUrl(), $this->faker->imageUrl()],
//        ];
//        ;
//
//
//        $this->postJson(route('products.store', $data))->assertJsonMissingValidationErrors();
//
//        $this->assertDatabaseHas('products', collect($data)->except(['category', 'images'])->all());
//    }
//
//    /**
//     * Undocumented function
//     *
//     * @return void
//     */
//    public function test_product_show()
//    {
//        Category::factory()->create();
//
//        $product = Product::factory()->create([
//            'category_id' => 1
//        ]);
//
//        $this->getJson(route('products.show', ['product' => $product->id]))->assertOk();
//    }
//
//    /**
//     * Undocumented function
//     *
//     * @return void
//     */
//    public function test_product_update()
//    {
//        Category::factory()->create();
//
//        $product = Product::factory()->create([
//            'category_id' => 1
//        ]);
//
//        $images =  [$this->faker->imageUrl()];
//
//        $newImage = collect($images)->map(fn ($data) => ['image' => $data]);
//
//        $product->images()->createMany($newImage);
//
//        $data = [
//            "description" => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
//            "images" => [$this->faker->imageUrl(), $this->faker->imageUrl()],
//        ];
//
//        $this->putJson(route('products.update', ['product' => $product->id]), $data)->assertJsonMissingValidationErrors();
//
//        $this->assertDatabaseHas('products', collect($data)->except(['images'])->all());
//
//        collect($data['images'])->each(function ($image) {
//            $this->assertDatabaseHas('images', ['image' => $image]);
//        });
//    }
//}
