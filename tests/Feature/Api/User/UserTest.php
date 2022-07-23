<?php

namespace Tests\Feature\Api\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_index()
    {
        $this->getJson(route('users.index'))->assertOk();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_user_store()
    {
        $password =  $this->faker->word();

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $password,
            'password_confirmation' => $password
        ];

        Event::fake();

        $this->postJson(route('users.store', $data))->assertJsonMissingValidationErrors();

        $this->assertDatabaseHas('users', collect($data)->except(['password', 'password_confirmation'])->all());

        Event::assertDispatched(Registered::class);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_user_show()
    {
        $user = User::factory()->create();
        $this->getJson(route('users.show', ['user' => $user->id]))->assertOk();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function test_user_update()
    {
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ];

        $this->putJson(route('users.update', ['user' => $user->id]), $data)->assertJsonMissingValidationErrors();

        $this->assertDatabaseHas('users', $data);
    }
}
