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

$factory->define(App\User::class, function ($faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'year' => rand(2012, 2014),
        'birthday' => Carbon\Carbon::now()->subYears(rand(17,25))->subDays(rand(0,365)),
        'campus_id' => App\Campus::whereNull('prefix', 'and', true)->get(['id'])->random()->id,
        'gender' => array(null, 'm', 'f')[rand(0,2)],
        'mail' => $faker->email,
        'phone' => '06' . str_pad(rand(1,pow(10, 8)), 8, '0', STR_PAD_LEFT),
        'created_at' => Carbon\Carbon::now(),
        'updated_at' => Carbon\Carbon::now(),
    ];
});
