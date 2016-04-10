<?php

use Illuminate\Database\Seeder;

class DegreeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Degree::class, 50)->create();
    }
}
