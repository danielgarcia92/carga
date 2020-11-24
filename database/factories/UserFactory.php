<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'      => 'Daniel García Vergara',
        'rol'       => 'admin',
        'area'      => 'N/A',
        'email'     => 'daniel.garciav@vivaaerobus.com',
        'password'  => Hash::make('SJD+2020'),
        'active'    => 1,
        'remember_token' => Str::random(10),
    ];
});
