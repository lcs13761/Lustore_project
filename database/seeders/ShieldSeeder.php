<?php

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class ShieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Config::set('filament-shield.discovery', [
            'discover_all_resources' => true,
            'discover_all_widgets' => true,
            'discover_all_pages' => true,
        ]);

        Artisan::call('shield:generate', [
            '--all' => true,
            '--minimal' => true,
        ]);

        $this->createRole('admin');
    }

    protected function createRole($name)
    {
        return Utils::getRoleModel()::firstOrCreate([
            'name' => $name,
            'guard_name' => 'web',
        ]);
    }
}
