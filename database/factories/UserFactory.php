<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Animal::class, function(Faker $faker){
	return [
		'name'=>$faker->firstName,
		'victories'=>0,
		'failures'=>0,
		'score'=>0
	];
});

$factory->define(App\Kitten::class, function(Faker $faker){
	return [];
});

$factory->define(\App\Puppy::class, function(Faker $faker){
	return [];
});

