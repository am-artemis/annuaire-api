<?php

namespace Tests\Models;

use App\Models\Photo;
use App\Models\User;
use Tests\TestCase;

class PhotoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSrc()
    {
        $this->seed();
        $user = factory(User::class)->create();
        $photo = $user->photos()->create(['src'=> '', 'type' =>'profile', 'title' => 'essai']);
        $photo->src = 'essai';
        $this->assertEquals(url('essai'), $photo->src);
        $photo->src = 'http://essai';
        $this->assertEquals('http://essai', $photo->src);
        $photo->src = 'https://essai';
        $this->assertEquals('https://essai', $photo->src);
    }
}
