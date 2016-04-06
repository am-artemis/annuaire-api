<?php

use Illuminate\Database\Seeder;

use App\Campus;

class CursusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Cursus::class, 50)->create();
    }
}
