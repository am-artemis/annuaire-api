<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
        Model::unguard();

        $this->call('CampusTableSeeder');
        $this->call('ResamTableSeeder');

        factory(App\User::class, 100)->create()->each(function($user) {
            // 4 chances sur 5 d'avoir un gadz
            if (rand(0,4)) {
                $user->gadz()->save(factory(App\Gadz::class)->make());
            }

            // Photos
            for ($i=rand(0,4); $i > 0 ; $i--) {
                $user->photos()->save(factory(App\Photo::class)->make());
            }

            // Address
            for ($i=rand(0,2); $i > 0 ; $i--) {
                $user->addresses()->save(factory(App\Address::class)->make());
            }

            // Resam
            App\Resam::get(['id'])->random(3)->each(function ($resam) use ($user) {
                if(rand(0,1)) {
                    $dates = [
                        'room' => rand(101, 799),
                        'from' => Carbon::now()->subDays(rand(50,1540)),
                        'to' => Carbon::now()->addDays(rand(50,1540)),
                        ];
                    $user->resams()->attach($resam->id, $dates);
                }
            });
        });

        // DB::rollBack();
        DB::commit();
    }
}
