<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{

    /**
     * A basic feature test example.
     *@test
     * @return void
     */
    public function getTest()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }
    /**
     * A basic feature test example.
     *@test
     * @return void
     */
    public function createTest()
    {
        $response = $this->json('POST', "/api/product/create", [
            "code" => $this->faker->numberBetween($min = 1, $max = 9000),
            "product" => $this->faker->name(),
            "saleValue" => $this->faker->randomDigitNot(0),
            "costValue" => $this->faker->randomDigitNot(0),
            "size" => $this->faker->randomDigitNot(0),
            "qts" => $this->faker->randomDigitNot(0),
            "category" => [
                "id" => $this->faker->randomDigitNot(0)
            ],
            "description" => $this->faker->word,
            "image" => $this->faker->imageUrl($width = 640, $height = 480),
        ], [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTYzNTE4MDczNSwiZXhwIjoxNjM1MTg0MzM1LCJuYmYiOjE2MzUxODA3MzUsImp0aSI6IkNKOEpyZG1pcFJPRjdjSEYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJ1c2VyIjp7Im5hbWUiOiJhZG1pbiIsImVtYWlsIjoibGNzMTM3NjFAaG90bWFpbC5jb20iLCJsZXZlbCI6IjUifX0.GlGzPWsk33rGR8gMItbwVoOsBjnM7DkNYrc1CzX5OPc"
        ]);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *@test
     * @return void
     */
    public function updateTest()
    {
        $response = $this->json('PUT', "/api/product/update/1", [
            "code" => $this->faker->randomDigitNot(0),
            "product" => $this->faker->name(),
            "saleValue" => $this->faker->randomDigitNot(0),
            "costValue" => $this->faker->randomDigitNot(0),
            "size" => $this->faker->randomDigitNot(0),
            "qts" => $this->faker->randomDigit(),
            "category" => [
                "id" => $this->faker->randomDigitNot(0)
            ],
            "description" => $this->faker->word,
            "image" => [
                [
                    "id" => 2,
                    "image" =>  $this->faker->imageUrl($width = 640, $height = 480)
                ]
            ],
        ], [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTYzNTE4MDczNSwiZXhwIjoxNjM1MTg0MzM1LCJuYmYiOjE2MzUxODA3MzUsImp0aSI6IkNKOEpyZG1pcFJPRjdjSEYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJ1c2VyIjp7Im5hbWUiOiJhZG1pbiIsImVtYWlsIjoibGNzMTM3NjFAaG90bWFpbC5jb20iLCJsZXZlbCI6IjUifX0.GlGzPWsk33rGR8gMItbwVoOsBjnM7DkNYrc1CzX5OPc"
        ]);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *@test
     * @return void
     */
    public function deleteTest()
    {
        // $response = $this->delete("/api/product/delete/2", [], [
        //     'Authorization' => 'Bearer ' . "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTYzNTE4MDczNSwiZXhwIjoxNjM1MTg0MzM1LCJuYmYiOjE2MzUxODA3MzUsImp0aSI6IkNKOEpyZG1pcFJPRjdjSEYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJ1c2VyIjp7Im5hbWUiOiJhZG1pbiIsImVtYWlsIjoibGNzMTM3NjFAaG90bWFpbC5jb20iLCJsZXZlbCI6IjUifX0.GlGzPWsk33rGR8gMItbwVoOsBjnM7DkNYrc1CzX5OPc"
        // ]);

        // $response->assertStatus(200);
    }
}
