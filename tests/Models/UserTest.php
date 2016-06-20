<?php

namespace Tests\Models;

use App\Models\Photo;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function testUserProfilePhotoSiPhoto()
    {
        $user = factory(User::class)->create();
        $user->photos()->create(['src'=> 'http://essai', 'type' =>'profile', 'title' => 'essai']);
        $this->assertEquals('http://essai', $user->profile_photo);
    }

    public function testUserProfilePhotoSiPasPhoto()
    {
        $user = factory(User::class)->create();
        $this->assertEquals(url(Photo::PROFILE_DEFAULT), $user->profile_photo);
    }
}
