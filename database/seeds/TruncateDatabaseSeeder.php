<?php

use Illuminate\Database\Seeder;

class TruncateDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') == 'local') {
            DB::table('users')->truncate();
            DB::table('gadz')->truncate();
        }
    }
}
