<?php

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'firstname'  => $faker->firstName,
        'lastname'   => $faker->lastName,
        'year'       => $year = mt_rand(2012, 2016),
        'birthday'   => Carbon\Carbon::now()->subYears(mt_rand(17, 25))->subDays(mt_rand(0, 365)),
        'campus_id'  => App\Models\Campus::all()->random()->id,
        'gender'     => [null, 'm', 'f'][mt_rand(0, 2)],
        'email'      => $faker->email,
        'phone'      => '06' . str_pad(mt_rand(1, pow(10, 8)), 8, '0', STR_PAD_LEFT),
        'tags'       => 'all' . (mt_rand(0, 4) ? (',' . implode(',', $faker->words(mt_rand(2, 7)))) : null),
        'created_at' => Carbon\Carbon::now(),
        'updated_at' => Carbon\Carbon::now(),
    ];
});

$factory->define(App\Models\Gadz::class, function (Faker\Generator $faker) {
    $fams = $faker->randomElements([mt_rand(1, 154), mt_rand(1, 154), mt_rand(1, 154)], $count = mt_rand(1, 3));
    asort($fams);

    return [
        'buque'      => ucfirst($faker->word),
        'fams'       => implode('-', $fams),
        'famsSearch' => implode(',', $fams),
        'proms'      => mt_rand(212, 216),
        'created_at' => Carbon\Carbon::now(),
        'updated_at' => Carbon\Carbon::now(),
    ];
});

$factory->define(App\Models\Photo::class, function (Faker\Generator $faker) {
    return [
        'src'   => $faker->imageUrl(400, 400, 'people'),
        'type'  => ['profile', 'biaude'][mt_rand(0, 1)],
        'title' => $faker->sentence(mt_rand(4, 8), true),
    ];
});

$factory->define(App\Models\Address::class, function (Faker\Generator $faker) {
    return [
        'name'    => $faker->sentence(5),
        'address' => $faker->streetAddress,
        'zipcode' => $faker->postcode,
        'city'    => $faker->city,
        'country' => $faker->country,
        'lat'     => $faker->latitude(-90, 90),
        'lng'     => $faker->longitude(-180, 180),
        'phone'   => '0' . mt_rand(1, 5) . str_pad(mt_rand(1, pow(10, 8)), 8, '0', STR_PAD_LEFT),
        'from'    => Carbon\Carbon::now()->subMonths(mt_rand(17, 70))->subDays(mt_rand(0, 30)),
        'to'      => [Carbon\Carbon::now()->subMonths(mt_rand(-20, 16))->subDays(mt_rand(0, 30)), null][mt_rand(0, 1)],
        'type'    => ['perso', 'family'][mt_rand(0, 1)],
    ];
});

$factory->define(App\Models\Course::class, function (Faker\Generator $faker) {
    // Permits to link school and campus randomisation
    $has_campus = mt_rand(0, 1);
    return [
        'title'       => $faker->sentence(6),
        'description' => $faker->sentences(3, true),
        'campus_id'   => $has_campus ? App\Models\Campus::all()->random()->id : null,
        'school'      => $has_campus ? null : 'Ecole ' . $faker->sentence(3),
    ];
});

$factory->define(App\Models\Degree::class, function (Faker\Generator $faker) {
    return [
        'title'  => $faker->sentence(mt_rand(4, 8)),
        'school' => $faker->sentence(mt_rand(2, 5)),
        'am'     => mt_rand(0, 1) ? true : false,
    ];
});

$factory->define(App\Models\Responsibility::class, function (Faker\Generator $faker) {
    $strass = ucfirst($faker->word);
    $roles = ['Zt', 'Vp', 'Respo', 'Xgnasse'];
    return [
        'title'     => $roles[mt_rand(0, count($roles) - 1)] . ' ' . $strass,
        'strass'    => $strass,
        'from'      => Carbon\Carbon::now()->subMonths(mt_rand(17, 70))->subDays(mt_rand(0, 30)),
        'to'        => [Carbon\Carbon::now()->subMonths(mt_rand(-20, 16))->subDays(mt_rand(0, 30)), null][mt_rand(0, 1)],
        'campus_id' => App\Models\Campus::all()->random()->id,
    ];
});

$factory->define(App\Models\Job::class, function (Faker\Generator $faker) {
    return [
        'title'       => $faker->sentence(mt_rand(4, 8)),
        'description' => $faker->sentences(3, true),
        'from'        => Carbon\Carbon::now()->subMonths(mt_rand(17, 70))->subDays(mt_rand(0, 30)),
        'to'          => [Carbon\Carbon::now()->subMonths(mt_rand(-20, 16))->subDays(mt_rand(0, 30)), null][mt_rand(0, 1)],
    ];
});
