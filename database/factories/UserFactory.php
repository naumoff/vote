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
	$userIDs = \App\User::getAllUsersIds();
	$kittensPhotos = kittensPhotos();
	dd($kittensPhotos);
	return [
		'owner_id'=>$userIDs[rand(0,count($userIDs)-1)],
		'type'=>'kitten',
		'name'=>$faker->name,
		'photo'=>'',
		'victories'=>0,
		'failures'=>0,
		'score'=>0
	];
});

$factory->define(App\Kitten::class, function(Faker $faker){
	return [
	
	];
});

#region SERVICE METHODS
function kittensPhotos()
{
	$files = Storage::files('kittens');
	return $files;
}

function puppiesPhotos()
{
	$files = Storage::files('puppies');
	return $files;
}
#endregion

