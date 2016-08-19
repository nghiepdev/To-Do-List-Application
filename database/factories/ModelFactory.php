<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt(12345678),
        'remember_token' => str_random(60),
    ];
});

$factory->define(App\Models\Todo::class, function (Faker\Generator $faker) {
    return [
        'name'      => $faker->sentence(6),
        'completed' => (bool) rand(0, 1),
        'user_id'   => App\User::inRandomOrder()->first()->id,
    ];
});