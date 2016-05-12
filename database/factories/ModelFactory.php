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

$factory->define(App\Models\User::class, function ($faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'year' => rand(2012, 2014),
        'birthday' => Carbon\Carbon::now()->subYears(rand(17, 25))->subDays(rand(0, 365)),
        'campus_id' => App\Models\Campus::whereNull('prefix', 'and', true)->get(['id'])->random()->id,
        'gender' => [null, 'm', 'f'][rand(0, 2)],
        'mail' => $faker->email,
        'phone' => '06'.str_pad(rand(1, pow(10, 8)), 8, '0', STR_PAD_LEFT),
        'tags' => rand(0, 4) ? implode(',', $faker->words(rand(2, 7))) : null,
        'created_at' => Carbon\Carbon::now(),
        'updated_at' => Carbon\Carbon::now(),
    ];
});

$factory->define(App\Models\Gadz::class, function ($faker) {
    $fams = $faker->randomElements([rand(1, 154), rand(1, 154), rand(1, 154)], $count = rand(1, 3));
    asort($fams);
    
    return [
        'buque' => ucfirst($faker->word),
        'fams' => implode('-', $fams),
        'famsSearch' => implode(',', $fams),
        'proms' => rand(212, 215),
        'created_at' => Carbon\Carbon::now(),
        'updated_at' => Carbon\Carbon::now(),
    ];
});

$factory->define(App\Models\Photo::class, function ($faker) {
    return [
        'src' => $faker->imageUrl(400, 400),
        'type' => ['profile', 'biaude'][rand(0, 1)],
        'title' => $faker->sentence(rand(4, 8), true),
    ];
});

$factory->define(App\Models\Address::class, function ($faker) {
    return [
        'name' => $faker->sentence(5),
        'address' => $faker->streetAddress,
        'zipcode' => $faker->postcode,
        'city' => $faker->city,
        'country' => $faker->country,
        'lat' => $faker->latitude(-90, 90),
        'lng' => $faker->longitude(-180, 180),
        'phone' => '0' . rand(1, 5) . str_pad(rand(1, pow(10, 8)), 8, '0', STR_PAD_LEFT),
        'from' => Carbon\Carbon::now()->subMonths(rand(17, 70))->subDays(rand(0, 30)),
        'to' => [Carbon\Carbon::now()->subMonths(rand(-20, 16))->subDays(rand(0, 30)), null][rand(0, 1)],
        'type' => ['perso', 'family'][rand(0, 1)],
    ];
});

$factory->define(App\Models\Course::class, function ($faker) {
    // Permits to link school and campus randomisation
    $has_campus = rand(0, 1);
    return [
        'title' => $faker->sentence(6),
        'description' => $faker->sentences(3, true),
        'campus_id' => $has_campus ? App\Models\Campus::all()->random()->id : null,
        'school' => $has_campus ? null : 'Ecole ' . $faker->sentence(3),
    ];
});

$factory->define(App\Models\Degree::class, function ($faker) {
    return [
        'title' => $faker->sentence(rand(4, 8)),
        'school' => $faker->sentence(rand(2, 5)),
        'am' => rand(0, 1) ? true : false,
    ];
});

$factory->define(App\Models\Responsibility::class, function ($faker) {
    $strass = ucfirst($faker->word);
    $roles = ['Zt', 'Vp', 'Respo', 'Xgnasse'];
    return [
        'title' => $roles[rand(0, count($roles) - 1)] . ' ' . $strass,
        'strass' => $strass,
        'from' => Carbon\Carbon::now()->subMonths(rand(17, 70))->subDays(rand(0, 30)),
        'to' => [Carbon\Carbon::now()->subMonths(rand(-20, 16))->subDays(rand(0, 30)), null][rand(0, 1)],
        'campus_id' => App\Models\Campus::all()->random()->id,
    ];
});

$factory->define(App\Models\Job::class, function ($faker) {
    $strass = ucfirst($faker->word);
    $roles = ['Zt', 'Vp', 'Respo', 'Xgnasse'];
    return [
        'title' => $faker->sentence(rand(4, 8)),
        'description' => $faker->sentences(3, true),
        'from' => Carbon\Carbon::now()->subMonths(rand(17, 70))->subDays(rand(0, 30)),
        'to' => [Carbon\Carbon::now()->subMonths(rand(-20, 16))->subDays(rand(0, 30)), null][rand(0, 1)],
    ];
});

$factory->define(App\Models\Campus::class, function ($faker) {
    $city = ucfirst($faker->word);
    return [
        'name' => ['Tabagn\'s', 'KIN', 'Jardin', 'Boquette', 'Institut', 'Campus'][rand(0, 5)] . ' de ' . $city,
        'city' => $city,
        'short' => preg_replace('#(?<=[bcdfghjklmnpqrstvwxz])[aeiouy]+[nmts]{0,1}$#', '$1\'s', $city),
        'prefix' => substr(strtolower($city), 0, 2),
        'address' => 'Rue Jenesaisquoi, ' . rand(10000, 99999) . ' ' . $city,
        'lat' => $faker->latitude(-90, 90),
        'lng' => $faker->longitude(-180, 180),
        'photo' => 'campus/' . strtolower($city) . '.jpg',
    ];
});
    