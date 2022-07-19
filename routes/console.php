<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('seed', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    //base de dados (default)
    $database = '';

    /**
     * limpando a base e rodando migrations e seeders
     */

    $this->comment('Limpando tabelas existentes da base de dados...');
    Artisan::call("db:wipe $database");

    $this->comment('Migrando tabelas do sistema...');
    Artisan::call("migrate $database");

    $this->comment('Rodando seeders com o ponto inicial da aplicacão...');
    Artisan::call("db:seed $database");


})->purpose('Migrate e seeders necessários para rodar o ponto inicial da aplicação.');
