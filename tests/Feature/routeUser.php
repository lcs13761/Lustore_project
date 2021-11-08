<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class routeUser extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function route_login_onexpect_code()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
