<?php

use Illuminate\Database\Seeder;

class SocialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('socials')->insert(
            [
                ['name' => 'Facebook', 'logo' => 'facebook.png'],
                ['name' => 'Twitter', 'logo' => 'twitter.png'],
                ['name' => 'Google+', 'logo' => 'googleplus.png'],
                ['name' => 'Blogger', 'logo' => 'blogger.png'],
                ['name' => 'Tumblr', 'logo' => 'tumblr.png'],
                ['name' => 'reddit', 'logo' => 'reddit.png'],
                ['name' => 'Pinterest', 'logo' => 'pinterest.png'],
                ['name' => 'LinkedIn', 'logo' => 'linkedin.png'],
                ['name' => 'Snapchat', 'logo' => 'snapchat.png'],
                ['name' => 'Site perso', 'logo' => 'perso.png'],
            ]);
    }
}
