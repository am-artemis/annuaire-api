<?php

namespace Tests\Models;

use App\Models\Photo;
use App\Models\User;
use Tests\TestCase;

class PhotoTest extends TestCase
{

    public function testSrcDansLeCasdUnLien()
    {
        $user = factory(User::class)->create();
        $photo = $user->photos()->create(['src'=> 'http://essai', 'type' =>'profile', 'title' => 'essai']);
        $this->assertEquals('http://essai', $photo->src);

        $photo2 = $user->photos()->create(['src'=> 'https://essai', 'type' =>'profile', 'title' => 'essai']);
        $this->assertEquals('https://essai', $photo2->src);

    }

    public function testSrcDansLeCasdUnPath()
    {
        $user = factory(User::class)->create();
        $photo = $user->photos()->create(['src'=> 'essai', 'type' =>'profile', 'title' => 'essai']);
        $this->assertEquals(url('essai'), $photo->src);
    }
}
