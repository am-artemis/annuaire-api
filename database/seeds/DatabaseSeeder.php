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

        factory(App\User::class, 100)->create()->each(function($user) {
            // 4 chances sur 5 d'avoir un gadz
            if (rand(0,4)) {
                $user->gadz()->save(factory(App\Gadz::class)->make());
            }
        });

        // DB::rollBack();
        DB::commit();
    }
}
