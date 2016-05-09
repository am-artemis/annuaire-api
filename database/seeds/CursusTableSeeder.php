<?php

use Illuminate\Database\Seeder;

use App\Models\Campus;

class CursusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Cursus::class, 50)->create();
    }
}
