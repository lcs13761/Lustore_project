<?php

namespace Database\Seeders;

use App\Models\State;
use Database\Seeders\Signature\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        State::insert(File::json(resource_path('json/state.json'))['states']);
    }


}
