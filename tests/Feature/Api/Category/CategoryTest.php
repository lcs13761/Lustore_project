<?php

it('returns a successful response', function () {
    $response = $this->get(route('categories.index'));

    $response->assertStatus(200);
});

//class CategoryTest extends TestCase
//{
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function test_category_index()
//    {
//        $response = $this->get(route('categories.index'));
//
//        $response->assertStatus(200);
//    }
//
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function test_category_show()
//    {
//        $category = Category::factory()->create();
//
//        $response = $this->get(route('categories.show', ['category' => $category->id]));
//
//        $response->assertStatus(200);
//    }
//
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function test_category_store()
//    {
//        $data = [
//            "name" => $this->faker->name(),
//            'description' => $this->faker->word(),
//            'image' => $this->faker->imageUrl(),
//            'active' => true
//        ];
//
//        $response = $this->post(route('categories.store'), $data);
//        $response->assertSessionHasNoErrors();
//        $this->assertDatabaseHas('categories', collect($data)->except(['active', 'image'])->all());
//        $response->assertStatus(200);
//    }
//
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function test_category_update()
//    {
//        $category = Category::factory()->create();
//
//        $data = [
//            "name" => $this->faker->name(),
//            'description' => $this->faker->word(),
//            'image' => $this->faker->imageUrl(),
//            'active' => true
//        ];
//
//
//        $response = $this->put(route('categories.update', ['category' => $category->id]), $data);
//        $response->assertSessionHasNoErrors();
//        $this->assertDatabaseHas('categories', collect($data)->except(['active', 'image'])->all());
//        $response->assertStatus(200);
//    }
//
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function test_category_destroy()
//    {
//        $category = Category::factory()->create();
//
//        $response = $this->delete(route('categories.destroy', ['category' => $category->id]));
//
//        $category = Category::find($category->id);
//
//        $this->assertNull($category);
//
//        $response->assertStatus(200);
//    }
//}
