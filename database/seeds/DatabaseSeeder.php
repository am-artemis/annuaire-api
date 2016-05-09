<?php

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

        $this->call('CampusTableSeeder');
        $this->call('ResidenceTableSeeder');
        $this->call('CourseTableSeeder');
        $this->call('DegreeTableSeeder');
        $this->call('SocialTableSeeder');

        factory(App\Models\User::class, 100)->create()->each(function($user) {
            // 4 chances sur 5 d'avoir un gadz
            if (rand(0,4)) {
                $user->gadz()->save(factory(App\Models\Gadz::class)->make());
            }

            // Photos
            for ($i=rand(0,4); $i > 0 ; $i--) {
                $user->photos()->save(factory(App\Models\Photo::class)->make());
            }

            // Addresses
            for ($i=rand(0,2); $i > 0 ; $i--) {
                $user->addresses()->save(factory(App\Models\Address::class)->make());
            }

            // Residence
            App\Models\Residence::get(['id'])->random(3)->each(function ($residence) use ($user) {
                if(rand(0,1)) {
                    $pivot = [
                        'room' => rand(101, 799),
                        'from' => Carbon::now()->subDays(rand(50,1540)),
                        'to' => Carbon::now()->addDays(rand(50,1540)),
                        ];
                    $user->residences()->attach($residence->id, $pivot);
                }
            });

            // Course
            App\Models\Course::get(['id'])->random(3)->each(function ($course) use ($user) {
                if(rand(0,1)) {
                    $pivot = [
                        'from' => Carbon::now()->subDays(rand(50,1540)),
                        'to' => Carbon::now()->addDays(rand(50,1540)),
                        ];
                    $user->courses()->attach($course->id, $pivot);
                }
            });

            // Degree
            App\Models\Degree::get(['id'])->random(3)->each(function ($degree) use ($user) {
                if(rand(0,1)) {
                    $pivot = [
                        'year' => rand(2010, 2018),
                        ];
                    $user->degrees()->attach($degree->id, $pivot);
                }
            });

            // Responsibility
            for ($i=rand(0,2); $i > 0 ; $i--) {
                $user->responsibilities()->save(factory(App\Models\Responsibility::class)->make());
            }

            // Jobs
            for ($i=rand(0,2); $i > 0 ; $i--) {
                $user->jobs()->save(factory(App\Models\Job::class)->make());
            }

            App\Models\Social::get(['id'])->random(3)->each(function ($social) use ($user) {
                if(rand(0,1)) {
                    $pivot = [
                        'url' => 'test'.rand(10000,99999).'.url',
                        ];
                    $user->socials()->attach($social->id, $pivot);
                }
            });
        });

        // DB::rollBack();
        DB::commit();
    }
}
