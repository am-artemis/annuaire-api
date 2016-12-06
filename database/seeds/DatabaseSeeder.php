<?php

use App\Models\Campus;
use App\Models\User;
use App\Services\AlgoliaService;
use Illuminate\Database\Seeder;

use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        $this->call('ResidenceTableSeeder');
        $this->call('CourseTableSeeder');
        $this->call('DegreeTableSeeder');
        $this->call('SocialTableSeeder');

        $this->call('CustomUserSeeder');

        factory(App\Models\User::class, 10)->create()->each(function (User $user) {
            // 3 chances sur 4 d'avoir un gadz
            $campuses = Campus::all();
            if (mt_rand(0, 3)) {
                $user->gadz()->save(factory(App\Models\Gadz::class)->make(['proms' => $user->year - 1800]));
                $campus_id = $campuses->reject(function (Campus $campus) {
                    return $campus->prefix === null;
                })->random()->id;
            } else {
                $campus_id = $campuses->filter(function (Campus $campus) {
                    return $campus->prefix === null;
                })->random()->id;
            }
            $user->update(compact('campus_id'));

            // Photos
            for ($i = mt_rand(0, 4); $i > 0; $i--) {
                $user->photos()->save(factory(App\Models\Photo::class)->make());
            }

            // Addresses
            for ($i = mt_rand(0, 2); $i > 0; $i--) {
                $user->addresses()->save(factory(App\Models\Address::class)->make());
            }

            // Residence
            App\Models\Residence::get(['id'])->random(3)->each(function ($residence) use ($user) {
                if (mt_rand(0, 1)) {
                    $pivot = [
                        'room' => mt_rand(101, 799),
                        'from' => Carbon::now()->subDays(mt_rand(50, 1540)),
                        'to'   => Carbon::now()->addDays(mt_rand(50, 1540)),
                    ];
                    $user->residences()->attach($residence->id, $pivot);
                }
            });

            // Course
            App\Models\Course::get(['id'])->random(3)->each(function ($course) use ($user) {
                if (mt_rand(0, 1)) {
                    $pivot = [
                        'from' => Carbon::now()->subDays(mt_rand(50, 1540)),
                        'to'   => Carbon::now()->addDays(mt_rand(50, 1540)),
                    ];
                    $user->courses()->attach($course->id, $pivot);
                }
            });

            // Degree
            App\Models\Degree::get(['id'])->random(3)->each(function ($degree) use ($user) {
                if (mt_rand(0, 1)) {
                    $pivot = [
                        'year' => mt_rand(2010, 2018),
                    ];
                    $user->degrees()->attach($degree->id, $pivot);
                }
            });

            // Responsibility
            for ($i = mt_rand(0, 2); $i > 0; $i--) {
                $user->responsibilities()->save(factory(App\Models\Responsibility::class)->make());
            }

            // Jobs
            for ($i = mt_rand(0, 2); $i > 0; $i--) {
                $user->jobs()->save(factory(App\Models\Job::class)->make());
            }

            App\Models\Social::get(['id'])->random(3)->each(function ($social) use ($user) {
                if (mt_rand(0, 1)) {
                    $pivot = [
                        'url' => 'test' . mt_rand(10000, 99999) . '.url',
                    ];
                    $user->socials()->attach($social->id, $pivot);
                }
            });
        });

        // DB::rollBack();
        DB::commit();
        dump('Seed done on database');
        dump('Populating Algolia...');
        $algolia = app()->make(AlgoliaService::class);
        $algolia->reIndexUsers();

        dump('Seed done !');
    }
}
