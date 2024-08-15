<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'LuStore',
            'email' => 'admin@lustore.com',
        ]);

        $admin->assignRole('super_admin');

        User::factory(10)->create();
    }
}
