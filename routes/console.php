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

Artisan::command('project:init', function () {
    $this->info('Running Database migrations ...');
    Artisan::call('migrate');
    $this->info('Database Migrations ended ...');
    $this->info('Running Seeds ...');
    Artisan::call('db:seed');
    $this->info('Seeds ended ...');
    $this->info('Generating key ...');
    Artisan::call('key:generate');
    $this->info('Key generated successfully!');
})->describe('Running commands');
