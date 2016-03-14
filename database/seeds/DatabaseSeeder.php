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

        factory(App\User::class, 100)->create();

        // DB::rollBack();
        DB::commit();
    }
}
