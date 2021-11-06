<?php

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *@test
     * @return void
     */
    public function test_create()
    {
        $response = $this->json("POST" , "/api/category/register",[
            "category" => $this->faker->name()
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
    public function test_update()
    {
        $response = $this->json("PUT" , "/api/category/update/1",[
            "category" => $this->faker->name()
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
    public function test_delete()
    {
        // $response = $this->delete("/api/category/delete/" . $this->faker->randomDigitNot(0),[
        //     "category" => $this->faker->name()
        // ], [
        //     'Content-Type' => 'application/json',
        //     'Authorization' => 'Bearer ' . "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTYzNTE4MDczNSwiZXhwIjoxNjM1MTg0MzM1LCJuYmYiOjE2MzUxODA3MzUsImp0aSI6IkNKOEpyZG1pcFJPRjdjSEYiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJ1c2VyIjp7Im5hbWUiOiJhZG1pbiIsImVtYWlsIjoibGNzMTM3NjFAaG90bWFpbC5jb20iLCJsZXZlbCI6IjUifX0.GlGzPWsk33rGR8gMItbwVoOsBjnM7DkNYrc1CzX5OPc"
        // ]);

        // $response->assertStatus(200);
    }
}
